<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function registerStepOne(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'referral_code' => 'nullable|exists:users,referral_code'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->all()], 400);
        }

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->referral_code = Str::random(10);
        $user->used_referral_code = $request->referral_code;
        $user->save();

        if ($request->has('referral_code')) {
            Referral::create([
                'user_id' => User::where('referral_code', $request->referral_code)->first()->id,
                'referred_user_id' => $user->id,
            ]);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['success' => true, 'user_id' => $user->id, 'token' => $token], 201);
    }

    public function registerStepTwo(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'full_name' => 'required|string',
            'age' => 'required|integer',
            'height' => 'required|integer',
            'weight' => 'required|integer',
            'gender' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->all()], 400);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->full_name = $request->full_name;
        $user->age = $request->age;
        $user->height = $request->height;
        $user->weight = $request->weight;
        $user->gender = $request->gender;
        $user->save();

        return response()->json(['success' => true, 'message' => 'User profile updated successfully.', 'user' => $user], 200);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->all()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Credentials not match'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['success' => true, 'token' => $token], 200);
    }
}
