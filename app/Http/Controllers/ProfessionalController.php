<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professionals = Professional::paginate(20);
        return response()->json($professionals);
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
    {
        //on crée une instance du validateur 
        //on lui envoie la requête comme premier argument
        $validator = Validator::make($request->all(), [
            //puis on définit les restrictions pour chaque input
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:professionals,email',
            //REGEX pour le password (minimum 8 caractères et comportant une lettre, un chiffre et un symbole)
            'password' => [
                'string',
                'required',
                'min:8',
                'regex:^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^'
            ],
            'experienceYears' => 'required|integer|min:0',
            'city' => 'required|in: "Nice", "Cagnes-sur-mer", "St-Laurent-du-Var"',
            'profession' => 'required|string|max:255',
            'price' => 'required|string',
            'diplomas' => 'required|string|max:255',
            'languages' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'skills' => [
                'required',
                Rule::in([
                    "mobility",
                    "cooking",
                    "houseCleaning",
                    "dressing",
                    "reeducation",
                    "hygiene",
                    "nursing",
                    "treatment",
                    "entertainment",
                    "driving"
                ])
            ]
        ]);
        //si la validation échoue, on envoie un code d'erreur 422 et les erreurs associées
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }
        //sinon création du compte en base de données via la récupération des inputs
        else {
            $professional = [
                'lastname' => $request->input('lastname'),
                'firstname' => $request->input('firstname'),
                'phoneNumber' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                // Hashing the password
                'password' => bcrypt($request->input('password')),
                'profession' => $request->input('profession'),
                'price' => $request->input('price'),
                'experienceYears' => $request->input('experienceYears'),
                'experienceDetails' => $request->input('experienceDetails'),
                'city' => $request->input('city'),
                'diplomas' => $request->input('diplomas'),
                'languages' => $request->input('languages'),
                'description' => $request->input('description'),
                'skills' => $request->input('skills')
            ];
            Professional::create($professional);
            //on renvoie un code 200 et un message de confirmation de création.
            return response()->json([
                'success' => true,
                'message' => 'Le compte professionnel a bien été créé.',
                'professional' => $professional
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Récuperer l'ID d'un professionel via le modèle
        $professionalID = Professional::findOrFail($id);
        return response()->json(["professionalID" => $professionalID]);
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
        //on valide le format de la modification
        $request->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'phoneNumber' => 'required|string',
            'profession' => 'required|string',
            'price' => 'required|string',
            'experienceYears' => 'required|string',
            'experienceDetails' => 'required|string',
            'city' => 'required|in: "Nice", "Cagnes-sur-mer", "St-Laurent-du-Var"',
            'diplomas' => 'required|string',
            'languages' => 'required|string',
            'description' => 'required|string',
            'skills' => 'required|string'
        ]);
        //on fait correspondre la valeur de chaque table à celle de l'input de modification
        $modifProfessional = Professional::findOrFail($id);
        $modifProfessional->lastname = $request->input('lastname');
        $modifProfessional->firstname = $request->input('firstname');
        $modifProfessional->phoneNumber = $request->input('phoneNumber');
        $modifProfessional->profession = $request->input('profession');
        $modifProfessional->price = $request->input('price');
        $modifProfessional->experienceYears = $request->input('experienceYears');
        $modifProfessional->experienceDetails = $request->input('experienceDetails');
        $modifProfessional->city = $request->input('city');
        $modifProfessional->diplomas = $request->input('diplomas');
        $modifProfessional->languages = $request->input('languages');
        $modifProfessional->description = $request->input('description');
        $modifProfessional->skills = $request->input('skills');
        //puis on sauvegarde en BDD
        $modifProfessional->save();
        //redirection page precedente et message : success =)
        return response()->json([
            'message' => 'Votre modification a été prise en compte',
            'modifProfessional' => $modifProfessional
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    //fonction pour filtrer en fonction de l'id
    public function filterSkills(string $keyword)
    {
        // Commencez à construire la requête de recherche
        $professionals = Professional::query();
        // Ajouter une clause WHERE personnalisée pour rechercher le mot-clé dans le champ "skills"
        $professionals->whereRaw("FIND_IN_SET('$keyword', skills) > 0");
        // Récupérer les résultats de la requête
        $results = $professionals->get();
        // Retourner les résultats sous forme de réponse JSON
        return response()->json(['professionals' => $results]);
    }
}