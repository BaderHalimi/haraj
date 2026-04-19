<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Referral;

class ReferralController extends Controller
{
    public function getReferralCode(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'referral_code' => $user->referral_code
        ]);
    }

    public function getReferrals(Request $request)
    {
        $user = $request->user();
        $referrals = Referral::where('user_id', $user->id)->with('referredUser')->get();

        return response()->json([
            'success' => true,
            'referrals' => $referrals
        ]);
    }
}
