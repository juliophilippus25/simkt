<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Extension;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExtensionController extends Controller
{
    public function index()
    {
        $dataType = 'perpanjangan';
        $payments = Payment::where('status', 'pending')->latest()->get();
        return view('admin.extensions.index', compact('dataType', 'payments'));
    }

    public function acceptPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'accepted';
        $payment->save();

        $userRoom = UserRoom::with('room')->where('user_id', $payment->user_id)->first();
        $userRoom->rent_period = Carbon::parse($userRoom->rent_period);
        $userRoom->rent_period = $userRoom->rent_period->addDays($userRoom->room->days_period);
        $userRoom->payment_id = $payment->id;
        $userRoom->save();

        $user = User::with('profile')->where('id', $payment->user_id)->first();
        $beforeExtension = $userRoom->rent_period->subDays($userRoom->room->days_period);

        Mail::to($user->email)->send(new Extension($userRoom, $user, $beforeExtension));

        toast('Pembayaran perpanjangan berhasil diverifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function rejectPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'rejected';
        $payment->save();

        toast('Pembayaran perpanjangan berhasil ditolak.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
