<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

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
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phoneNumber' => 'required|int|max:10',
            'email' => 'required|string|email|max:255|unique:patients,email',
            'password' => 'required|string|min:8',
            'address' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:150',
            'needs' => 'nullable|string|max:1000',
            'additional_information' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:1000'
        ]);


        $patient = [

            'lastname' => $request->input('name'),
            'firstname' => $request->input('firstname'),
            'phoneNumber' => $request->input('phoneNumber'),
            'email' => $request->input('email'),
            // 'password' => $request->input('password')
            'password' => bcrypt($request->input('password')),
            // Hashing the password
            'address' => $request->input('address'),
            'age' => $request->input('age'),
            'needs' => $request->input('needs'),
            'additional_information' => $request->input('additional_information'),
            'description' => $request->input('description')
        ];

        Patient::create($patient);
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