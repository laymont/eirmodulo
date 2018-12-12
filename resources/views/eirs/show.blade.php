@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md">
      <p class="text-center">
        IMPORTADORA Y TRANSPORTE GONAVI, C.A.
        <span class="float-right">{!!QrCode::size(70)->generate('Contenedor: '.$inventario->contenedor)!!}</span> <br>
        La Guaira <br>
        RIF: J294968970
      </p>
    </div>
  </div>

  <div class="row">
    <div class="col-md card">
      <p>Fecha/Hora: <br> {{ $inventario->fdb }}</p>
    </div>
    <div class="col-md card">
      <p>Equipo: <br> {{ $inventario->contenedor }}</p>
    </div>
    <div class="col-md card">
      <p>Tipo: <br> {{ $inventario->tipos->tipo }}</p>
    </div>
    <div class="col-md card">
      <p>Transaccion: <br></p>
    </div>
    <div class="col-md card">
      <p>Movimiento: <br></p>
    </div>
    <div class="col-md card">
      <p>Estatus: <br></p>
    </div>
  </div>

  <div class="row">
    <div class="col-md card">
      <p>B/L N°</p>
    </div>
    <div class="col-md card">
      <p>Booking N°</p>
    </div>
    <div class="col-md card">
      <p>Peso Bruto</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md card">
      <p>Precinto</p>
    </div>
    <div class="col-md card">
      <p>Precinto</p>
    </div>
    <div class="col-md card">
      <p>Precinto</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md card">
      <p>Precinto</p>
    </div>
    <div class="col-md card">
      <p>Imo</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md card">
      <p>Linea: {{ $inventario->lineas->nombre }}</p>
    </div>
    <div class="col-md card">
      <p>Buque: {{ $inventario->buques->nombre }}</p>
    </div>
    <div class="col-md card">
      <p>Viaje: {{ $inventario->viajes->viaje }}</p>
    </div>
    <div class="col-md card">
      <p>Arribo: {{ $inventario->viajes->eta }}</p>
    </div>
  </div>

  <div class="row mb-2">
    <div class="col-md card">
      <p>Consignatario: <br></p>
    </div>
    <div class="col-md card">
      <p>Telefono: <br></p>
    </div>
  </div>

  <div class="row">
    <div class="col-md">
      <table class="table table-inverse table-bordered table-sm">
        <caption>DAMAGE CODE</caption>
        <thead>
          <tr>
            <th>D</th>
            <td>Doblado</td>
            <th>DL</th>
            <td>Destilando Liquido</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>C</th>
            <td>Cortado</td>
            <th>header</th>
            <td>data</td>
          </tr>
          <tr>
            <th>F</th>
            <td>Falta</td>
            <th>header</th>
            <td>Sucio</td>
          </tr>
          <tr>
            <th>S</th>
            <td>Sucio</td>
            <th>header</th>
            <td>Sucio</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection