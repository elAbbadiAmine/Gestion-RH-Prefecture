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
        return Demande_Conge::latest()->where('utilisateur',Auth::id())->paginate(20);
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

        // ajouter la demande de congé
        $demandeCongé = new Demande_Conge();
        $demandeCongé -> utilisateur = Auth::id();
        $demandeCongé->type = $request['type'];
        $demandeCongé->date_debut = $request['date_debut'];
        $demandeCongé->date_fin = $request['date_fin'];
        $demandeCongé->certificat = $request['certificat'];
        $demandeCongé->Commentaire = $request['Commentaire'];
        $demandeCongé->save();



        // ajouter congéEtat
        $Conge_etat = new CongeEtat();
        $Conge_etat->id_conge = $demandeCongé->id;
        //$intitulé = 'Nouvelle demande';
        //$etat = Etat::findOrFail($intitulé);
        $Conge_etat->id_etat = 1;//$etat->id_etat ;
        $Conge_etat->save();
        
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




}
