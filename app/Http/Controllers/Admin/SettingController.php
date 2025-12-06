<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        
        return view('admin.setting.index', [
            'settings' => $settings
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->merge([
            'gmail_account' => $request->gmail_account ? trim($request->gmail_account) : null,
            'profile_email' => $request->profile_email ? trim($request->profile_email) : null,
        ]);

        $validated = $request->validate([
            'userfile' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',

            'profile_fullname'       => 'required|string|max:255',
            'profile_specialization' => 'nullable|string|max:255',

            'profile_email'  => 'nullable|email:filter|max:255',
            'gmail_account'  => 'nullable|email:filter|max:255',

            'telegram_profile' => 'nullable|string|max:255',
            'telegram_api_key' => 'nullable|string|max:255',

            'whatsapp_number'   => 'nullable|string|max:50',
            'whatsapp_api_key'  => 'nullable|string|max:255',

            'bulk_sms_name'     => 'nullable|string|max:50',
            'bulk_sms_number'   => 'nullable|string|max:50',
            'bulk_sms_api_key'  => 'nullable|string|max:255',

            'old_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|min:8|string',
        ]);

        $dataToSave = $validated;
        unset($dataToSave['userfile'], $dataToSave['old_password'], $dataToSave['new_password']);

        if ($request->hasFile('userfile')) {
            $settings = Setting::first();
            if ($settings && $settings->profile_photo) {
                Storage::disk('public')->delete($settings->profile_photo);
            }

            $path = $request->file('userfile')->store('profile-photos', 'public');
            $dataToSave['profile_photo'] = $path;
        }

        Setting::updateOrCreate(
            ['id' => 1], 
            $dataToSave
        );

        // Обновляем данные пользователя в таблице users
        $user = User::find(1); // Получаем пользователя с id=1
        
        if ($user) {
            $userData = [];
            
            // Обновляем email из profile_email
            if (isset($validated['profile_email']) && $validated['profile_email']) {
                $userData['email'] = $validated['profile_email'];
            }
            
            // Обновляем пароль, если указан новый пароль
            $passwordChanged = false;
            if ($request->filled('old_password') && $request->filled('new_password')) {
                if (!Hash::check($request->old_password, $user->password)) {
                    return redirect()->back()
                        ->withErrors(['old_password' => 'Köhnə şifrə yanlışdır'])
                        ->withInput();
                }
                
                $userData['password'] = Hash::make($request->new_password);
                $passwordChanged = true;
            }
            
            // Сохраняем изменения пользователя
            if (!empty($userData)) {
                $user->update($userData);
            }
            
            // Если пароль был изменен, выходим из системы
            if ($passwordChanged) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('admin.login')
                    ->with('success', 'Şifrə uğurla dəyişdirildi. Yenidən daxil olun.');
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Sazlamalar uğurla yeniləndi!');
    }
}
