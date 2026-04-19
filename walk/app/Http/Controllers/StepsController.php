<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StepsController extends Controller
{
    public function logSteps(Request $request)
    {
        try {
            // التحقق من صحة البيانات المدخلة
            $validatedData = $request->validate([
                'steps_count' => 'required|integer|min:1'
            ]);

            $user = $request->user();
            $package = Package::first();

            // إنشاء سجل للخطوات
            $step = new Step();
            $step->user_id = $user->id;
            $step->steps_count = $validatedData['steps_count'];
            $step->save();

            // تحويل الخطوات إلى نقاط إذا كان هناك باكدج موجود
            if ($package) {
                $pointsEarned = intdiv($step->steps_count, $package->steps_per_point);
                $user->points += $pointsEarned;
                $user->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Steps logged and points updated successfully',
                'points_earned' => $pointsEarned ?? 0
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // معالجة أخطاء التحقق من البيانات
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // معالجة الأخطاء العامة
            Log::error('Error logging steps:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while logging steps',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserSteps(Request $request)
    {
        try {
            $user = $request->user();
            $steps = $user->steps;

            if (is_null($steps)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Steps data is missing'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $steps
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error retrieving user steps:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving steps',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserPoints(Request $request)
    {
        try {
            $user = $request->user();
            $points = $user->points;

            if (is_null($points)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Points data is missing'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $points
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error retrieving user points:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving points',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
