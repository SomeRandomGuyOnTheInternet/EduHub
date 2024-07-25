<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class StudentProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('student.profile.edit', [
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
            $imageName = uniqid() . '.png';
            Storage::put('profile-pics/' . $imageName, $data10240);
            $user->profile_picture = $imageName;
        } elseif ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && $user->profile_picture !== '/default-profiles/placeholder.jpg') {
                Storage::delete('profile-pics/' . $user->profile_picture);
            }
            $profilePicturePath = $request->file('profile_picture')->store('/profile-pics/');
            $user->profile_picture = $profilePicturePath;
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