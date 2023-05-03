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
}
