<?php

namespace App\Http\Controllers\API;

use App\CongeEtat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\User;
use App\Division;
use App\Demande_Conge;
use App\Etat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DemandeCongeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $conges = Demande_Conge::latest()->where('utilisateur',Auth::id())->paginate(20);
        
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

        $this->validate($request,[
            'date_debut' => 'required',
            'date_fin' => 'required',
            'type' => 'required'
        ],
        [
            'type.required' => 'Le Type est obligatoire.',
            'date_debut.required' => 'La date de Début  nom est obligatoire.',
            'date_fin.required' => 'La date de Fin est obligatoire.'
       
        ]);


        // ajouter la demande de congé
        $demandeCongé = new Demande_Conge();
        $demandeCongé -> utilisateur = Auth::id();
        $demandeCongé->type = $request['type'];
        $demandeCongé->date_debut = $request['date_debut'];
        $demandeCongé->date_fin = $request['date_fin'];
        $demandeCongé->certificat = $request['certificat'];
        $demandeCongé->Commentaire = $request['Commentaire'];
        $demandeCongé->save();



        // ajouter congéEtat nº 1
        $Conge_etat = new CongeEtat();
        $Conge_etat->id_conge = $demandeCongé->id;
        $Conge_etat->id_etat = 1;
        $Conge_etat->save();


        // si l'utilisateur est Admin

        if(Auth::user()->type == "admin"){

            $Conge_etat = new CongeEtat();
            $Conge_etat->id_conge = $demandeCongé->id;
            $Conge_etat->id_etat = 2;
            $Conge_etat->save();

            $Conge_etat = new CongeEtat();
            $Conge_etat->id_conge = $demandeCongé->id;
            $Conge_etat->id_etat = 3;
            $Conge_etat->save();
        }

        if(Auth::user()->type == "Chef de division"){

            $Conge_etat = new CongeEtat();
            $Conge_etat->id_conge = $demandeCongé->id;
            $Conge_etat->id_etat = 2;
            $Conge_etat->save();

        }
        
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
        $conge = Demande_Conge::findOrFail($id);
        $conge->delete();
        
        DB::table('conge_etat')->where([
            ['id_conge', '=', $id],
        ])->delete();

        return ['message' => 'conge Deleted'];
    }
    public function getSoldeByConge($id)
    {
        $conge = Demande_Conge::findOrFail($id);
        $user = User::findOrFail($conge->utilisateur);
        return ['data' =>  $user->solde];
    }

    public  function getEtat( int $idConge )
    {
        $CongeEtat1 = null;
        $CongeEtat2 = null;
        $CongeEtat3 = null;

        $CongeEtat1 = DB::table('conge_etat')->where([
            ['id_conge', '=', $idConge],
            ['id_etat', '=', '1'],
        ])->get();

        $CongeEtat2 = DB::table('conge_etat')->where([
            ['id_conge', '=', $idConge],
            ['id_etat', '=', '2'],
        ])->get();

        $CongeEtat3 = DB::table('conge_etat')->where([
            ['id_conge', '=', $idConge],
            ['id_etat', '=', '3'],
        ])->get();

   
        return ['CongeEtat1' =>  $CongeEtat1 , 'CongeEtat2' =>  $CongeEtat2 , 'CongeEtat3' =>  $CongeEtat3];

    }

    public  function setEtat( int $idConge , int $idEtat)
    {

        // ajouter congéEtat
        $Conge_etat = new CongeEtat();
        $Conge_etat->id_conge = $idConge;
        //$intitulé = 'Nouvelle demande';
        //$etat = Etat::findOrFail($intitulé);
        $Conge_etat->id_etat = $idEtat;//$etat->id_etat ;
        $Conge_etat->save();
       

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
        $conges = DB::table('conges')->where([
            ['type', '=', $type]
        ])->get();
        
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
