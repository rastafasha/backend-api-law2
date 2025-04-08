<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Models\Country;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paises = Pais::orderBy('id', 'DESC')
        
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los paises',
            'paises' => $paises,
        ], 200);
    }

    public function countriesCode()
    {
        $paises = Pais::orderBy('id', 'DESC')
        
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los paises',
            'paises' => $paises,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pais_is_valid = Pais::where("user_id", $request->user_id)->first();
        $request->request->add(["ciudades"=>json_encode($request->ciudades)]);

        $pais = Pais::create($request->all());

        return response()->json([
            "message"=>200,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pais = Pais::findOrFail($id);

        return response()->json([
            "pais" => $pais,
            "ciudades"=>json_decode($pais-> ciudades),
            
        ]);
    }
    public function showCode($code)
    {
        $pais = Pais::where("code",  $code)->first();

        if ($pais) {
            $ciudades = json_decode($pais->ciudades, true);

            $sorted = collect($ciudades)->sortBy('ciudad')->toArray();

            return response()->json([
                "pais" => $pais,
                "ciudades" => $sorted ?: null,
            ]);
        } else {
            return response()->json([
                "message" => "Pais not found",
            ], 404);
        }
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
        $pais_is_valid = Pais::where("id", "<>", $id)->first();

        $request->request->add(["ciudades"=>json_encode($request->ciudades)]);
        
        $pais = Pais::findOrFail($id);

        $pais->update($request->all());
        
        // error_log($slider);

        return response()->json([
            "message"=>200,
            "pais"=>$pais,
            "ciudades"=>json_decode($pais-> ciudades),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pais = Pais::findOrFail($id);
        
        $pais->delete();
        return response()->json([
            "message"=>200
        ]);
    }

    public function search(Request $request){
        return Pais::search($request->buscar);
    }
}
