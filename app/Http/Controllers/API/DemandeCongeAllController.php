<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use App\Division;
use App\Demande_Conge;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DemandeCongeAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conges = Demande_Conge::paginate(20);
        foreach($conges as $conge){
            $users = User::findOrFail($conge->utilisateur);
            $conge -> utilisateur = $users ? $users->nom." ".$users->prenom : '';
        }
        return $conges;
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

        $conges = Demande_Conge::latest()->paginate(20);
        $results = [];
        $nom = strtolower($nom);

        foreach($conges as $conge){     
            $utilisateur =  User::findOrFail($conge -> utilisateur); 
            if(str_contains(strtolower($utilisateur->nom),$nom) == true || str_contains(strtolower($utilisateur->prenom),$nom) == true ){
                $conge -> utilisateur = $utilisateur ? $utilisateur->nom." ".$utilisateur->prenom : '';
                $results[] = $conge;
            }
    
        }
       
        return $results;
    }
    
    public function getByType($type){

        $conges = DB::table('conges')->where('type', '=', $type)->get(); 
        
        foreach($conges as $conge){     
            $utilisateur =  User::findOrFail($conge -> utilisateur); 
            $conge -> utilisateur = $utilisateur ? $utilisateur->nom." ".$utilisateur->prenom : '';    
        }
        
        return $conges;
    }

    public function getByDate($dateFrom,$dateTo){

        $conges = DB::table('conges')->where('date_debut', '>=', $dateFrom)->where('date_fin', '<=', $dateTo)->get();

        foreach($conges as $conge){     
            $utilisateur =  User::findOrFail($conge -> utilisateur); 
            $conge -> utilisateur = $utilisateur ? $utilisateur->nom." ".$utilisateur->prenom : '';    
        }
        
        return $conges;
    }

}
