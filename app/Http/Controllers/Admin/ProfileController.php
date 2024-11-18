<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = auth('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateBiodata(Request $request)
    {
        $adminId = auth('admin')->user()->id;
        $admin = Admin::findOrFail($adminId);

        $validator = Validator::make($request->all(), [
            'avatar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'avatar.mimes' => 'Foto harus berformat jpg, jpeg, atau png.',
            'avatar.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        if($validator->fails()){
            // redirect dengan pesan error
            toast('Periksa kembali data anda.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            if ($admin->avatar) {
                Storage::delete('admins/avatar/' . $admin->avatar);
            }

            $extension = $request->avatar->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $avatar = $request->file('avatar')->storeAs('admins/avatar', $fileName);
            $avatar = $fileName;
        } else {
            $avatar = $admin->avatar;
        }

        $admin->avatar = $avatar;
        $admin->save();

        toast('Profil berhasil diubah.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
