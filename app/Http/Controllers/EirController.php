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
     * @param  \App\Eir  $eir
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $inventario = Inventario::with('lineas:id,nombre','buques:id,nombre','viajes:id,viaje,eta','tipos:id,tipo')
      ->find($id);
      return view('eirs.show', compact('inventario'));
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
