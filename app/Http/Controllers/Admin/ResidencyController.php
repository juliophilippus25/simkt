<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplyResidency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResidencyController extends Controller
{
    public function index()
    {
        $dataType = 'pengajuan';
        $residencies = ApplyResidency::with('user')->get();
        return view('admin.residencies.index', compact('dataType', 'residencies'));
    }

    public function acceptApplyResidency($id)
    {
        $adminId = auth('admin')->user()->id;
        $appliedResidency = ApplyResidency::findOrFail($id);

        if ($appliedResidency->verified_by || $appliedResidency->verified_at) {
            toast('Pengajuan penghuni sudah terverifikasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        // Proses verifikasi
        $appliedResidency->verified_by = $adminId;
        $appliedResidency->verified_at = now();
        $appliedResidency->status = 'accepted';
        $appliedResidency->save();

        toast('Pengajuan penghuni berhasil diverifikasi.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function rejectApplyResidency($id)
    {
        $adminId = auth('admin')->user()->id;
        $appliedResidency = ApplyResidency::findOrFail($id);

        if ($appliedResidency->verified_by || $appliedResidency->verified_at) {
            toast('Pengajuan penghuni sudah terverifikasi.','error')->timerProgressBar()->autoClose(5000);
            return redirect()->back();
        }

        $appliedResidency->verified_by = $adminId;
        $appliedResidency->verified_at = now();
        $appliedResidency->status = 'rejected';
        $appliedResidency->reason = 'Mohon maaf, belum ada kamar yang tersedia.';
        $appliedResidency->save();

        toast('Pengajuan penghuni berhasil ditolak.','success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
