function ISO6346(field){
	var $Tabla = "A10*B12*C13*D14*E15*F16*G17*H18*I19*J20*K21*L23*M24*N25*O26*P27*Q28*R29*S30*T31*U32*V34*W35*X36*Y37*Z38";
	var $Container = campo.val().toUpperCase(); //Convertir a mayuscula el numero de contenedor
	var $Digitoinput = campo.val().substr(10,11); // Digito 11
	var $Patron = /^([a-zA-Z]{3})(u|U)([0-9]{7})$/; //Patron para evaluar el numero de contenedor

	if(!$Patron.test(opcion)){
		alert('No valida patron');
	}else {
		return true;
	}

	$SerialEQ = new Array(10);
	$StrValNum = new Array();

	for(var a = 0; a <= 3; a++){
		var $Caracteres = $Container.charAt(a);
		var $CaracterTab = $Tabla.indexOf($Caracteres);
		var $StrValNum = $Tabla.substring($CaracterTab+1,$CaracterTab+3);
	}

	for(var b = 4; b < 10; b++){
		$StrValNum = $Container.charAt(b);
	}

	var $SubTotal = 0;
	for(var c = 0; c < 10; c++){
		var $BaseElevada = $StrValNum[c] * Math.pow(2,c);
		$SubTotal = $SubTotal + $BaseElevada;
	}

	if($SubTotal){
		var $Division = $SubTotal / 11;
		var $Redondeo = Math.floor($Division);
		var $Diferencia = $Division - $Redondeo;
		var $DigitoVal = Math.round($Diferencia * 11);
		if($DigitoVal == 10){
			$DigitoVal = 0;
		}
	}
	//Comparar Digito Input y Resultado
	if($DigitoVal == $Digitoinput){
		return true;
	}else {
		return $DigitoVal;
	}
}