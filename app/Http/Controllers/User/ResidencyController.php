<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ApplyResidency;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResidencyController extends Controller
{
    public function index() {
        // Ambil ID pengguna yang sedang login
        $userId = auth('user')->user()->id;

        // Memuat profil, pengajuan residensi, kamar, dan pembayaran pengguna
        $user = User::with(['profile', 'applyResidency', 'userRoom', 'payment'])
                    ->where('id', $userId)
                    ->firstOrFail(); // Gunakan firstOrFail untuk memastikan pengguna ditemukan

        // Cek apakah data profil lengkap
        $dataLengkap = false;

        // Pastikan userProfile tersedia
        if ($user->profile) {
            $dataLengkap = $user->profile->name && $user->profile->phone && $user->profile->birth_date
                && $user->profile->gender && $user->profile->regency_id
                && $user->profile->nim && $user->profile->university && $user->profile->major
                && $user->profile->ktp && $user->profile->family_card
                && $user->profile->active_student && $user->profile->photo;
        }

        // Cek apakah ada pengajuan residensi untuk user ini
        $appliedResidency = ApplyResidency::where('user_id', $userId)->first();

        // Tentukan tipe data untuk tampilan
        $dataType = 'pengajuan';

        // Kembalikan data ke tampilan dengan variabel yang diperlukan
        return view('user.penghuni.index', compact('dataType', 'dataLengkap', 'appliedResidency', 'user'));
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
