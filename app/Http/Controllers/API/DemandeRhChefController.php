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

class DemandeRhChefController extends Controller
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
        $div = Division::where('Chef_division',Auth::id())->get();
        $loadusers = DB::table('users')->select('id')->where('Division',$div[0]->id)->get();
        $idUsers=[];
        foreach($loadusers as $loaduser){
            $idUsers[]=$loaduser->id;
        }
        $conges = Demande_RH::WhereIn('utilisateur',$idUsers)->paginate(20);
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

        $div = Division::where('Chef_division',Auth::id())->get();

        $loadusers = DB::table('users')->select('id')->where([
            ['Division', $div[0]->id]
        ])->where('nom', 'like', '%' . $nom . '%')->orWhere('prenom', 'like', '%' . $nom . '%')->get();

        $idUsers=[];

        foreach($loadusers as $loaduser){
            $idUsers[]=$loaduser->id;
        }

        $rhs = DB::table('demanderh')->WhereIn('utilisateur',$idUsers)->get();


        foreach($rhs as $rh){  
            $user = User::findOrFail($rh->utilisateur);   
            $rh -> utilisateur = $user ? $user->nom." ".$user->prenom : '';
        }
    
        return $rhs;
    }
    
    public function getByType($type){

        $div = Division::where('Chef_division',Auth::id())->get();

        $loadusers = DB::table('users')->select('id')->where([
            ['Division', $div[0]->id]
        ])->get();

        $idUsers=[];

        foreach($loadusers as $loaduser){
            $idUsers[]=$loaduser->id;
        }

        $rhs = DB::table('demanderh')->WhereIn('utilisateur',$idUsers)->where('type', '=', $type)->get(); 

        
        foreach($rhs as $rh){     
            $utilisateur =  User::findOrFail($rh -> utilisateur); 
            $rh -> utilisateur = $utilisateur ? $utilisateur->nom." ".$utilisateur->prenom : '';    
        }
        
        return $rhs;
    }

    public function getByLangue($langue){
        
        $div = Division::where('Chef_division',Auth::id())->get();

        $loadusers = DB::table('users')->select('id')->where([
            ['Division', $div[0]->id]
        ])->get();

        $idUsers=[];

        foreach($loadusers as $loaduser){
            $idUsers[]=$loaduser->id;
        }

        $rhs = DB::table('demanderh')->WhereIn('utilisateur',$idUsers)->where('langue', '=', $langue)->get(); 

        
        foreach($rhs as $rh){     
            $utilisateur =  User::findOrFail($rh -> utilisateur); 
            $rh -> utilisateur = $utilisateur ? $utilisateur->nom." ".$utilisateur->prenom : '';    
        }
        
        return $rhs;
    }
}
