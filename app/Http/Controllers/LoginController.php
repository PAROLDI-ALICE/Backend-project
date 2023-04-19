<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Professional;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

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
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = null;
        // Chercher l'utilisateur dans toutes les tables de votre application
        if ($user = Patient::where('email', $request->email)->first()) {
            $userType = 'patient';
        } elseif ($user = Professional::where('email', $request->email)->first()) {
            $userType = 'professional';
        } elseif ($user = Admin::where('email', $request->email)->first()) {
            $userType = 'admin';
        } else {
            return response()->json([
                'message' => "Email incorrect."
            ]);
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status = Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);

    }
}