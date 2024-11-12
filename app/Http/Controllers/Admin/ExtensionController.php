<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        $dataType = 'perpanjangan';
        $payments = Payment::where('status', 'pending')->latest()->get();
        return view('admin.extensions.index', compact('dataType', 'payments'));
    }
}
