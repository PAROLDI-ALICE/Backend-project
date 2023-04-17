<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;

class ProfessionalController extends Controller
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
            'phoneNumber' => 'required|integer|max:10',
            'email' => 'required|string|email|max:255|unique:professionals,email',
            'password' => 'required|string|min:8',
            'experienceYears' => 'nullable|integer|min:0',
            'diplomas' => 'nullable|string|max:255',
            'languages' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'skills' => 'string|max:100'
        ]);

        $professional = [

            'lastname' => $request->input('name'),
            'firstname' => $request->input('firstname'),
            'phoneNumber' => $request->input('phoneNumber'),
            'email' => $request->input('email'),
            // 'password' => $request->input('password')
            'password' => bcrypt($request->input('password')),
            // Hashing the password
            'experienceYears' => $request->input('experienceYears'),
            'diplomas' => $request->input('diplomas'),
            'languages' => $request->input('languages'),
            'description' => $request->input('description'),
            'skills' => $request->input('skills')
        ];
        Professional::create($professional);
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