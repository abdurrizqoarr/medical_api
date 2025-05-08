<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userLogin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string|max:60',
            'password' => 'required|string|max:24',
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'data terlalu panjang',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 400);
        }

        // Cek kredensial user
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Username atau password salah'
            ], 401);
        }

        // Buat token baru
        $token = $user->createToken(
            'authToken',
            ['*'],
            now()->addHours(6)
        )->plainTextToken;

        // Ambil role dan permission user

        return response()->json([
            'message' => 'success',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Hapus token yang sedang digunakan
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    public function tes12()
    {
        PermissionHelper::checkPermissionOrAbort('edit-suku');
            return response()->json([
            'data' => "hai"
        ]);
    }
}
