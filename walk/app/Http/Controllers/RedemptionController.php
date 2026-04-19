<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\Redemption;

class RedemptionController extends Controller
{
    public function redeem(Request $request)
    {
        $request->validate([
            'reward_id' => 'required|exists:rewards,id'
        ]);

        $user = $request->user();
        $reward = Reward::find($request->reward_id);

        if ($user->points < $reward->points_cost) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient points to redeem this reward'
            ], 400);
        }

        $user->points -= $reward->points_cost;
        $user->save();

        $redemption = Redemption::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reward redeemed successfully',
            'redemption' => $redemption
        ], 201);
    }
}
