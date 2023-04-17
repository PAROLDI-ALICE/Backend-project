<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { //on crée une instance du validateur 
        //on lui envoie la requête comme premier argument
        $validator = Validator::make($request->all(), [
            //puis on définit les restrictions pour chaque input
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phoneNumber' => 'required|string',
            'email' => 'required|string|email|max:255|unique:patients,email',
            //REGEX pour le password (minimum 8 caractères et comportant une lettre, un chiffre et un symbole)
            'password' => [
                'string',
                'required',
                'min:8',
                'regex:^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^'
            ],
            'address' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:150',
            'needs' => 'required|string|max:1000',
            'additional_information' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:1000'
        ]);
        //si la validation échoue, on envoie un code d'erreu 422 et les erreurs associées
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }
        //sinon création du compte en base de donnée via la recupération des inputs
        else {
            $patient = [
                'lastname' => $request->input('lastname'),
                'firstname' => $request->input('firstname'),
                'phoneNumber' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                // Hashing the password
                'password' => bcrypt($request->input('password')),
                'address' => $request->input('address'),
                'age' => $request->input('age'),
                'needs' => $request->input('needs'),
                'additional_information' => $request->input('additional_information'),
                'description' => $request->input('description')
            ];
            Patient::create($patient);
            //on renvoie un code 200 et un message de confirmation de création.
            return response()->json([
                'message' => 'Votre profil a bien été créé',
                'patient' => $patient
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}