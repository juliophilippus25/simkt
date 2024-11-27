<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function index()
    {
        $dataType = 'biodata';
        $biodatas = Biodata::with('user')->where('status', 'pending')->get();
        return view('admin.biodata.index', compact('biodatas', 'dataType'));
    }

    public function acceptBiodata($id)
    {
        $biodata = Biodata::findOrFail($id);
        $biodata->status = 'accepted';
        $biodata->save();

        $user = User::where('id', $biodata->user_id)->first();
        $user->email = $biodata->email;
        $user->save();

        $userProfile = $user->profile;
        $userProfile->name = $biodata->name;
        $userProfile->save();

        toast('Pengjuan ubah biodata berhasil diverifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function rejectBiodata($id)
    {
        $biodata = Biodata::findOrFail($id);
        $biodata->delete();

        toast('Pengajuan ubah biodata ditolak.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
