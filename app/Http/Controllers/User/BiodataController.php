<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BiodataController extends Controller
{
    public function index()
    {
        $user = User::with('profile')->first();

        return view('user.penghuni.biodata', compact('user'));
    }

    public function store(Request $request) {
        $userId = auth('user')->id();

        $validator = Validator::make($request->all(),
        // Aturan
        [
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email|unique:users',
        ],
        // Pesan
        [
            // Email
            'email.email' => 'Format email salah.',

            // Unique
            'email.unique' => 'Email sudah terdaftar.',

            // String
            'name.string' => 'Nama lengkap harus berupa teks.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $biodata = new Biodata();
        $biodata->id = strtoupper(hash('sha256', "!@#!@#" . Carbon::now()->format('YmdH:i:s')));
        $biodata->user_id = $userId;
        $biodata->name = $request->name;
        $biodata->email = $request->email;
        $biodata->save();

        toast('Biodata berhasil diajukan.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->route('user.biodata.index');
    }
}
