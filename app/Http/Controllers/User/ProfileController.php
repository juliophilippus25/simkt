<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index() {
        $user = auth('user')->user()->load('profile');
        $regencies = Regency::all();

        return view('user.profile', compact('user', 'regencies'));
    }

    public function updateBiodata(Request $request) {
        $userId = auth('user')->user()->id;
        $user = User::findOrFail($userId);

        $validator = Validator::make($request->all(), [
            'birth_date' => 'required|date|before:today',
            'regency_id' => 'required',
            'nim' => 'required|string',
            'university' => 'required|string',
            'major' => 'required|string',
        ], [
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
        $profile->birth_date = $request->birth_date;
        $profile->regency_id = $request->regency_id;
        $profile->nim = $request->nim;
        $profile->university = $request->university;
        $profile->major = $request->major;
        $profile->save();

        // redirect dengan pesan sukses
        toast('Update biodata berhasil.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function updateBerkas(Request $request) {
        $userId = auth('user')->user()->id;
        $user = User::findOrFail($userId);

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'ktp' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'family_card' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'active_student' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'ktp.mimes' => 'KTP harus berformat jpg, jpeg, png, atau pdf.',
            'family_card.mimes' => 'Kartu keluarga harus berformat jpg, jpeg, png, atau pdf.',
            'active_student.mimes' => 'Surat aktif kuliah harus berformat jpg, jpeg, png, atau pdf.',
            'photo.mimes' => 'Foto harus berformat jpg, jpeg, atau png.',
            'ktp.max' => 'Ukuran KTP maksimal 2 MB.',
            'family_card.max' => 'Ukuran Kartu keluarga maksimal 2 MB.',
            'active_student.max' => 'Ukuran Surat aktif kuliah maksimal 2 MB.',
            'photo.max' => 'Ukuran Foto maksimal 2 MB.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('ktp') && $request->file('ktp')->isValid()) {
            if ($user->profile->ktp) {
                Storage::delete('users/ktp/' . $user->profile->ktp);
            }

            $extension = $request->ktp->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $ktp = $request->file('ktp')->storeAs('users/ktp', $fileName);
            $ktp = $fileName;
        } else {
            $ktp = $user->profile->ktp;
        }

        if ($request->hasFile('family_card') && $request->file('family_card')->isValid()) {
            if ($user->profile->family_card) {
                Storage::delete('users/kartu-keluarga/' . $user->profile->family_card);
            }

            $extension = $request->family_card->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $family_card = $request->file('family_card')->storeAs('users/kartu-keluarga', $fileName);
            $family_card = $fileName;
        } else {
            $family_card = $user->profile->family_card;
        }

        if ($request->hasFile('active_student') && $request->file('active_student')->isValid()) {
            if ($user->profile->active_student) {
                Storage::delete('users/surat-aktif/' . $user->profile->active_student);
            }

            $extension = $request->active_student->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $active_student = $request->file('active_student')->storeAs('users/surat-aktif', $fileName);
            $active_student = $fileName;
        } else {
            $active_student = $user->profile->active_student;
        }

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            if ($user->profile->photo) {
                Storage::delete('users/foto/' . $user->profile->photo);
            }

            $extension = $request->photo->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $photo = $request->file('photo')->storeAs('users/foto', $fileName);
            $photo = $fileName;
        } else {
            $photo = $user->profile->photo;
        }

        $profile = $user->profile;
        $profile->ktp = $ktp;
        $profile->family_card = $family_card;
        $profile->active_student = $active_student;
        $profile->photo = $photo;
        $profile->save();

        // redirect dengan pesan sukses
        toast('Update berkas berhasil.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function updatePassword(Request $request) {
        $userId = auth('user')->user()->id;
        $user = User::findOrFail($userId);

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:new_password',
        ], [
            'current_password.required' => 'Password lama harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'confirm_password.required' => 'Konfirmasi password baru harus diisi.',
            'confirm_password.min' => 'Konfirmasi password baru minimal 8 karakter.',
            'confirm_password.same' => 'Konfirmasi password baru harus sama dengan password baru.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->current_password, $user->password)) {
            // redirect dengan pesan error
            toast('Password lama tidak sesuai.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $user->password = $request->new_password;
        $user->save();

        // redirect dengan pesan sukses
        toast('Update password berhasil.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
