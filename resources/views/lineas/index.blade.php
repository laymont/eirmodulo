@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <h4>Lineas</h4>
      <table class="table table-bordered table-inverse">
        <thead>
          <tr>
            <th>id</th>
            <th>RIF</th>
            <th>Nombre</th>
            <th>Agencia</th>
            <th>D/Libres</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lineas as $element)
          <tr>
            <td>{{ $element->id }}</td>
            <td>{{ $element->rif }}</td>
            <td>{{ $element->nombre }}</td>
            <td>{{ $element->agencia }}</td>
            <td>{{ $element->dlibres }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection