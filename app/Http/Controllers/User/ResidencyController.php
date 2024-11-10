<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ApplyResidency;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResidencyController extends Controller
{
    public function index() {
        $userId = auth('user')->user()->id;
        $userProfile = UserProfile::where('user_id', $userId)->first();
        $appliedResidency = ApplyResidency::where('user_id', $userId)->first();

        $dataLengkap = false;

        if ($userProfile) {
            $dataLengkap = $userProfile->name && $userProfile->phone && $userProfile->birth_date && $userProfile->gender && $userProfile->regency_id
                && $userProfile->nim && $userProfile->university && $userProfile->major && $userProfile->ktp && $userProfile->family_card
                && $userProfile->active_student && $userProfile->photo;
        }

        $dataType = 'pengajuan';

        return view('user.penghuni.index', compact('dataType', 'dataLengkap', 'appliedResidency'));
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
}
