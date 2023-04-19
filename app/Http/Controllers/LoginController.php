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
        if (Auth::guard('users')->attempt($credentials)) {
            $patient = Patient::where('email', $credentials['email'])->first();
            if ($patient) {
                Auth::guard('users')->login($patient);
                var_dump($patient);
            }
        }
        if (Auth::guard('professionals')->attempt($credentials)) {
            $professional = Professional::where('email', $credentials['email'])->first();
            if ($professional) {
                Auth::guard('professionals')->login($professional);
                var_dump($professional);
            }
        }
        if (Auth::guard('admins')->attempt($credentials)) {
            $admin = Admin::where('email', $credentials['email'])->first();
            if ($admin) {
                Auth::guard('admins')->login($patient);
                var_dump($admin);
            }
        }
        return response()->json([
            'message' => "Vous êtes connecté."
        ]);

        // Afficher les informations de session
        // else {
        //     // Si les informations de connexion sont invalides, redirigez l'utilisateur vers la page de connexion avec un message d'erreur
        //     return redirect()->back()->withErrors(
        //         [
        //             'message' => 'Adresse email ou mot de passe incorrect.'
        //         ]
        //     );
        // }
    }
    //méthode pour se déconnecter
    public function logout(Request $request)
    {
        //on appelle la méthode logout, pour déconnecter l'utilisateur
        Auth::logout();
        //on clôture la session
        $request->session()->invalidate();
        //on régénère le token csrf
        $request->session()->regenerateToken();
        //et on envoie un message de confirmation en json
        return response()->json([
            'message' => "Vous êtes déconnecté."
        ]);
    }
}