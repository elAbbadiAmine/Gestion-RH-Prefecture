<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use App\Division;
use App\Demande_Conge;
use App\Demande_RH;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class DemandeRhAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $docs =  Demande_RH::paginate(20);
        foreach($docs as $doc){
            $users = User::findOrFail($doc->utilisateur);
            $doc -> utilisateur = $users ? $users->nom." ".$users->prenom : '';
        }
        return $docs;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getByName($nom){

        $rhs = Demande_RH::latest()->paginate(20);
        $results = [];
        $nom = strtolower($nom);

        foreach($rhs as $rh){     
            $utilisateur =  User::findOrFail($rh -> utilisateur); 
            if(str_contains(strtolower($utilisateur->nom),$nom) == true || str_contains(strtolower($utilisateur->prenom),$nom) == true ){
                $rh -> utilisateur = $utilisateur ? $utilisateur->nom." ".$utilisateur->prenom : '';
                $results[] = $rh;
            }
    
        }
       
        return $results;
    }
    
    public function getByType($type){
        $rhs = DB::table('demanderh')->where([
            ['type', '=', $type]
        ])->get();
        
        foreach($rhs as $rh){     
            $utilisateur =  User::findOrFail($rh -> utilisateur); 
            $rh -> utilisateur = $utilisateur ? $utilisateur->nom." ".$utilisateur->prenom : '';    
        }
        
        return $rhs;
    }

    public function getByLangue($langue){

        $rhs = DB::table('demanderh')->where([
            ['langue', '=', $langue]
        ])->get();
        
        foreach($rhs as $rh){     
            $utilisateur =  User::findOrFail($rh -> utilisateur); 
            $rh -> utilisateur = $utilisateur ? $utilisateur->nom." ".$utilisateur->prenom : '';    
        }
        
        return $rhs;
    }

    public function pdfview($idRH)  
    {  
        $rh = Demande_RH::findOrFail($idRH);

        $user = User::findOrFail($rh->utilisateur);

        view()->share('rh',$rh); 

        view()->share('user',$user);  
  
        $pdf = PDF::loadView('PDFdocumentRH'); 

        $name = $user->nom . "-" . $user->prenom . "-" . $rh->type . ".pdf";

        return $pdf->download($name);  
    }  
}
