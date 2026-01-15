<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display user profile
     */
    public function show()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'Data karyawan tidak ditemukan.');
        }

        return view('user.profile', compact('employee'));
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        $employee->update($validated);

        // Update user name juga
        $employee->update(['name' => $validated['nama_lengkap']]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update profile photo
     */
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $request->validate(
            [
                'foto_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            ],
            [
                'foto_profile.required' => 'Pilih foto terlebih dahulu.',
                'foto_profile.image' => 'File harus berupa gambar.',
                'foto_profile.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
                'foto_profile.max' => 'Ukuran file maksimal 2MB.',
            ],
        );

        try {
            // Hapus foto lama jika ada
            if ($employee->foto_profile && Storage::disk('public')->exists($employee->foto_profile)) {
                Storage::disk('public')->delete($employee->foto_profile);
            }

            // Upload foto baru
            $path = $request->file('foto_profile')->store('profile-photos', 'public');

            // Update database
            $employee->update(['foto_profile' => $path]);

            return back()->with('success', 'Foto profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        try {
            // Hapus foto dari storage
            if ($employee->foto_profile && Storage::disk('public')->exists($employee->foto_profile)) {
                Storage::disk('public')->delete($employee->foto_profile);
            }

            // Update database
            $employee->update(['foto_profile' => null]);

            return back()->with('success', 'Foto profil berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        // Update password
        $user->employee->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
