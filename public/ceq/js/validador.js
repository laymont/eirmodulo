// JavaScript Document
//Codigo Validador
//Validacion contenedor, Logitud, 4to caracter y digito de chequeo
//Nueva Funcion
function DigitoChequeo(obj){
	var tabla = "A10*B12*C13*D14*E15*F16*G17*H18*I19*J20*K21*L23*M24*N25*O26*P27*Q28*R29*S30*T31*U32*V34*W35*X36*Y37*Z38";
	var numero = document.getElementById(obj).value; //Nroequipo
	var equipo = numero.toUpperCase(); //NroequipoM 
	var digitostr = equipo.substring(10,11); //charter11
	
	if(numero.length != 11){
		tamano = false;
		$("#modal-id").modal();
		document.getElementById(obj).focus();
	}else if(numero.length == 11){
		tamano = true;
	}
	//SerialEQ verfak
	serialeq = new Array (10);
	for (var a = 0; a <= 3; a++){
		var letras = equipo.charAt(a);
		var letra = tabla.indexOf(letras);
		serialeq[a] = tabla.substring(letra+1, letra+3);
	}
	for (var b = 4; b < 10; b++){
		serialeq [b] = equipo.charAt(b);
	}
	var total = 0;
	for (var c = 0; c < 10; c++){
		var vermeniging = serialeq[c] * Math.pow(2,c);
		total = total + vermeniging;
	}
	if(total){
		var entero = total / 11;
		var redondeo = Math.floor(entero);
		var diferencia = entero - redondeo;
		var digitocheck = Math.round(diferencia * 11);
		if(digitostr == digitocheck){
			<!--has-success has-error-->
			$('#inputEquipo').removeClass('has-warning');
			$('#inputEquipo').addClass('has-success');
			/*document.getElementById(obj).style.backgroundColor = "#D5FFE2";
			document.getElementById(obj).style.fontWeight = "bold";*/
			return true;
		}else {
			$('#inputEquipo').removeClass('has-success');
			$('#inputEquipo').addClass('has-warning');
			if(tamano == true){
				<!--$('#msjerr').addClass('hidden');-->
				$('#modalBody').append('<span>Digito validador= ' + digitocheck +'</span>');
				$("#modal-id").modal();
			}
			/*document.getElementById(obj).style.backgroundColor = "#FFF726";
			document.getElementById(obj).style.fontWeight = "bold";*/
			return false;
		}
	}
}
