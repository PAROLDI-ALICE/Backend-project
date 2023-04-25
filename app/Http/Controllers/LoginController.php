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
                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'message' => 'Adresse email ou mot de passe incorrect.'
                ]);
            }
        } else if (Auth::guard('professional')->attempt($credentials)) {
            $professional = Professional::where('email', $credentials['email'])->first();
            if ($professional) {
                Auth::guard('professional')->login($professional);
                return response()->json([
                    'success' => true,
                ]);
                    
                
            } else {
                return response()->json([
                    'message' => 'Adresse email ou mot de passe incorrect.'
                ]);
            }
        } else if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Admin::where('email', $credentials['email'])->first();
            if ($admin) {
                Auth::guard('admin')->login($admin);
                return response()->json([
                    'success' =>  true
                ]);
            } else {
                return response()->json([
                    'message' => 'Adresse email ou mot de passe incorrect.'
                ]);
            }
        }
            return response()->json([
            'message' => 'Adresse email ou mot de passe incorrect.'
        ]);
        
    }
    
    //méthode pour se déconnecter
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(
            ['message' => 'Vous êtes déconnecté.']
        );
    }

}