<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(){
        $dataType = 'admin';
        $admins = Admin::get();
        return view('admin.admin.index', compact('dataType', 'admins'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),
        // Aturan
        [
            'nip' => 'required|digits:18|unique:admins,nip',
            'name' => 'required|string|min:3',
            'role' => 'required|in:superadmin,admin',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ],
        // Pesan
        [
            // Required
            'name.required' => 'Nama lengkap harus diisi.',
            'nip.required' => 'NIP harus diisi.',
            'role.required' => 'Role harus diisi.',

            // Email
            'email.email' => 'Format email salah.',

            // Unique
            'nip.unique' => 'NIP sudah terdaftar.',

            // Min
            'name.min' => 'Nama lengkap harus memiliki setidaknya :min karakter.',

            // String
            'name.string' => 'Nama lengkap harus berupa string.',

            // Digits
            'nip.digits' => 'NIP harus tepat :digits karakter.',

            // Password
            'password.min' => 'Password minimal 8 karakter.',
            'confirm_password.required' => 'Konfirmasi password harus diisi.',
            'confirm_password.min' => 'Konfirmasi password minimal 8 karakter.',
            'confirm_password.same' => 'Konfirmasi password harus sama dengan password.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin = new Admin();
        $admin->id = strtoupper(hash('sha256', "!@#!@#" . Carbon::now()->format('YmdH:i:s')));
        $admin->name = $request->name;
        $admin->nip = $request->nip;
        $admin->role = $request->role;
        $admin->password = $request->password;
        $admin->is_active = 1;
        $admin->save();

        toast('Pembuatan akun admin berhasil.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('admin.admin.index');
    }
}
