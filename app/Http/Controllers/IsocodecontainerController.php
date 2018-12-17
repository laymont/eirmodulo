<?php

namespace App\Http\Controllers;

use App\Isocodecontainer;
use Illuminate\Http\Request;

class IsocodecontainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getIsoCodes($tipo)
    {
      $type = \App\Tequipo::findOrFail($tipo);
      $isocodes = Isocodecontainer::where('tamano', substr($type->tipo,0,2))->get()->sortBy('codiso');
      $resultados = collect();
      foreach ($isocodes as $key => $value) {
        $resultados->push([
          'label' => $value->codiso,
          'value' => $value->id
        ]);
      }
      return $resultados;
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
     * @param  \App\Isocodecontainer  $isocodecontainer
     * @return \Illuminate\Http\Response
     */
    public function show(Isocodecontainer $isocodecontainer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Isocodecontainer  $isocodecontainer
     * @return \Illuminate\Http\Response
     */
    public function edit(Isocodecontainer $isocodecontainer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Isocodecontainer  $isocodecontainer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Isocodecontainer $isocodecontainer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Isocodecontainer  $isocodecontainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Isocodecontainer $isocodecontainer)
    {
        //
    }
  }
