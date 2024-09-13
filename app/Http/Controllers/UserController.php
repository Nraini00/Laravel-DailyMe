<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    //login page
    public function login()
    {
        return view("auth.login");
    }

    //login form
    function loginPost(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);
        
        $credentials = $request->only("email","password");
        if(Auth::attempt($credentials)) {
           return redirect()->intended(route("dashboard"));
        }
        return redirect(route("login"))
            ->with("error", "login failed");
    }

    // register page
    function register() 
    {
        return view("auth.register");
    }

    // register form
    function registerPost(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "name" => "required",
            "username" => "required",
            "email" => "required",
            "password" => "required",
            "gender" => "required"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->gender = $request->gender;
        
        if ($user->save()) {
            echo "<script>alert('Registration Successful'); window.location.href='".route("login")."';</script>";
            exit;  // Ensure the script stops execution after alert
        } else {
            echo "<script>alert('Email already exists or an error occurred.');</script>";
            return view("auth.register"); 
        }
    }

    //profile img
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profileImg' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Handle image upload
        if ($request->hasFile('profileImg')) {
            // Delete old image if exists
            if ($user->profileImg && Storage::exists('public/' . $user->profileImg)) {
                Storage::delete('public/' . $user->profileImg);
            }

            // Store new image
            $path = $request->file('profileImg')->store('profile_images', 'public');

            // Update profileImg in the user table
            $user->profileImg = $path;
            $user->save();

            return response()->json(['success' => true, 'imagePath' => asset('storage/' . $path)]);
        }

        return response()->json(['success' => false]);
    }


     // update user details
     public function updateProfile(Request $request)
     {
         $user = Auth::user();
     
         // Validate the incoming request
         $request->validate([
             'name' => 'required|string|max:255',
             'username' => 'required|string|max:255|unique:user,username,' . $user->id,
             'email' => 'required|email|max:255|unique:user,email,' . $user->id,
             'gender' => 'required|string',
         ]);
     
         // Update user details
         $user->name = $request->name;
         $user->username = $request->username;
         $user->email = $request->email;
         $user->gender = $request->gender;
     
         $user->save();
     
         return redirect()->back()->with('success', 'Profile updated successfully!');
     }
     

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }




}
