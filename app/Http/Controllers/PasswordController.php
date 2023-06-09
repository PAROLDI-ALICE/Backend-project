<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Professional;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    //envoi d'un lien de réinitialisaion de mot de passe
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        //Chercher les emails autres que par défaut
        if (Admin::where('email', $request->email)->exists()) {
            $status = Password::broker('admins')->sendResetLink($request->only('email'));
        } else if (Professional::where('email', $request->email)->exists()) {
            $status = Password::broker('professionals')->sendResetLink($request->only('email'));
            //sinon on utilise le "broker" par défaut (qui correspond aux patients)
        } else {
            $status = Password::broker()->sendResetLink($request->only('email'));
        }
        //Confirmation ou retour erreur
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
    //on affiche le formulaire de réinitialisation du mdp
    public function resetPassword(Request $request, string $token)
    {
        return view('password.resetForm')->with(['token' => $token, 'email' => $request->email]);
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
        //on vérifie pour chaque modèle que l'adresse mail existe
        if (Admin::where('email', $request->email)->exists()) {
            //on définit quel "broker" utiliser dans le fichier auth
            $status = Password::broker('admins')->reset(
                $request->only(
                    'email',
                    'password',
                    'password_confirmation',
                    'token'
                ),
                //on exécute la fonction callback qui écrase l'ancien mdp
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    event(new PasswordReset($user));
                }
            );
        } elseif (Professional::where('email', $request->email)->exists()) {
            $status = Password::broker('professionals')->reset(
                $request->only(
                    'email',
                    'password',
                    'password_confirmation',
                    'token'
                ),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    event(new PasswordReset($user));
                }
            );

        } else {
            $status = Password::reset(
                $request->only(
                    'email',
                    'password',
                    'password_confirmation',
                    'token'
                ),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    event(new PasswordReset($user));
                }
            );
        }
        return $status === Password::PASSWORD_RESET
            ? view('password.resetSuccess')
                ->with('status', __($status))
                ->with('redirectTo', 'http://localhost:3000/login')
            : back()->withErrors(['email' => [__($status)]]);
    }
}