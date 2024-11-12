<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ApplyResidency;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResidencyController extends Controller
{
    public function index()
    {
        $userId = auth('user')->user()->id;

        $user = User::with([
            'profile',
            'applyResidency',
            'userRoom',
            'payment'
        ])
        ->findOrFail($userId);

        $isProfileComplete = $this->isProfileComplete($user->profile);

        $pendingPayment = Payment::where('user_id', $userId)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $rejectedPayment = Payment::where('user_id', $userId)
            ->where('status', 'rejected')
            ->latest()
            ->first();

        $appliedResidency = $user->applyResidency;
        $residencyDeadline = $appliedResidency ? Carbon::parse($appliedResidency->updated_at)->addDays(3) : null;

        $userRoom = $user->userRoom;
        $subDays = $userRoom ? Carbon::parse($userRoom->rent_period)->subDays(10) : null;

        $dataType = 'pengajuan';

        return view('user.penghuni.index', compact(
            'dataType',
            'isProfileComplete',
            'appliedResidency',
            'user',
            'pendingPayment',
            'rejectedPayment',
            'residencyDeadline',
            'subDays'
        ));
    }

    private function isProfileComplete($profile)
    {
        if (!$profile) {
            return false;
        }

        // Cek kelengkapan setiap field di profile
        return $profile->name && $profile->phone && $profile->birth_date
            && $profile->gender && $profile->regency_id
            && $profile->nim && $profile->university && $profile->major
            && $profile->ktp && $profile->family_card
            && $profile->active_student && $profile->photo;
    }

    public function storeApplyResidency() {
        $userId = auth('user')->user()->id;

        $existingApplication = ApplyResidency::where('user_id', $userId)->where('status', 'pending')->first();

        if ($existingApplication) {
            toast('Anda sudah mengajukan permohonan sebelumnya.','warning')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $applyResidency = new ApplyResidency();
        $applyResidency->id = strtoupper(hash('sha256', "!@#!@#" . Carbon::now()->format('YmdH:i:s')));
        $applyResidency->user_id = $userId;
        $applyResidency->save();

        toast('Pengajuan berhasil.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function restoreApplyResidency() {
        $userId = auth('user')->user()->id;

        $existingApplication = ApplyResidency::where('user_id', $userId)->where('status', 'rejected')->first();

        $existingApplication->verified_by = NULL;
        $existingApplication->verified_at = NULL;
        $existingApplication->status = 'pending';
        $existingApplication->created_at = now();
        $existingApplication->save();

        toast('Pengajuan berhasil.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function storePayment(Request $request) {
        $userId = auth('user')->user()->id;

        $validator = Validator::make($request->all(), [
            'proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'proof.required' => 'Bukti bayar harus diisi.',
            'proof.mimes' => 'File bukti bayar harus berupa format jpg, jpeg, png, pdf.',
            'proof.max' => 'Bukti bayar tidak boleh lebih dari 2MB.',
        ]);

        if ($validator->fails()) {
            toast('Upload bukti bayar gagal.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('proof') && $request->file('proof')->isValid()) {
            $extension = $request->proof->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $proof = $request->file('proof')->storeAs('users/bukti-bayar', $fileName);
            $proof = $fileName;
        } else {
            $proof = NULL;
        }

        $payment = new Payment();
        $payment->id = strtoupper(hash('sha256', "!@#!@#" . Carbon::now()->format('YmdH:i:s')));
        $payment->user_id = $userId;
        $payment->proof = $proof;
        $payment->save();

        toast('Upload bukti bayar berhasil.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
