@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md">
      <table class="table table-inverse">
        <thead>
          <tr>
            <th>EIR</th>
            <th>FRD</th>
            <th>Linea</th>
            <th>Buque</th>
            <th>Viaje</th>
            <th>Tipo</th>
            <th>Equipo</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($inventario as $element)
          <tr>
            <td><a class="btn btn-sm btn-light" href="{{ url('eirs/'.$element->id) }}" title="">{{ $element->eir_r }}</a></td>
            <td>{{ $element->frd }}</td>
            <td>{{ $element->lineas->nombre }}</td>
            <td>{{ $element->buques->nombre }}</td>
            <td>{{ $element->viajes->viaje }}</td>
            <td>{{ $element->tipos->tipo }}</td>
            <td>{{ $element->contenedor }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection