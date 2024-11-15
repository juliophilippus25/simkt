<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use App\Models\UserRoom;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function getAsramaPutra(){
        $dataType = 'kamar';
        $rooms = Room::with('userRooms')->where('room_type', 'M')->get();

        return view('admin.room.putra', compact('dataType','rooms'));
    }

    public function getAsramaPutri(){
        $dataType = 'asrama putri';
        $rooms = Room::where('room_type', 'F')->get();
        return view('admin.room.putri', compact('dataType','rooms'));
    }

    public function show($id)
    {
        $user = User::with(['profile', 'applyResidency', 'userRoom', 'payment'])
                ->findOrFail($id);

        $payments = Payment::where('user_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.room.show', compact('user', 'payments'));
    }
}
