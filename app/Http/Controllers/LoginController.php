<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Professional;
use App\Models\Patient;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Middleware\TrustHosts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    //méthode pour se connecter 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        //on vérifie que l'authentification respecte les conditions de validation
        if (Auth::guard('patient')->attempt($credentials)) {
            $patient = Patient::where('email', $credentials['email'])->first();
            if ($patient) {
                Auth::guard('patient')->login($patient);
                return response()->json(
                    ['message' => 'Vous êtes connecté' . ' ' . $credentials["email"]]
                );
            }
        } else if (Auth::guard('professional')->attempt($credentials)) {
            $professional = Professional::where('email', $credentials['email'])->first();
            if ($professional) {
                Auth::guard('professional')->login($professional);
                return response()->json(
                    ['message' => 'Vous êtes connecté' . ' ' . $credentials["email"]]
                );
            }
        } else if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Admin::where('email', $credentials['email'])->first();
            if ($admin) {
                Auth::guard('admin')->login($admin);
                return response()->json(
                    ['message' => 'Vous êtes connecté' . ' ' . $credentials["email"]]
                );
            }
        } else {
            // Si les informations de connexion sont invalides, redirigez l'utilisateur vers la page de connexion avec un message d'erreur
            return redirect()->back()->withErrors(
                [
                    'message' => 'Adresse email ou mot de passe incorrect.'
                ]
            );
        }
    }
    //méthode pour se déconnecter
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(
            ['message' => 'Vous êtes déconnecté.']
        );
    }
    //envoi d'un lien de réinitialisaion de mot de passe
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        //Utilisation de la façade pour envoi email
        $status = Password::sendResetLink(
            $request->only('email')
        );
        //Confirmation ou retour erreur
        return $status = Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
    //on affiche le formulaire de réinitialisation du mdp
    public function resetPassword(Request $request)
    {
        return view('password.resetForm');
    }
    //on modifie le mdp dans la bdd
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'string',
                'required',
                'min:8',
                'regex:^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^',
                'confirmed'
            ]
        ]);
        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            //Pour chaque Model via $user
            function ($user, $password) {
                if ($user instanceof Professional) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    event(new PasswordReset($user));

                    //PATIENT
                } elseif ($user instanceof Patient) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    event(new PasswordReset($user));
                    //ADMIN
                } elseif ($user instanceof Admin) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    event(new PasswordReset($user));
                }
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}