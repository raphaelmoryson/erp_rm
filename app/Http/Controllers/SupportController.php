<?php

namespace App\Http\Controllers;

use App\Models\SupportUnit;
use App\Models\Unit;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function create(string $slug)
    {
        $supportUnit = Unit::where('slugId', $slug)->with('property', 'tenant')->first();

        if (!$supportUnit) {
            return "existe pas.";
        }
        return view('support', [
            'supportUnit' => $supportUnit,
        ]);
    }


    public function send(Request $request, string $slug)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // \Mail::to('support@exemple.com')->send(new SupportRequestMail($tenant, $request->message));


        return $request;
        // SupportUnit::create([
        //     'message' => $request->message,
        //     'tenant_id' => $request->id,
        // ]);

        // return redirect()->back()->with('success', 'Votre message a été envoyé au support.');
    }


}
