<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AcceptResidency;
use App\Mail\RejectPayment;
use App\Mail\RejectResidency;
use App\Mail\VerifyWithRoom;
use App\Models\ApplyResidency;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use App\Models\UserRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ResidencyController extends Controller
{
    public function index()
    {
        $dataType = 'pengajuan';
        $residencies = ApplyResidency::with('user')->get();
        $rooms = Room::all();

        foreach ($residencies as $residency) {
            $payment = Payment::where('user_id', $residency->user_id)
                              ->where('status', 'pending')
                              ->orderBy('created_at', 'desc')
                              ->first();

            if ($payment && $payment->proof) {
                $residency->payment_status = 'Sudah Bayar';
                $residency->payment_proof = $payment->proof;
            } else {
                $residency->payment_status = 'Belum Bayar';
                $residency->payment_proof = null;
            }

            $userRoom = UserRoom::where('user_id', $residency->user_id)->first();

            if ($userRoom) {
                $residency->room_name = $userRoom->room->name;
            } else {
                $residency->room_name = 'Belum Ditetapkan';
            }
        }

        return view('admin.residencies.index', compact('dataType', 'residencies', 'rooms'));
    }

    public function acceptApplyResidency($id)
    {
        $adminId = auth('admin')->user()->id;
        $appliedResidency = ApplyResidency::with('user')->findOrFail($id);

        if ($appliedResidency->verified_by || $appliedResidency->verified_at) {
            toast('Pengajuan penghuni sudah terverifikasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $appliedResidency->verified_by = $adminId;
        $appliedResidency->verified_at = now();
        $appliedResidency->status = 'pending-payment';
        $appliedResidency->save();

        Mail::to($appliedResidency->user->email)->send(new AcceptResidency($appliedResidency));

        toast('Pengajuan penghuni berhasil diverifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function rejectApplyResidency($id)
    {
        $adminId = auth('admin')->user()->id;
        $appliedResidency = ApplyResidency::with('user')->findOrFail($id);

        if ($appliedResidency->verified_by || $appliedResidency->verified_at) {
            toast('Pengajuan penghuni sudah terverifikasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $appliedResidency->verified_by = $adminId;
        $appliedResidency->verified_at = now();
        $appliedResidency->status = 'rejected';
        $appliedResidency->updated_at = now();
        $appliedResidency->reason =
        'Kami mohon maaf, pengajuan Anda tidak dapat diproses lebih lanjut saat ini karena tidak ada kamar  yang tersedia di asrama. Kami akan menginformasikan kepada Anda jika ada perubahan ketersediaan kamar di masa depan. Silakan ajukan kembali pengajuan Anda jika ada kesempatan atau ketersediaan kamar pada periode berikutnya. Terima kasih atas perhatian dan kesabaran Anda.';

        $appliedResidency->save();

        Mail::to($appliedResidency->user->email)->send(new RejectResidency($appliedResidency));

        toast('Pengajuan penghuni berhasil ditolak.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function verifyOrReject(Request $request, $id)
    {
        $action = $request->input('action');

        if ($action == 'verify') {
            return $this->verifyWithRoom($request, $id);
        } elseif ($action == 'reject') {
            return $this->rejectPayment($id);
        }

        toast('Aksi tidak dikenali.','error')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function verifyWithRoom(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
        ], [
            'room_id.required' => 'Kamar yang dipilih harus diisi.',
            'room_id.exists' => 'Kamar yang dipilih tidak ditemukan.',
        ]);

        if ($validator->fails()) {
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $appliedResidency = ApplyResidency::with('user')->where('user_id', $id)->first();
        $appliedResidency->status = 'accepted';
        $appliedResidency->reason = null;
        $appliedResidency->updated_at = now();
        $appliedResidency->save();

        $payment = Payment::where('user_id', $id)
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->first();

        if (!$payment) {
            toast('Tidak ada pembayaran yang perlu diverifikasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $payment->status = 'accepted';
        $payment->save();

        $room = Room::with('userRooms')->findOrFail($request->room_id);

        $userRoom = new UserRoom();
        $userRoom->id = strtoupper(hash('sha256', "!@#!@#" . Carbon::now()->format('YmdH:i:s')));
        $userRoom->user_id = $id;
        $userRoom->room_id = $room->id;
        $userRoom->rent_period = now()->addDays($room->days_period);
        $userRoom->payment_id = $payment->id;
        $userRoom->save();

        $room->status = 'occupied';
        $room->save();

        $now = Carbon::now();

        Mail::to($appliedResidency->user->email)->send(new VerifyWithRoom($appliedResidency, $userRoom, $room, $now));

        toast('Pengajuan penghuni berhasil diverifikasi dan pembayaran diterima.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function rejectPayment($id)
    {
        $appliedResidency = ApplyResidency::with('user')->where('user_id', $id)->first();
        $appliedResidency->status = 'pending-payment';
        $appliedResidency->updated_at = now();
        $appliedResidency->save();

        $payment = Payment::where('user_id', $id)->orderBy('created_at', 'desc')->first();
        $payment->status = 'rejected';
        $payment->save();

        Mail::to($appliedResidency->user->email)->send(new RejectPayment($appliedResidency));

        toast('Pengajuan pembayaran ditolak.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function show($id)
    {
        $dataType = 'pengajuan';

        $user = User::with(['profile', 'applyResidency', 'userRoom', 'payment'])
                ->findOrFail($id);

        $payments = Payment::where('user_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.residencies.show', compact('dataType', 'user', 'payments'));
    }
}
