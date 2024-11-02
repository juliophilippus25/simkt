<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(),
        // Aturan
        [
            'nik' => 'required|digits:16|regex:/^62/|unique:users,nik',
            'name' => 'required|string|min:3',
            'phone' => 'required|digits_between:10,15|unique:user_profiles,phone',
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
            $ktp = $request->file('ktp')->storeAs('users/ktp', $fileName);
            $ktp = $fileName;
        } else {
            $ktp = NULL;
        }

        $user = new User();
        $user->id = strtoupper(hash('sha256', "!@#!@#" . Carbon::now()->format('YmdH:i:s')));
        $user->nik = $request->nik;
        $user->email = $request->email;
        $user->save();

        $profile = new UserProfile();
        $profile->user_id = $user->id;
        $profile->name = $request->name;
        $profile->phone = $request->phone;
        $profile->gender = $request->gender;
        $profile->ktp = $ktp;
        $profile->save();

        // redirect dengan pesan sukses
        toast('Akun anda telah dibuat. Silahkan menunggu verifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('showRegister');
    }

    public function showLogin () {
        return view('auth.login');
    }

    public function login(Request $request) {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'identifier.required' => 'NIK/NIP harus diisi.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password harus memiliki setidaknya :min karakter.',
        ]);

        if ($validator->fails()) {
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $identifier = $request->input('identifier');
        $password = $request->input('password');

        // Cek apakah itu NIK atau NIP
        if (strlen($identifier) === 16 && preg_match('/^62[0-9]{14}$/', $identifier)) {
            // Cek keberadaan NIK di database
            if (!User::where('nik', $identifier)->exists()) {
                toast('NIK tidak terdaftar.','error')->timerProgressBar()->autoClose(5000);
                return redirect()->back()->withInput();
            }

            // Jika itu NIK, autentikasi sebagai user
            $credentials = ['nik' => $identifier, 'password' => $password];
            if (Auth::guard('user')->attempt($credentials)) {
                toast('Anda berhasil masuk ke dashboard user.','success')->timerProgressBar()->autoClose(5000);
                return redirect()->intended(route('user.dashboard'));
            }
        } elseif (strlen($identifier) === 18 && preg_match('/^[0-9]+$/', $identifier)) {
            // Cek keberadaan NIP di database
            if (!Admin::where('nip', $identifier)->exists()) {
                toast('NIP tidak terdaftar.','error')->timerProgressBar()->autoClose(5000);
                return redirect()->back()->withInput();
            }

            // Jika itu NIP, autentikasi sebagai admin
            $credentials = ['nip' => $identifier, 'password' => $password];
            if (Auth::guard('admin')->attempt($credentials)) {
                toast('Anda berhasil masuk ke dashboard admin.','success')->timerProgressBar()->autoClose(5000);
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        // Jika autentikasi gagal
        toast('Data anda tidak valid.','error')->timerProgressBar()->autoClose(5000);
        return redirect()->back()->withErrors($validator)->withInput();
    }

    public function logout() {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }
        return redirect()->route('showLogin');
    }
}
