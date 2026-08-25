<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{

    /*
   Show Pages
   */
    public function edit()
    {
        $settings = Settings::latest()->first();
        return View('admin.settings.edit', compact('settings'));
    }

    public function basicUpdate(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required',
            'email'             => 'required',
            'contact'           => 'required',
            'address'           => 'required'
        ]);

        // Get existing record (IMPORTANT: no truncate)
        $content = Settings::latest()->first();

        // Logo upload
        if (!empty($request->logo)) {

            // Delete old logo if exists
            if (!empty($content->logo)) {
                $old_path = public_path('uploads/settings/' . $content->logo);

                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }

            // Upload new logo
            $file = $request->logo;
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);

            $content->logo = $filename;
        }

        // Assign values manually (classic style)
        $content->name              = $request->name;
        $content->address           = $request->address;
        $content->contact           = $request->contact;
        $content->email             = $request->email;
        $content->save();

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function emailUpdate(Request $request)
    {
        $this->validate($request, [
            'mail_mailer' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
            'mail_encryption' => 'required',
        ]);

        // Get existing record (IMPORTANT: no truncate)
        $content = Settings::latest()->first();

        // Logo upload
        if (!empty($request->logo)) {

            // Delete old logo if exists
            if (!empty($content->logo)) {
                $old_path = public_path('uploads/settings/' . $content->logo);

                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }

            // Upload new logo
            $file = $request->logo;
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);

            $content->logo = $filename;
        }
        $content->mail_driver       = $request->mail_mailer;
        $content->mail_host         = $request->mail_host;
        $content->mail_port         = $request->mail_port;
        $content->mail_username     = $request->mail_username;
        $content->mail_password     = $request->mail_password;
        $content->mail_encryption   = $request->mail_encryption;
        $content->mail_from_address = $request->mail_from_address;
        $content->mail_from_name    = $request->mail_from_name;
        $content->save();

        // Update .env
        setEnv('MAIL_MAILER', $request->mail_mailer);
        setEnv('MAIL_HOST', $request->mail_host);
        setEnv('MAIL_PORT', $request->mail_port);
        setEnv('MAIL_USERNAME', $request->mail_username);
        setEnv('MAIL_PASSWORD', $request->mail_password);
        setEnv('MAIL_ENCRYPTION', $request->mail_encryption);

        setEnv('MAIL_FROM_ADDRESS', $request->mail_from_address);
        setEnv('MAIL_FROM_NAME', $request->mail_from_name);

        // Clear cache
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = User::find(auth()->id());

        if (!$user) {
            return redirect()->back()->with('error', 'No User Found');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current Password Does not Match');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password Updated Successfully');
    }
}
