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
            'needs' => 'required|array',
            'needs.*' => 'in:mobility,cooking,houseCleaning,clothesChange,reeducation,hygiene,nursing,medication,entertainment,transportation',
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
            //on récupère les besoins qui sont contenus dans un tableau
            $needs = $request->input('skills');
            //on "éclate" le tableau en string, chacune séparée par une virgule
            $needs_str = implode(', ', $needs);
            $patient = [
                'lastname' => $request->input('lastname'),
                'firstname' => $request->input('firstname'),
                'phoneNumber' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                // Hashing the password
                'password' => bcrypt($request->input('password')),
                'address' => $request->input('address'),
                'needs' => $needs_str,
                'age' => $request->input('age'),
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
     * PUT/PATCH
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phoneNumber' => 'required|string',
            'address' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:150',
            'needs' => 'required|array',
            'needs.*' => 'in:mobility,cooking,houseCleaning,clothesChange,reeducation,hygiene,nursing,medication,entertainment,transportation',
            'additional_information' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:1000'
        ]);
        //on récupère les besoins qui sont contenus dans un tableau
        $needs = $request->input('skills');
        //on "éclate" le tableau en string, chacune séparée par une virgule
        $needs_str = implode(', ', $needs);

        //on fait correspondre la valeur de chaque table à celle de l'input de modification
        $modifPatient = Patient::findOrFail($id);
        $modifPatient->lastname = $request->input('lastname');
        $modifPatient->firstname = $request->input('firstname');
        $modifPatient->phoneNumber = $request->input('phoneNumber');
        $modifPatient->address = $request->input('address');
        $modifPatient->age = $request->input('age');
        $modifPatient->needs = $needs_str;
        $modifPatient->additional_information = $request->input('additional_information');
        $modifPatient->description = $request->input('description');
        //puis on sauvegarde en BDD
        $modifPatient->save();
        //on redirige vers la page précédente, avec un message de succès
        return response()->json([
            "message" => "Votre modification a été prise en compte.",
            "modifPatient" => $modifPatient
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
    }
}