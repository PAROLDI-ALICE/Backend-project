<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Professional;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            }
        } else if (Auth::guard('professional')->attempt($credentials)) {
            $professional = Professional::where('email', $credentials['email'])->first();
            if ($professional) {
                Auth::guard('professional')->login($professional);
            }
        } else if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Admin::where('email', $credentials['email'])->first();
            if ($admin) {
                Auth::guard('admin')->login($admin);
            }
        }
        return response()->json([
            'message' => "Vous êtes connecté."
        ]);

        // Afficher les informations de session
       
    }

    //méthode pour se déconnecter
    public function logout(Request $request)
    {
        //Déconnection pour toutes les sessions
        Auth::logout();

        return response()->json([
            'message' => "Vous êtes déconnecté."
        ]);
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
        };

        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'Aucun utilisateur n\'a été trouvé avec cette adresse email'
            ]);
        }

        // $token = app('auth.password.broker')->createToken($user);

        $user->sendPasswordResetNotification($userType);

        return response()->json([
            'message' => "demande de reinitialisation envoyée."
        ]);
    }
}
