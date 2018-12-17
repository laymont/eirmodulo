<?php

namespace App\Http\Controllers;

use App\Buque;
use Illuminate\Http\Request;

class BuqueController extends Controller
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

    public function getBuques($linea)
    {
        $buques = Buque::with('lineas:id,nombre')
        ->where('activo',0)
        ->where('linea',$linea)
        ->get();
        // dd($buques);
        $resultados = collect();
        foreach ($buques as $key => $value) {
            $resultados->push([
                'extra' => $value->lineas->nombre,
                'label' => $value->nombre,
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
     * @param  \App\Buque  $buque
     * @return \Illuminate\Http\Response
     */
    public function show(Buque $buque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Buque  $buque
     * @return \Illuminate\Http\Response
     */
    public function edit(Buque $buque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buque  $buque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buque $buque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buque  $buque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buque $buque)
    {
        //
    }
}
