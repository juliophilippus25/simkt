<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function generatePassword($nik, $phone) {
        // Ambil 4 digit terakhir dari NIK
        $nikLastFour = substr($nik, -4);

        // Ambil 4 digit terakhir dari phone
        $phoneLastFour = substr($phone, -4);

        // Gabungkan keduanya
        return $nikLastFour . $phoneLastFour;
    }
}
