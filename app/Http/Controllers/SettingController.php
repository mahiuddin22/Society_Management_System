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
    public function index()
    {
        $content = Settings::all()->first();
        return View('admin.setting.index', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'              => 'required',
            'email'             => 'required',
            'contact'           => 'required',
            'address'           => 'required'
        ]);

        // Get existing record (IMPORTANT: no truncate)
        $content = Settings::findOrFail($id);

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

        return redirect()->back()->with('message', 'Settings updated successfully');
    }

    // public function viewProfile()
    // {
    //     $admin = auth()->user();
    //     return view('admin.setting.view_profile', compact('admin'));
    // }

    // public function profileSettings()
    // {
    //     $admin = auth()->user();
    //     return view('admin.setting.profile_setting', compact('admin'));
    // }


    // public function updateProfileSettings(Request $request)
    // {
    //     $admin = User::where('id', auth()->id())->first();

    //     // Validation
    //     $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'email'      => 'required|email|unique:users,email,' . $admin->id,
    //         'phone'      => 'nullable|string|max:20',
    //         'address'    => 'nullable|string',
    //         'avatar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     $admin->first_name = $request->first_name;
    //     $admin->email = $request->email;
    //     $admin->phone = $request->phone;
    //     $admin->address = $request->address;

    //     if ($request->hasFile('avatar')) {

    //         if ($admin->avatar && File::exists(public_path('admin/images/' . $admin->avatar))) {
    //             File::delete(public_path('admin/images/' . $admin->avatar));
    //         }

    //         $file = $request->file('avatar');
    //         $filename = time() . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('admin/images/'), $filename);

    //         $admin->avatar = $filename;
    //     }

    //     $admin->save();

    //     return redirect()->route('admin.view.profile')->with('success', 'Profile updated successfully!');
    // }

    // public function updatePassword(Request $request)
    // {
    //     $admin = User::where('id', auth()->id())->first();

    //     // Validation
    //     $request->validate([
    //         'current_password' => 'required',
    //         'new_password'     => 'required|min:6|confirmed',
    //     ]);

    //     // Check current password
    //     if (!Hash::check($request->current_password, $admin->password)) {
    //         return redirect()->back()->withErrors([
    //             'current_password' => 'Current password is incorrect'
    //         ]);
    //     }

    //     $admin->password = Hash::make($request->new_password);
    //     $admin->save();

    //     return redirect()->back()->with('success', 'Password updated successfully!');
    // }

}
