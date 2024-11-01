<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister() {
        return view('user.auth.register');
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(),
        // Aturan
        [
            // Data pribadi
            'nik' => 'required|digits:16|regex:/^62/|unique:user_profiles',
            'name' => 'required|string|min:3',
            'phone' => 'required|digits_between:10,15|unique:user_profiles',
            'email' => 'required|email|unique:users',
            'gender' => 'required|in:M,F',
            'ktp' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ],
        // Pesan
        [
            // Required
            'name.required' => 'Nama lengkap harus diisi.',
            'phone.required' => 'Nomor HP harus diisi.',
            'nik.required' => 'NIK harus diisi.',
            'email.required' => 'Email harus diisi.',
            'ktp.required' => 'KTP harus diisi.',
            'gender.required' => 'Jenis kelamin harus diisi.',

            // Email
            'email.email' => 'Format email salah.',

            // Unique
            'phone.unique' => 'Nomor HP sudah terdaftar.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',

            // String
            'name.string' => 'Nama lengkap harus berupa teks.',

            // Min
            'name.min' => 'Nama lengkap harus memiliki setidaknya :min karakter.',

            // Digits_beetween
            'phone.digits_between' => 'Nomor HP harus antara :min hingga :max karakter.',

            // Digits
            'nik.digits' => 'NIK harus tepat :digits karakter.',

            // Mimes
            'ktp.mimes' => 'File KTP harus berupa format jpg, jpeg, png, pdf.',

            // Max
            'ktp.max' => 'File KTP tidak boleh lebih dari 2mb.',

            // Regex
            'nik.regex' => 'NIK tidak valid.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses upload ktp
        if ($request->hasFile('ktp') && $request->file('ktp')->isValid()) {
            $extension = $request->ktp->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $ktp = $request->file('ktp')->storeAs('user/ktp', $fileName);
            $ktp = $fileName;
        } else {
            $ktp = NULL;
        }

        $user = new User();
        $user->id = strtoupper(hash('sha256', "!@#!@#" . Carbon::now()->format('YmdH:i:s')));
        $user->email = $request->email;
        $user->save();

        $profile = new UserProfile();
        $profile->user_id = $user->id;
        $profile->name = $request->name;
        $profile->nik = $request->nik;
        $profile->phone = $request->phone;
        $profile->gender = $request->gender;
        $profile->ktp = $ktp;
        $profile->save();

        // redirect dengan pesan sukses
        toast('Akun anda telah dibuat. Silahkan menunggu verifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('showRegister');
    }
}
