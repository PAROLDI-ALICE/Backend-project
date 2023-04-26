<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Importation des classes pour le mail
use App\Models\Professional;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendConfirmMail;
use App\Mail\TestMail;

class MessageController extends Controller
{
    // Envoi du mail aux utilisateurs
    public function sendConfirmPro(Request $request)
    {
        //On valide la requête
        $this->validate($request, ['message' => 'bail|required']);

        //On récupère notre user professionnel pour envoi sur son email  :
        $professional = $request->only('email');
        //On envoie l'email
        Mail::to($professional)
            ->queue(new SendConfirmMail($request->all()));

        return back()->withText("Message envoyé");
    }

    //test Axel message de confirmation patient
    public function sendMessagePatient(Request $request)
    {
        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.'
        ];
        Mail::to('v.gaudin06@yahoo.fr')->send(new TestMail($mailData));
    }
}