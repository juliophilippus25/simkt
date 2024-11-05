<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index() {
        $user = auth('user')->user()->load('profile');
        $regencies = Regency::all();

        return view('user.profile', compact('user', 'regencies'));
    }

    public function updateProfile(Request $request) {
        $userId = auth('user')->user()->id;
        $user = User::findOrFail($userId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'birth_date' => 'required|date|before:today',
            'regency_id' => 'required',
            'nim' => 'required|string',
            'university' => 'required|string',
            'major' => 'required|string',
        ], [
            'name.required' => 'Nama lengkap harus diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'birth_date.required' => 'Tanggal lahir harus diisi.',
            'birth_date.date' => 'Tanggal lahir tidak valid.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'regency_id.required' => 'Kabupaten/kota harus diisi.',
            'nim.required' => 'NIM harus diisi.',
            'university.required' => 'Universitas harus diisi.',
            'major.required' => 'Jurusan harus diisi.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $profile = $user->profile;
        $profile->name = $request->name;
        $profile->birth_date = $request->birth_date;
        $profile->regency_id = $request->regency_id;
        $profile->nim = $request->nim;
        $profile->university = $request->university;
        $profile->major = $request->major;
        $profile->save();

        // redirect dengan pesan sukses
        toast('Update profil berhasil.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
