<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fabricante;
use App\Vehiculo;

class FabricanteVehiculoController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth.basic', ['only' => ['store', 'update', 'destroy']]);
    }

    public function showAll()
    {
      return 'mostrando todos los vehiculos';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      $fabricante = Fabricante::find($id);

      if(!$fabricante){
        return response()->json(['message' => 'Not found fabricante', 'code' => 404],404);
      }

      return response()->json(['data' => $fabricante->vehiculos],200);
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
    public function store(Request $request, $id)
    {

        if (!$request->input('color') || !$request->input('cilindraje')
            || !$request->input('potencia') || !$request->input('peso')) {
          return response()->json(['message' => 'Error when processing the data', 'code' => 422],422);
        }

        $fabricante = Fabricante::find($id);

        if (!$fabricante) {
          return response()->json(['message' => 'Not found fabricante', 'code' => 404],404);
        }

        $fabricante->vehiculos()->create($request->all());
        return response()->json(['message' => 'Vehiculo created'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idFrabicante, $idVehiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idFrabicante, $idVehiculo)
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
    public function update(Request $request, $idFrabicante, $idVehiculo)
    {
      $method = $request->method();
      $modified = false;
      $fabricante = Fabricante::find($idFrabicante);

      if(!$fabricante){
        return response()->json(['message' => 'Not found fabricante', 'code' => 404],404);
      }

      $vehiculo = $fabricante->vehiculos()->find($idVehiculo);

      if(!$vehiculo){
        return response()->json(['message' => 'Not found Vehiculo', 'code' => 404],404);
      }

      $color = $request->input('color');
      $cilindraje = $request->input('cilindraje');
      $potencia = $request->input('potencia');
      $peso = $request->input('peso');

      if ($method === 'PATCH') {

        if ($color != null && $color != '') {
          $vehiculo->color = $color;
          $modified = true;
        }

        if ($cilindraje != null && $cilindraje != '') {
          $vehiculo->cilindraje = $cilindraje;
          $modified = true;
        }

        if ($potencia != null && $potencia != '') {
          $vehiculo->potencia = $potencia;
          $modified = true;
        }

        if ($peso != null && $peso != '') {
          $vehiculo->peso = $peso;
          $modified = true;
        }

        if ($modified) {
          $vehiculo->save();
          return response()->json(['message' => 'Updated Vehiculo'],200);
        }

        return response()->json(['message' => 'Unmodified resource'],200);
      }

      if (!$color || !$cilindraje || !$potencia || !$peso) {
        return response()->json(['message' => 'Error updated Vehiculo', 'code' => 422],422);
      }

      $vehiculo->color = $color;
      $vehiculo->cilindraje = $cilindraje;
      $vehiculo->potencia = $potencia;
      $vehiculo->peso = $peso;
      $vehiculo->save();
      return response()->json(['message' => 'Updated Vehiculo'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idFrabicante, $idVehiculo)
    {
      $fabricante = Fabricante::find($idFrabicante);

      if(!$fabricante){
        return response()->json(['message' => 'Not found fabricante', 'code' => 404],404);
      }

      $vehiculo = $fabricante->vehiculos()->find($idVehiculo);

      if(!$vehiculo){
        return response()->json(['message' => 'Not found Vehiculo', 'code' => 404],404);
      }

      $vehiculo->delete();
      return response()->json(['message' => 'Deleted Vehiculo'],200);
    }
}
