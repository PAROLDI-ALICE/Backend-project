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
    public function resetPassword(string $token)
    {
        return view('password.resetForm')->with(['token' => $token]);
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
                    //on écrase la valeur précédente
                    $user->forceFill([
                        //on crypte à nouveau le mot de passe
                        'password' => Hash::make($password)
                        //on attribue un token temporaire à l'utilisateur
                    ])->setRememberToken(Str::random(60));
                    //puis on sauvegarde les nouvelles données dans la BDD
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
            ? view('password.resetSuccess')
                ->with('status', __($status))
                ->with('redirectTo', 'http://localhost:3000/login')
            : back()->withErrors(['email' => [__($status)]]);

    }
}