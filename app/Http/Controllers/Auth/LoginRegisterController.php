<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LoginRegisterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['home', 'logout']),
            new Middleware('auth', only: ['home', 'logout']),
        ];
    }

    public function register(): View
    {
        return view('auth.register');
    }
    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,student'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'student',
            'status' => 'active'
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        
        return $this->redirectBasedOnRole($user)
            ->withSuccess('You have successfully registered & logged in!');
    }

    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            $user = Auth::user();
            
            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }
    
    public function home(): RedirectResponse
    {
        $user = Auth::user();
        return $this->redirectBasedOnRole($user);
    }
    
    /**
     * Redirect user based on their roles
     */
    private function redirectBasedOnRole(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isStudent()) {
            return redirect()->route('student.dashboard');
        }
        
        // Fallback for any unexpected role
        return redirect()->route('login')->with('error', 'Invalid user role.');
    } 
    
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}