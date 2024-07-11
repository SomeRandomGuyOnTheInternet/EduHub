<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_picture_data' => 'nullable|string',
        ]);

        $user = Auth::user();

        if ($request->profile_picture_data) {
            $data = $request->profile_picture_data;
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $imageName = 'profile_pictures/' . uniqid() . '.png';
            Storage::put('public/' . $imageName, $data);
            $user->profile_picture = $imageName;
        } elseif ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && $user->profile_picture !== 'profile_pictures/profile-picture-placeholder.jpg') {
                Storage::delete('public/' . $user->profile_picture);
            }
            $profilePicturePath = $request->file('profile_picture')->store('public/profile_pictures');
            $user->profile_picture = str_replace('public/', '', $profilePicturePath);
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');


    }

}