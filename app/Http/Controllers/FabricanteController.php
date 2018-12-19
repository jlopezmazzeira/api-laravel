<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fabricante;

class FabricanteController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth.basic', ['only' => ['store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elements = 2;
        $fabricantes = Fabricante::simplePaginate($elements);
        $data = [
          'next' => $fabricantes->nextPageUrl(),
          'previous' => $fabricantes->previousPageUrl(),
          'data' => $fabricantes->items()
        ];

        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->input('nombre') || !$request->input('telefono')) {
          return response()->json(['message' => 'Error when processing the data', 'code' => 422],422);
        }
        Fabricante::create($request->all());
        return response()->json(['message' => 'Fabricante created'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fabricante = Fabricante::find($id);

        if(!$fabricante){
          return response()->json(['message' => 'Not found fabricante', 'code' => 404],404);
        }

        return response()->json(['data' => $fabricante],200);

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
        $method = $request->method();
        $modified = false;

        $fabricante = Fabricante::find($id);

        if(!$fabricante){
          return response()->json(['message' => 'Not found fabricante', 'code' => 404],404);
        }
        $name = $request->input('nombre');
        $phone = $request->input('telefono');

        if ($method === 'PATCH') {

          if ($name != null && $name != '') {
            $fabricante->nombre = $name;
            $modified = true;
          }

          if ($phone != null && $phone != '') {
            $fabricante->nombre = $phone;
            $modified = true;
          }

          if ($modified) {
            $fabricante->save();
            return response()->json(['message' => 'Updated fabricante'],200);
          }

          return response()->json(['message' => 'Unmodified resource'],200);
        }

        if (!$name || !$phone) {
          return response()->json(['message' => 'Error updated fabricante', 'code' => 422],422);
        }

        $fabricante->nombre = $name;
        $fabricante->nombre = $phone;
        $fabricante->save();

        return response()->json(['message' => 'Updated fabricante'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $fabricante = Fabricante::find($id);

      if(!$fabricante){
        return response()->json(['message' => 'Not found fabricante', 'code' => 404],404);
      }

      $vehiculos = $fabricante->vehiculos;

      if (sizeof($vehiculos) > 0) {
        return response()->json(['message' => 'This manufacturer owns associated vehicles, you must eliminate the vehicles first.', 'code' => 409],409);
      }

      $fabricante->delete();
      return response()->json(['message' => 'Deleted Fabricante'],200);
    }
}
