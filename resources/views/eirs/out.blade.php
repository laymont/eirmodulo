@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app" v-cloak>
  <div class="row">
    <div class="col-md">
      <h4>EIR's Salida/Out</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 ml-2">
      {{-- {{ dd($contenedor->consignatario) }} --}}
      {!! Form::model($contenedor, ['route' => 'eirs.store', 'method' => 'POST']) !!}

      <div class="row">
        <div class="form-group">
          {!! Form::label('fecha', 'Fecha', ['class' => 'form-control-label']) !!}
          {!! Form::date('fecha', \Illuminate\Support\Carbon::now(), ['class' => 'form-control-plaintext','readonly']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('movimiento', 'Movimiento', ['class' => 'form-control-label']) !!}
          {!! Form::select('movimiento', ['Ingreso' => 'Ingreso', 'Relocalizacion' => 'Relocalización','Salida' => 'Salida'], 'Salida', ['class' => 'form-control', 'placeholder' => 'Selección','readonly']) !!}
        </div>
      </div>

      <div class="row">
        <div class="form-group mr-2">
          <label class="control-control-label" for="linea">Linea:</label>
          {!! Form::select('linea', \App\Linea::where('activo',0)->pluck('nombre','id'), null, ['class' => 'form-control','placeholder' => 'Linea', 'v-model' => 'linea','readonly']) !!}
        </div>
        <div class="form-group mr-2">
          <label class="control-control-label" for="buque">Buque:</label>
          <select class="form-control" name="buque" id="buque" required v-model="buque">
            <option value="" disabled selected>Selección</option>
            <option v-for="item in buqueLists" :value="item.value">@{{ item.label }}</option>
          </select>
        </div>
        <div class="form-group mr-2">
          {!! Form::label('viaje', 'Viaje', ['class' => 'form-control-label']) !!}
          <select name="viaje" class="form-control" required v-model="viaje">
            <option value="" disabled selected>Selección</option>
            <option v-for="item in viajesLists" :value="item.value" >@{{ item.label }}</option>
          </select>
        </div>
        <div class="form-group mr-2">
          {!! Form::label('eta', 'ETA', ['class' => 'form-control-label']) !!}
          {!! Form::date('eta', null , ['class' =>'form-control-plaintext','readonly','v-model'=>'eta']) !!}
        </div>
      </div>

      <div class="row">
        <div class="form-group mr-2">
          {!! Form::label('contenedor', 'Contenedor', ['class' => 'form-control-label']) !!}
          {!! Form::text('contenedor', null, ['class' => 'form-control', 'v-model' => 'contenedor','readonly']) !!}
          {!! Form::hidden('inventario_id', $contenedor->id, []) !!}
        </div>
        <div class="form-group mr-2">
          {!! Form::label('tcont', 'Tipo', ['class' => 'form-control-label']) !!}
          <select name="tcont" class="form-control" v-model="tipo" @change="getIsoCode()" readonly>
            <option value="" disabled selected>Selección</option>
            <option v-for="item in tipoLists" :value="item.value">@{{ item.label }}</option>
          </select>
        </div>
        <div class="form-group mr-2">
          {!! Form::label('isocode', 'ISO Code', ['class' => 'form-control-label']) !!}
          <select name="isocode" class="form-control"v-model="isocode">
            <option value="" disabled selected>Selección</option>
            <option v-for="item in isocodeLists" :value="item.value">@{{ item.label }}</option>
          </select>
        </div>
        <div class="form-group mr-2">
          {!! Form::label('imo', 'IMO', ['class' => 'form-control-label']) !!}
          {!! Form::select('imo', [0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9 ], null, ['class'=>'form-control', 'placeholder' => 'Selección', 'v-model' => 'imo']) !!}
        </div>
      </div>
      <div class="form-group col-md-8">
        {!! Form::label('consigntario', 'Consignatario', ['class' => 'form-control-label']) !!}
        {!! Form::select('consigntario_id', \App\Consignatario::pluck('nombre','id'), null, ['class'=>'form-control','placeholder'=>'Selección', 'v-model' => 'consignatario','readonly']) !!}
      </div>
      <div class="row">
        <div class="form-group mr-2">
          {!! Form::label('estatus', 'Estatus', ['class' => 'form-control-label']) !!}
          {!! Form::select('estatus', [0 => 'Vacio/Empty', 1 => 'Lleno/Full'], null, ['class' => 'form-control', 'v-model' => 'estatus','readonly']) !!}
        </div>
        <div class="form-group mr-2">
          {!! Form::label('condicion', 'Condicion', ['class' => 'form-control-label']) !!}
          {!! Form::select('condicion', [0 => 'DMG', 1 => 'OPR1', 2 => 'OPR2', 3 => 'OPR3'], null, ['class' => 'form-control', 'v-model' => 'condicion','readonly']) !!}
        </div>
        <div class="form-group mr-2">
          {!! Form::label('bl', 'B/L', ['class' => 'form-control-label']) !!}
          {!! Form::text('bl', null, ['class' => 'form-control', 'v-model' => 'bl','readonly']) !!}
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-5 mr-2">
          {!! Form::label('precintos', 'Precintos', ['class' => 'form-control-label']) !!}
          {!! Form::text('precintos', null, ['class' => 'form-control', 'v-model' => 'precintos']) !!}
        </div>
        <div class="form-group col-md-5 mr-2" v-if="tipo == 5 || tipo == 11">
          {!! Form::label('temperatura', 'Temperatura', ['class' => 'form-control-label']) !!}
          {!! Form::text('temperatura', null, ['class' => 'form-control','placeholder' => 'Refeer Temp']) !!}
        </div>
      </div>
      <div class="form-group col-md-8">
        {!! Form::label('dmgs', 'Daños/DMGs', ['class' => 'form-control-label']) !!}
        {!! Form::text('dmgs', null, ['class' => 'form-control']) !!}
        <small id="emailHelp" class="form-text text-muted">Daños del Equipo.</small>
        {!! $errors->first('dmgs', '<small class="help-block text-danger">:message</small>') !!}
      </div>
      <div class="form-group col-md-8">
        {!! Form::label('observaciones', 'Observaciones', ['class' => 'form-control-label']) !!}
        {!! Form::textarea('observeciones', null, ['class' => 'form-control','rows' => 5, 'v-model' => 'observaciones']) !!}
      </div>

      <div class="row">
        <div class="form-group mr-2">
          {!! Form::label('transporte_id', 'Transporte', ['class'=>'form-control-label']) !!}
          {!! Form::select('transporte_id', \App\Transporte::pluck('nombre','id'), null, ['class' => 'form-control', 'placeholder' => 'Selección', 'v-model' => 'transporte']) !!}
        </div>
        <div class="form-group mr-2" v-if="transporte < 1">
          {!! Form::label('transporte_n', 'Nuevo Transporte', ['class' => 'form-control-label']) !!}
          {!! Form::text('transporte_n', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-2">
          {!! Form::label('placa', 'Placa', ['class'=>'form-control-label']) !!}
          {!! Form::text('placa', null, ['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="row">
        <div class="form-group mr-2">
          {!! Form::label('chofer', 'Chofer', ['class'=>'form-control-label']) !!}
          {!! Form::text('chofer', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mr-2">
          {!! Form::label('identificacion', 'Identificación', ['class'=>'form-control-label']) !!}
          {!! Form::text('identificacion', null, ['class' => 'form-control']) !!}
        </div>
      </div>

      <div class="form-group">
        <button class="btn btn-success" type="submit" name="submit" id="submit" value="Enviar">Guardar </button>
      </div>

      {!! Form::close() !!}

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  var app = new Vue({
    el: '#app',

    created(){
      axios.get('/getTipos').then(response => { this.tipoLists = response.data }).catch(function(error){ console.log(error) });
      axios.get('/getBuques/' + this.linea).then(response => { this.buqueLists = response.data }).catch(function(error){ console.log(error) });
      this.getIsoCode();
    },

    data: {
      linea: {{ $contenedor->linea }},
      buqueLists: '',
      buque: '',
      viajesLists: '',
      viaje: '',
      eta: '',
      fecha: '',
      contenedor: '{{ $contenedor->contenedor }}',
      bl: '{{ $contenedor->bl }}',
      consignatario: {{ $contenedor->consignatario }},
      precintos: '{{ $contenedor->precinto }}',
      tipoLists: '',
      tipo: {{ $contenedor->tcont }},
      tipochar: '',
      isocodeLists: '',
      isocode: '',
      imo: 0,
      estatus: {{ $contenedor->status }},
      condicion: {{ $contenedor->condicion }},
      observaciones: '{{ $contenedor->obs }}',
      transporte: ''
    },

    computed: {},

    watch: {
      linea: function(){
        if(this.linea > 0){
          axios.get('/getBuques/' + this.linea)
          .then(response => {
            this.buqueLists = response.data;
          })
          .catch(function(error){
            console.log(error)
          })
        }
      },
      buque: function(){
        if(this.buque > 0){
          axios.get('/getViajes/' + this.buque)
          .then(response => {
            this.viajesLists = response.data;
          })
          .catch(function(error){
            console.log(error)
          })
        }
      },
      viaje: function(){
        if(this.viaje > 0){
          this.viajesLists.filter(item => {
            if(item.value == this.viaje){
              this.eta = item.eta;
            }
          })
        }
      }
    },

    methods: {
      getIsoCode: function(){
        axios.get('/getIsoCodes/' + this.tipo)
        .then(response => {
          this.isocodeLists = response.data;
        })
        .catch(function(error){
          console.log(error)
        })
      }
    }
  })
</script>
@endsection