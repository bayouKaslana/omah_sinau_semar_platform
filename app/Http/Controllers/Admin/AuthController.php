<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminOtp;
use App\Models\User;
use App\Mail\AdminOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'admin')
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah.');
        }

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Hapus OTP lama, simpan yang baru
        AdminOtp::where('email', $user->email)->delete();
        AdminOtp::create([
            'email'      => $user->email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Kirim OTP via email
        Mail::to($user->email)->send(new AdminOtpMail($otp));

        // Simpan email di session untuk verifikasi
        session()->put('otp_email', $user->email);
        session()->put('otp_name', $user->name);
        session()->save();

        return redirect()->route('admin.otp.form');
    }

    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('admin.login');
        }
        return view('admin.auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $email = session()->get('otp_email');

        $record = AdminOtp::where('email', $email)
                          ->where('otp', $request->otp)
                          ->where('expires_at', '>', now())
                          ->first();

        if (!$record) {
            return back()->with('error', 'Kode OTP salah atau sudah kadaluarsa.');
        }

        // Hapus OTP setelah berhasil
        $record->delete();

        // Set session admin
        session([
            'admin_logged_in' => true,
            'admin_name'      => session('otp_name'),
            'admin_email'     => $email,
        ]);

        session()->forget(['otp_email', 'otp_name']);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        session()->forget(['admin_logged_in', 'admin_name', 'admin_email']);
        return redirect()->route('admin.login');
    }

    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Admin baru berhasil didaftarkan!');
    }

}