<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Division;
use App\User;
use Illuminate\Support\Facades\Hash;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions =  Division::latest()->paginate(20);


        foreach($divisions as $div){
            
            $chef_division =  User::findOrFail($div->Chef_division); 
            $div->Chef_division = $chef_division ? $chef_division->nom." ".$chef_division->prenom : '';

        }
        return $divisions;
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
            'Division' => 'required|string|max:191',
            'Chef_division' => 'required',
        ]);

        $newDivision = New Division();
        $newDivision->Division = $request['Division'];
        $newDivision->Chef_division = $request['Chef_division'];

        $newDivision->save();

       // return Division::create([
           // 'Division' => $request['Division'],           
          //  'Chefdivision' => $request['Chefdivision'],
       // ]);

        return ['message' => "created"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $division = Division::findOrFail($id);
         $chef_division =   User::findOrFail($division->Chef_division); 
         $division->Chef_division = $chef_division ? $chef_division->nom." ".$chef_division->prenom : '';
        return $division;
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
        $division = Division::findOrFail($id);
        $this->validate($request,[
            'Division' => 'required|string|max:191',
            'Chef_division' => 'required',
        ]);
        // $division ->update($request->all());
        $division -> Division = $request['Division'];
        $division -> Chef_division = $request['Chef_division'];
        $division-> save();


        return ['message' => 'Updated the division info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $division = Division::findOrFail($id);

        $division->delete();

        return ['message' => 'Division Deleted'];
    }
    
    public function UserDivisions(request $request){
       $userdev = User::all();
       $result = [];
      // $userdev = Division::all();
       foreach($userdev as $user){
           if(sizeof(Division::where('Chef_division',$user->id)->get())==0)
            $result[] =  $user;
       }

        return ['data' => $result]; // or return response()->json(['data' => employees]);
    }
}
