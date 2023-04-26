<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

class AdminController extends Controller
{
    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:admins',
            //REGEX pour le password (minimum 8 caractères et comportant une lettre, un chiffre et un symbole)
            'password' => [
                'string',
                'required',
                'min:8',
                'regex:^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^'
            ],
        ]);
        //si la validation échoue, on envoie un code d'erreur 422 et les erreurs associées
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        } else {
            $admin = [
                'email' => $request->input('email'),
                //on "hash" le mdp
                'password' => bcrypt($request->input('password'))
            ];

            Admin::create($admin);
            //on renvoie un code 200 et un message de confirmation de création.
            return response()->json([
                'success' => true,
                'message' => 'Le compte admin a bien été créé.',
                'admin' => $admin
            ]);
        }
    }
}