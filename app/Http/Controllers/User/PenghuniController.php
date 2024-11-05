<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        $userId = auth('user')->user()->id;
        $userProfile = UserProfile::where('user_id', $userId)->first();

        $dataLengkap = false;

        if ($userProfile) {
            $dataLengkap = $userProfile->name && $userProfile->phone && $userProfile->birth_date && $userProfile->gender && $userProfile->regency_id
                && $userProfile->nim && $userProfile->university && $userProfile->major && $userProfile->ktp && $userProfile->family_card
                && $userProfile->active_student && $userProfile->photo;
        }

        $dataType = 'pengajuan';

        return view('user.penghuni.index', compact('dataType', 'dataLengkap'));
    }
}
