// JavaScript Document
//Funcion diferencia de dias

$(function() {
	//<!--InHabilitar ENTER en FORM--> 
  $('form').keypress(function(e){   
    if(e == 13){
      return false;
    }
  });

  $('input').keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });
  //<!--InHabilitar ENTER en FORM--> 
});
<!--Validar Digito de Chequeo-->

function ISO6346Check(cntrNum) {
	var num = 0;
	var charCode = "0123456789A?BCDEFGHIJK?LMNOPQRSTU?VWXYZ";
	if (!cntrNum || cntrNum.length != 11) {
		return false;
	}
	cntrNum = cntrNum.toUpperCase();
	for (var i = 0; i < 10; i++) {
		var chr = cntrNum.substring(i, i + 1);
		var idx = chr == '?' ? -1 : charCode.indexOf(chr);
		if (idx < 0) {
			return false;
		}
		idx = idx * Math.pow(2, i);
		num += idx;
	}
	num = (num % 11) % 10;
	$resultado = parseInt(cntrNum.substring(10, 11)) == num;
	$digitoValidador = num;
	return [$resultado, $digitoValidador];
}

function compararFechas(fecha1,fecha2){
    /*La fecha inicial no puede ser mayor que la fecha final*/
    if ( fecha1 > fecha2){
			console.warn(fecha1 + ' > ' + fecha2);
      return false;
    }else {
			console.info(fecha1 + ' > ' + fecha2);
			return true;
		}
  }
