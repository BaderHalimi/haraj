<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;

class RewardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'points_cost' => 'required|integer|min:1',
        ]);

        $reward = Reward::create([
            'name' => $request->input('name'),
            'points_cost' => $request->input('points_cost'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reward created successfully',
            'reward' => $reward
        ], 201);
    }

    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'points_cost' => 'sometimes|required|integer|min:1',
        ]);

        if ($request->has('name')) {
            $reward->name = $request->input('name');
        }
        if ($request->has('points_cost')) {
            $reward->points_cost = $request->input('points_cost');
        }

        $reward->save();

        return response()->json([
            'success' => true,
            'message' => 'Reward updated successfully',
            'reward' => $reward
        ], 200);
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reward deleted successfully'
        ], 200);
    }

    public function index()
    {
        $rewards = Reward::all();

        return response()->json([
            'success' => true,
            'rewards' => $rewards
        ], 200);
    }
}
