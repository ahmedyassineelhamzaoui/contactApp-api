<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $contacts =  Contact::all('Nom','Prenom','Date_naissance','Tel');
        if(count($contacts)>0){
            return response()->json([
                'message' => 'success',
                'contacts' =>  $contacts,
            ],200);
        }
        return response()->json([
            'message' => 'info',
            'content' => 'there is no contact yet'
        ],404);
        
    }
    public function createContact(Request $request)
    {
        $request->validate([
            'Nom' => 'required|string|min:2',
            'Prenom' => 'required|string|min:2',
            'Date_naissance' => 'required',
            'Tel' => 'required',
          ]);
        
       $contact =  Contact::create([
          'Nom' => $request->Nom,
          'Prenom' => $request->Prenom,
          'Date_naissance' => $request->Date_naissance,
          'Tel' => $request->Tel,
        ]);
       if($contact){
        return response()->json([
            'message' => 'success',
            'content' => 'contact created successfuly'
        ],200);
       }
       return response()->json([
        'message' => 'error',
        'content' => 'something went wrong'
       ]);
    }
}
