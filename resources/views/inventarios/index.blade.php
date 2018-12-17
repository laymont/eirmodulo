@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md">
      <table class="table table-inverse">
        <thead>
          <tr>
            <th>EIR <small>IN</small></th>
            <th>FRD</th>
            <th>Linea</th>
            <th>Buque</th>
            <th>Viaje</th>
            <th>Tipo</th>
            <th>Equipo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($inventario as $element)
          <tr>
            <td>{{ $element->eir_r }}</td>
            <td>{{ $element->frd }}</td>
            <td>{{ $element->lineas->nombre }}</td>
            <td>{{ $element->buques->nombre }}</td>
            <td>{{ $element->viajes->viaje }}</td>
            <td>{{ $element->tipos->tipo }}</td>
            <td>{{ $element->contenedor }}</td>
            <td>
              <a class="btn btn-sm btn-primary" href="{{ route('eirs.out',['id' => $element->id]) }}" title="EIR Salida">EIR <small>OUT</small></a>
              <a class="btn btn-sm btn-warning" href="#" title="Traslado">Relocalización</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection