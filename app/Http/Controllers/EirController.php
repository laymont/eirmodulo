<?php

namespace App\Http\Controllers;

use App\Eir;
use App\Inventario;
use Illuminate\Http\Request;

class EirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $eirs = Eir::all();
      return view('eirs.index', compact('eirs'));
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

    public function out($id)
    {
      $contenedor = Inventario::with('tipos:id,tipo')->findOrFail($id);
      return view('eirs.out', compact('contenedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if(isset($request->transporte_n)){
        $transporte = \App\Transporte::firstOrCreate(['nombre' => $request->transporte_n]);
      }else {
        $transporte = \App\Transporte::find($request->transporte_id);
      }
      $inventario = Inventario::findOrFail($request->inventario_id);
      $eir = new Eir();
      $eir->fecha = \Illuminate\Support\Carbon::now();
      $eir->inventario_id = $request->inventario_id;
      $eir->movimiento = $request->movimiento;
      $eir->precintos = $request->precintos;
      $eir->imo = $request->imo;
      $eir->dmgs = $request->dmgs;
      $eir->temperatura = $request->temperatura;
      $eir->observaciones = $request->observaciones;
      $eir->transporte_id = $transporte->id;
      $eir->placa = $request->placa;
      $eir->chofer = $request->chofer;
      $eir->identificacion = $request->identificacion;
      $eir->created_by = 1; //$request->created_by;
      // dd($request->all(), $eir);
      $eir->save();

      $inventario->update([
        'fdespims' => \Illuminate\Support\Carbon::now(),
        'eir_d' => $eir->id,
        'status_d' => $request->estatus,
        'buqued' => $request->buque,
        'viajed' => $request->viaje,
        'precintodesp' => $request->precintos,
        'c' => 1,
        'mod' => \Illuminate\Support\Carbon::now()
      ]);
      return redirect()->route('eirs.show', ['id' => $inventario->id]);
      // dd($request->all(), $inventario, $eir);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Eir  $eir
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $inventario = Inventario::with('lineas:id,nombre','buques:id,nombre','viajes:id,viaje,eta','tipos:id,tipo','consignatarios:id,nombre')
      ->find($id);
      $eir = Eir::with('transporte:id,nombre')->where('inventario_id', $id)->get();
      return view('eirs.show', compact('inventario','eir'));
      // return view('eirs.show', compact('eir'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Eir  $eir
     * @return \Illuminate\Http\Response
     */
    public function edit(Eir $eir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Eir  $eir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Eir $eir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Eir  $eir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eir $eir)
    {
        //
    }
  }
