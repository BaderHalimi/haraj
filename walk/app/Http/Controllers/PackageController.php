<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function store(Request $request)
    {
        try {
            // تحقق من صحة البيانات المدخلة
            $validatedData = $request->validate([
                'steps_per_point' => 'required|integer|min:1'
            ]);

            $package = new Package();
            $package->steps_per_point = $validatedData['steps_per_point'];
            $package->save();

            return response()->json([
                'success' => true,
                'message' => 'Package created successfully.',
                'package' => $package
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
            Log::error('Error creating package:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create package',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Package $package)
    {
        try {
            // تحقق من صحة البيانات المدخلة
            $validatedData = $request->validate([
                'steps_per_point' => 'required|integer|min:1'
            ]);

            $package->steps_per_point = $validatedData['steps_per_point'];
            $package->save();

            return response()->json([
                'success' => true,
                'message' => 'Package updated successfully.',
                'package' => $package
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // معالجة أخطاء التحقق من البيانات
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // معالجة الأخطاء العامة
            Log::error('Error updating package:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update package',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Package $package)
    {
        try {
            $package->delete();
            return response()->json([
                'success' => true,
                'message' => 'Package deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting package:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete package',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
