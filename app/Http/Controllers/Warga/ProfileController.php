<?php

namespace App\Http\Controllers\Warga; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir profil user.
     */
    public function edit(Request $request): View
    {
        // Ambil user dan load relasi biodata
        $user = $request->user();
        
        // Memastikan relasi biodata dipanggil (lazy loading)
        // Kita tidak perlu mengirim variabel $biodata terpisah jika di view pakai $user->biodata
        // Tapi agar rapi, kita biarkan default view returnnya.
        
        return view('profile.edit', [
            'user' => $user,
        ]);
    }
    
    // ... method update dan destroy biarkan tetap sama ...


    /**
     * Memperbarui informasi profil user (Nama & Email).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // Jika email diubah, reset verifikasi email
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun user.
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