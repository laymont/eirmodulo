@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md">
      <p class="text-center">
        <img class="float-left" src="{{ asset('img/gonavi.png') }}" alt="Logo">
        IMPORTADORA Y TRANSPORTE GONAVI, C.A.
        <span class="float-right">{!!QrCode::size(70)->generate('Contenedor: '.$inventario->contenedor)!!}</span> <br>
        La Guaira <br>
        RIF: J294968970
      </p>
    </div>
  </div>

  <div class="row">
    <div class="col-md card">
      <p>Fecha/Hora: <br> {{ $inventario->frd }}</p>
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
      <div class="row">
        <div class="col-md">
          <p>Estatus: <br>
        @if ($inventario->status == 0)
          <span class="text-primary"><strong>VACIO</strong></span>
        @else
          <span class="text-warning"><strong>FULL</strong></span>
        @endif
        <br>
      </p>
        </div>
        <div class="col-md">
          <span>Condicion</span> <br>
          @if ($inventario->condicion == 0 || $inventario->condicion == 4 )
            <span class="text-danger"><strong>DMG</strong></span>
          @else
            <span class="text-success"><strong>OPR</strong></span>
          @endif
        </div>
      </div>
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
      <p>Consignatario: <br> {{ $inventario->consignatarios->nombre }}</p>
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
            <th>SU</th>
            <td>Sucio</td>
            <th>RA</th>
            <td>Rajado</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>C</th>
            <td>Cortado</td>
            <th>R</th>
            <td>Raspado</td>
            <th>OX</th>
            <td>Oxidado</td>
            <th>NL</th>
            <td>Necesita Limpieza</td>
          </tr>
          <tr>
            <th>F</th>
            <td>Falta</td>
            <th>DU</th>
            <td>Duro</td>
            <th>ET</th>
            <td>Etiqueta</td>
            <th>D</th>
            <td>Dañado</td>
          </tr>
          <tr>
            <th>S</th>
            <td>Sucio</td>
            <th>M</th>
            <td>Manchado</td>
            <th>H</th>
            <td>Hueco</td>
            <th></th>
            <td></td>
          </tr>
          <tr>
            <td colspan="8">
              <span><strong>Observaciones</strong></span><br>
              {{ $inventario->obs }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md">
      <img class="img-fluid" src="{{ asset('img/CONTENEDOR.jpg') }}" alt="Contenedor">
    </div>
  </div>

  <div class="row">
    <div class="col-md">
      <table class="table table-inverse table-bordered table-sm">
        <caption>Refrigerado / Open Top</caption>
        <thead>
          <tr>
            <th class="text-center" colspan="3" width="50%">Equipo Refrigerado</th>
            <th class="text-center" colspan="3" width="50%">Equipo Open Top</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Cable</td>
            <td>Temp/Actual</td>
            <td>Display/Teclado</td>
            <td>Lona</td>
            <td>Dañada</td>
            <td>Otros Componentes Dañados o Inexistentes</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6">Observaciones: </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md">
      <table class="table table-inverse table-bordered table-sm">
        <caption>Datos del Transporte</caption>
        <thead>
          <tr>
            <th>Datos del Transportista: </th>
            <th>Datos del Chequeador: </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nombre del Chofer:</td>
            <td>Nombre:</td>
          </tr>
          <tr>
            <td>C.I.:</td>
            <td>C.I.:</td>
          </tr>
          <tr>
            <td>Firma</td>
            <td colspan="2">Huella</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection