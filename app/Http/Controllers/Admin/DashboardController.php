<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use App\Models\UserRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = $this->userCount();
        $userTypeMCount = $this->userTypeMCount();
        $userTypeFCount = $this->userTypeFCount();
        $userTypeMJoinCount = $this->userTypeMJoinCount();
        $userTypeFJoinCount = $this->userTypeFJointCount();
        $getUsersWithPendingPayment = $this->getUsersWithPendingPayment();

        $pendingPayment = Payment::where('status', 'pending')
            ->latest()
            ->first();

        $years = array_merge(array_keys($userTypeMJoinCount), array_keys($userTypeFJoinCount));
        $years = array_unique($years); // Menjaga agar tahun hanya unik

        return view('admin.dashboard', compact(
            'userCount',
            'userTypeMCount',
            'userTypeFCount',
            'userTypeMJoinCount',
            'userTypeFJoinCount',
            'getUsersWithPendingPayment',
            'pendingPayment',
            'years'
        ));
    }

    private function userCount()
    {
        return User::count();
    }

    private function userTypeMCount()
    {
        $room = Room::where('room_type', 'M')->get();
        $userRoom = UserRoom::whereIn('room_id', $room->pluck('id'))->count();

        return $userRoom;
    }

    private function userTypeFCount()
    {
        $room = Room::where('room_type', 'F')->get();
        $userRoom = UserRoom::whereIn('room_id', $room->pluck('id'))->count();

        return $userRoom;
    }

    private function userTypeMJoinCount()
    {
        $room = Room::where('room_type', 'M')->get();

        // Mengambil data jumlah berdasarkan bulan dan tahun
        $userRooms = UserRoom::whereIn('room_id', $room->pluck('id'))
                            ->selectRaw('COUNT(*) as count, MONTH(created_at) as month, YEAR(created_at) as year')
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'asc')
                            ->orderBy('month', 'asc')
                            ->get();

        // Menyusun data berdasarkan tahun dan bulan
        $userRoomCounts = [];
        foreach ($userRooms as $userRoom) {
            $userRoomCounts[$userRoom->year][$userRoom->month] = $userRoom->count;
        }

        return $userRoomCounts;
    }

    private function userTypeFJointCount()
    {
        $room = Room::where('room_type', 'F')->get();

        // Mengambil data jumlah berdasarkan bulan dan tahun
        $userRooms = UserRoom::whereIn('room_id', $room->pluck('id'))
                            ->selectRaw('COUNT(*) as count, MONTH(created_at) as month, YEAR(created_at) as year')
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'asc')
                            ->orderBy('month', 'asc')
                            ->get();

        // Menyusun data berdasarkan tahun dan bulan
        $userRoomCounts = [];
        foreach ($userRooms as $userRoom) {
            $userRoomCounts[$userRoom->year][$userRoom->month] = $userRoom->count;
        }

        return $userRoomCounts;
    }

    private function getUsersWithPendingPayment()
    {
        // Ambil semua pengguna dengan relasi 'userRoom' dan 'payment'
        $users = User::with(['userRoom', 'payment'])->get();

        // Menyaring pengguna yang sudah rent_period - 10 hari
        $usersWithPendingPayment = $users->filter(function ($user) {
            // Ambil data userRoom dan periksa rent_period
            $userRoom = $user->userRoom;
            if (!$userRoom) {
                return false; // Jika tidak ada data userRoom, lewati
            }

            // Tentukan tanggal 10 hari sebelum rent_period
            $rentPeriodSub10Days = Carbon::parse($userRoom->rent_period)->subDays(10);

            // Cek apakah tanggal sekarang sudah melewati rent_period - 10 hari
            return Carbon::now()->gt($rentPeriodSub10Days); // Hanya cek jika rent_period - 10 hari sudah tercapai
        });

        return $usersWithPendingPayment;
    }
}
