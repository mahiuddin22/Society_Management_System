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
        $settings = Settings::all()->first();
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

}
