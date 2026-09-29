<?php

namespace App\Http\Controllers;

use App\Models\DataManagementPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataManagementController extends Controller
{
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $DataKahiji = DataManagementPassword::first();

        if (!$DataKahiji || !Hash::check($request->password, $DataKahiji->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password Salah.',
            ], 401);
        }

        $request->session()->put(
            'data_management_verified',
            true
        );

        return response()->json([
            'success' => true,
            'message' => 'Password Benar.',
        ]);
    }
}
