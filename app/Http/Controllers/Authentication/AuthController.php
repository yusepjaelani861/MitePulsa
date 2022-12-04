<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function loginPage()
    {
        $sessionAuth = Auth::user();
        if ($sessionAuth) {
            return redirect()->route('admin.dashboard');
        }

        return Inertia::render('Auth/Login');
    }

    public function registerPage()
    {
        $sessionAuth = Auth::user();
        if ($sessionAuth) {
            return redirect()->route('admin.dashboard');
        }

        return Inertia::render('Auth/Register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 'VALIDATION_ERROR', 422);
        }

        try {
            //code...
            DB::beginTransaction();
            $user = new User([
                'role_id' => 1,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $user->save();
            DB::commit();
            Auth::login($user);
            return $this->sendResponse($user, 'User created successfully');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError($th->getMessage(), $th->getTrace(), 'SERVER_ERROR', 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 'VALIDATION_ERROR', 422);
        }

        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return $this->sendError('Unauthorized', [], 'UNAUTHORIZED', 401);
        }

        return $this->sendResponse(auth()->user(), 'User logged in successfully');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
