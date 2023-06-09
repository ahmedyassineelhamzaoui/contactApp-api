<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');

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
    public function updateContact(Request $request)
    {
       $contact = Contact::find($request->id);
       if($contact){
        if($request->has('Nom')){
            $contact->Nom = $request->Nom;
        }
        if($request->has('Prenom')){
            $contact->Prenom = $request->Prenom;
        }
        if($request->has('Date_naissance')){
            $contact->Date_naissance = $request->Date_naissance;
        }
        if($request->has('Tel')){
            $contact->Tel = $request->Tel;
        }
        $contact->save();
        return response()->json([
            'message' => 'conatact updated successfuly',
            'contact' => $contact       
        ],200);
       }
       return response()->json([
        'message' => 'contact not found'
       ],404);
    }
    public function deleteContact(Request $request){
       $contact = Contact::find($request->id);
       if($contact){
        $contact->delete();
        return response()->json([
           'message' => 'contact deleted successfuly'
        ],200);
       }else{
        return response()->json([
            'message' => 'contact not found'
         ],404);
       }
    }
}
