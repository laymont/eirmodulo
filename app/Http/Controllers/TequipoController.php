<?php

namespace App\Http\Controllers;

use App\Tequipo;
use Illuminate\Http\Request;

class TequipoController extends Controller
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

    public function getTipos()
    {
      $tipos = Tequipo::all();
      $resultados = collect();
      foreach ($tipos as $key => $value) {
        if (preg_match('/^20/', $value->tipo)) {
          $resultados->push([
            'label' => $value->tipo,
            'value' => $value->id,
            'size' => 20
          ]);
        }else if(preg_match('/^40/', $value->tipo)){
          $resultados->push([
            'label' => $value->tipo,
            'value' => $value->id,
            'size' => 40
          ]);
        }
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
     * @param  \App\Tequipo  $tequipo
     * @return \Illuminate\Http\Response
     */
    public function show(Tequipo $tequipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tequipo  $tequipo
     * @return \Illuminate\Http\Response
     */
    public function edit(Tequipo $tequipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tequipo  $tequipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tequipo $tequipo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tequipo  $tequipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tequipo $tequipo)
    {
        //
    }
  }
