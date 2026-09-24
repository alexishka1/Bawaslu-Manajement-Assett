<?php

namespace App\Http\Controllers;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect(Auth::user()->homeUrl());
        }

        return view('auth.login-staff');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect(Auth::user()->homeUrl());
        }

        return view('auth.register-staff');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'jabatan' => ['required', 'string', 'max:100'],
            'unit_kerja' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'unit_kerja.required' => 'Unit kerja wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'nip' => $validated['nip'] ?? null,
            'jabatan' => $validated['jabatan'],
            'unit_kerja' => $validated['unit_kerja'],
            'email' => strtolower($validated['email']),
            'password' => $validated['password'],
            'role' => 'staff',
            'is_verified' => false,
        ]);

        // Kirim notifikasi database ke semua Admin di panel Filament
        try {
            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::make()
                    ->title('Pendaftaran Staf Baru Menunggu Verifikasi')
                    ->body("Pegawai baru atas nama {$user->name} ({$user->jabatan} - {$user->unit_kerja}) telah mendaftar dan menunggu verifikasi akun.")
                    ->warning()
                    ->icon('heroicon-o-user-plus')
                    ->actions([
                        Action::make('view_users')
                            ->button()
                            ->label('Verifikasi Pengguna')
                            ->url(route('filament.admin.resources.users.index')),
                    ])
                    ->sendToDatabase($admins);
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('login')->with(
            'success',
            'Pendaftaran berhasil! Akun Anda sedang menunggu verifikasi dan persetujuan dari Administrator Bawaslu sebelum dapat digunakan.'
        );
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Cek apakah staf belum diverifikasi oleh admin
            if ($user->isStaff() && ! $user->isVerified()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda belum diverifikasi oleh Administrator Bawaslu. Silakan tunggu persetujuan admin.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            $intended = $request->session()->pull('url.intended');

            if ($intended && $this->intendedMatchesRole($intended, $user)) {
                return redirect($intended);
            }

            return redirect($user->homeUrl());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Cegah staff yang tadinya mau ke /admin/xxx malah di-redirect
     * balik ke situ setelah login (padahal dia bukan admin)
     */
    private function intendedMatchesRole(string $intendedUrl, $user): bool
    {
        $isAdminUrl = str_contains($intendedUrl, '/admin');

        return $user->isAdmin() ? true : ! $isAdminUrl;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
