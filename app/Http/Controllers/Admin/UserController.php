<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $dataType = 'penghuni';
        $users = User::with('profile')->get();
        return view('admin.user.index', compact('dataType', 'users'));
    }

    public function verify($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_verified) {
            toast('Penghuni sudah terverifikasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $nik = $user->nik;
        $phone = $user->profile->phone;

        $user->password = $this->generatePassword($nik, $phone);
        $user->is_verified = 1;
        $user->is_active = 1;
        $user->verified_at = now();
        $user->save();

        toast('Penghuni berhasil diverifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
