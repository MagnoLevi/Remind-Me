<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Return Login blade or index blade
     */
    public function index()
    {
        if (Auth::guest()) {
            return view("login");
        }

        return redirect()->intended("");
    }


    /**
     * Register new user
     */
    public function store(Request $request)
    {
        $errors = [];

        User::whereRaw("email = '$request->email'")->exists() ? $errors[] = "Email already registered." : "";
        $request->password != $request->password_confirm ? $errors[] = "Passwords don't match." : "";
        strlen($request->password) < 6 ? $errors[] = "Password must have 6 digits or more." : "";

        if (count($errors) > 0) {
            return redirect()->back()->with("errors", $errors);
        }

        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();


        Auth::login($user);

        $session = new UserSession();
        $session->user_id = Auth::user()->id;
        $session->uuid = Str::uuid();
        $session->login_date = date('Y-m-d H:i:s');
        $session->save();


        return redirect()->intended("");
    }


    /**
     * Login user
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only("email", "password");
        $authenticated = Auth::attempt($credentials);

        if ($authenticated) {
            $session = new UserSession();
            $session->user_id = Auth::user()->id;
            $session->uuid = Str::uuid();
            $session->login_date = date('Y-m-d H:i:s');
            $session->save();

            return redirect()->intended("");
        }

        return redirect()->intended("login")->with("error", "Email or password invalid");
    }


    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->intended("");
    }


    /**
     * Send email for user about forgot password
     */
    public function forget_password(Request $request)
    {
        $request->validate([
            "email" => "exists:users"
        ]);



        $pass_reset = new PasswordResetToken();
        $pass_reset->email = $request->email;
        $pass_reset->token = Str::random(64);
        $pass_reset->save();


        Mail::send('email.forget_password', ["token" => $pass_reset->token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject("Reset Password");
        });

        return redirect()->to(route("user.index"))->with("div", "forget_pass_div");
    }


    /**
     * Reset user's password
     */
    public function reset_password(Request $request)
    {
    }
}
