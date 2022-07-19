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
        // $this->validate($request,[
        //      'type' => 'required|string|max:191',
        //      'date_debut' => 'required',
        //      'date_fin' => 'required',
        //      'durée' => 'required',
        //      
        //   ]);

        $demandeCongé = new Demande_Conge();
        $demandeCongé -> utilisateur = Auth::id();
        $demandeCongé->type = $request['type'];
        $demandeCongé->date_debut = $request['date_debut'];
        $demandeCongé->date_fin = $request['date_fin'];
        $demandeCongé->durée = $request['durée'];
        $demandeCongé->certificat = $request['certificat'];
        $demandeCongé->Commentaire = $request['Commentaire'];
        $demandeCongé->save();
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
}
