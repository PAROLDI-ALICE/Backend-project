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
                dd($patient);
            }
        } else if (Auth::guard('professional')->attempt($credentials)) {
            $professional = Professional::where('email', $credentials['email'])->first();
            if ($professional) {
                Auth::guard('professional')->login($professional);
                dd($professional);
            }
        } else if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Admin::where('email', $credentials['email'])->first();
            if ($admin) {
                Auth::guard('admin')->login($admin);
                dd($admin);
            }
        }
        // Afficher les informations de session
        else {
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