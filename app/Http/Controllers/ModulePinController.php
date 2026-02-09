<?php

namespace App\Http\Controllers;

use App\Models\ModulePin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ModulePinController extends Controller
{
    /**
     * Verify PIN for a module
     */
    public function verify(Request $request)
    {
        $request->validate([
            'module_key' => 'required|string',
            'pin' => 'required|string|size:6',
        ]);

        $modulePin = ModulePin::where('module_key', $request->module_key)->first();

        if (!$modulePin) {
            return response()->json(['success' => false, 'message' => 'Modul tidak ditemukan'], 404);
        }

        if (Hash::check($request->pin, $modulePin->pin_code)) {
            // Store access in session (valid for 8 hours)
            $sessionKey = 'module_pin_' . $request->module_key;
            session([$sessionKey => now()->addHours(8)->timestamp]);

            return response()->json(['success' => true, 'message' => 'PIN benar']);
        }

        return response()->json(['success' => false, 'message' => 'PIN salah, coba lagi'], 401);
    }

    /**
     * Change PIN for a module
     */
    public function changePin(Request $request)
    {
        $request->validate([
            'module_key' => 'required|string',
            'current_pin' => 'required|string|size:6',
            'new_pin' => 'required|string|size:6',
            'confirm_pin' => 'required|string|size:6|same:new_pin',
        ]);

        $modulePin = ModulePin::where('module_key', $request->module_key)->first();

        if (!$modulePin) {
            return response()->json(['success' => false, 'message' => 'Modul tidak ditemukan'], 404);
        }

        // Verify current PIN
        if (!Hash::check($request->current_pin, $modulePin->pin_code)) {
            return response()->json(['success' => false, 'message' => 'PIN lama salah'], 401);
        }

        // Update PIN
        $modulePin->update([
            'pin_code' => Hash::make($request->new_pin),
            'updated_by' => auth()->id(),
        ]);

        return response()->json(['success' => true, 'message' => 'PIN berhasil diubah']);
    }

    /**
     * Check if module is unlocked in current session
     */
    public function checkAccess(Request $request)
    {
        $moduleKey = $request->query('module_key');
        $sessionKey = 'module_pin_' . $moduleKey;
        $expiry = session($sessionKey);

        if ($expiry && $expiry > now()->timestamp) {
            return response()->json(['unlocked' => true]);
        }

        return response()->json(['unlocked' => false]);
    }
}
