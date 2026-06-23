<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite; 

class AuthController extends Controller
{
    // Arahin ke login page
    public function index()
    {
        return view('auth.login');
    }

    // Arahin ke register page
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:4|max:8|unique:users,username',
            'name' => 'required|string|min:6|max:12',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => ['required', 'string', 'max:12', Password::min(8)
                ->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ], [
            'username.required' => 'Username is required', 
            'username.min' => 'Username must be at least 4 characters',
            'username.max' => 'Username cannot exceed 8 characters',
            'username.unique' => 'This username is already taken', 

            'name.required' => 'Name is required', 
            'name.min' => 'Name must be at least 6 characters',
            'name.max' => 'Name cannot exceed 12 characters',

            'email.required' => 'E-mail is required', 
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'E-mail is already taken', 

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password' => 'Password must include mixed case, numbers, & symbols.',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        // dd($request->all()); 

        $credentials = $request->validate([
            'login' => 'required|string', // bisa username OR email
            'password' => 'required|string',
        ], [
            'login.required' => 'Username or E-mail is required', 
            'password.required' => 'Password is required'
        ]);

        // Kasih opsi login via username OR email
        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) 
            ? 'email' 
            : 'username';

        if (Auth::attempt([$field => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->with('error_message', 'Invalid Username/E-mail or Password.')->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function generateSluggedUsername($googleUser){
        $base = Str::slug($googleUser->name); 
        if (strlen($base) < 4) {
            $base = Str::random(4);
            }
        $base = substr($base, 0, 6);
        $username = $base . rand(10, 99);

        while (User::where('username', $username)->exists()) {
            $username = substr($base, 0, 6) . rand(10, 99); // keeps 4–8 range
        }

        return $username; 
    }

    public function handleGoogleCallback(){
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first(); 

        if(!$user){
            $user = User::where('email', $googleUser->email)->first(); 

            if($user){
                $user->update([
                    'google_id' => $googleUser->id, 
                    'auth_provider' => 'google', 
                    'avatar' => $googleUser->avatar
                ]); 
            }
            else{
                $username = $this->generateSluggedUsername($googleUser); 
                $user = User::create([
                    'username' => $username,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'auth_provider' => 'google',
                    'avatar' => $googleUser->avatar,
                    'password' => null,
                ]); 
            }
        }

        // dd($googleUser);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function sendOtp(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $otp = random_int(100000, 999999);

        Cache::put('otp_'.$email, $otp, now()->addMinutes(5));
        Mail::raw("Your OTP code is: $otp", function ($message) use ($email) {
            $message->to($email)
                    ->subject('Password Reset OTP');
        });

        session(['reset_email' => $email]);

        return redirect()->route('otp');
    }

    public function verifyOtp(Request $request){
        $request->validate([
            'otp' => 'required'
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('forgot')
                ->withErrors(['email' => 'Session expired. Please try again.']);
        }

        $storedOtp = Cache::get('otp_'.$email);

        if (!$storedOtp || $storedOtp != $request->otp) {
            return back()->with('error_message', 'Invalid or expired OTP');
        }

        // clear OTP kalau udah sukses
        Cache::forget('otp_'.$email);

        return redirect()->route('reset.password');
    }

    public function resetPassword(Request $request){
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),    
            ],
        ]); 

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('forgot');
        }
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'New password cannot be the same as your old password.'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login');
    }
}