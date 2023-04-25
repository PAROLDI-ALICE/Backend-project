<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use Stripe\Exception;
use Stripe\StripeClient;
use Stripe\Exception\CardException;

class StripeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleStripe(Request $request)
    {
        //Rappel Clé
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        //Générer un token pour le paiement
        $token = $request->input('stripeToken');
        try {
            Stripe\Charge::create([
                "amount" => 1,
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement pour Matchy Care"
            ]);
            //Paiement réussi
            return response()->json(['success' => true]);
        } catch (\Stripe\Exception\CardException $e) {
            //Paiement échec
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
