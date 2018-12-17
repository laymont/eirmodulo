/* Nueva funcion jQuery ISO 6346 */
(function($) {
	
	//Variables Globales
	var digitoresultado = null;

	$.DigitoValidador = function(numerostr){
		//Table de Caracteres + Valor
		var tablacaracteres = "A10*B12*C13*D14*E15*F16*G17*H18*I19*J20*K21*L23*M24*N25*O26*P27*Q28*R29*S30*T31*U32*V34*W35*X36*Y37*Z38";
		//Numero del contenedor (convertir en mayusculas)
		var numero = numerostr.val().toUpperCase();
		//Siglas Dueño
		var siglasowner = numero.substring(0,4);
		//Digito validador introducido
		var strvalnum = new Array();
		var base_elevada = new Array();
		var subtotal = 0;

		if(numero.length != 11){
			var digitoresultado = "El numero de contenedor esta compuesto por 4 caracteres y 6 numeros mas el digito validador";
			return digitoresultado;
		}else {
			if (/^([a-zA-Z]{3})(u|U)([0-9]{7})$/.test(numero)) {
			//Para la validacion del patron
			var caracterpermitido = numero.charAt(3);
		if(caracterpermitido != 'U'){
			alert('El 4to caracter debe ser U');
		}

		for(var a = 0; a <= 3; a++){
			var caracteres = numero.charAt(a);
			var caracterestab = tablacaracteres.indexOf(numero.charAt(a));
			strvalnum.push(tablacaracteres.substring(caracterestab+1,caracterestab+3));
		}



		for(var b = 4; b<=9; b++){
			strvalnum.push(numero.charAt(b));
		}

		for(var c = 0; c <= 9; c++){
			base_elevada.push(strvalnum[c] * Math.pow(2,c));
		}
		
		for(var i=0;i<base_elevada.length;i++){
			if(isNaN(base_elevada[i])){
				continue;
			}
			subtotal += Number(base_elevada[i]);
		}

		if(subtotal){
			var division = subtotal / 11;
			var redondeo = Math.floor(division);
			var diferencia = division - redondeo;
			digitoresultado = Math.round(diferencia * 11);
		}

		if(digitoresultado != numero.charAt(10)){
			
			//Notificar el nombre del nueño del contenedor
			$.getJSON('json/bic-locodes.json', {CODE: siglasowner}, function(json, textStatus) {
				/*optional stuff to do after success */
				if(textStatus == "success"){
					$.each(json.bic_locodes, function(i, v){
						if(v.CODE == siglasowner){
							console.info("Dueño: ", v.OWNER);
						}
					});
				}
			});
			
			var msj = "<strong>El digito correcto es:</strong> " + digitoresultado;
			console.warn("Digito Validador = ", digitoresultado);

			return msj;
		}else {
			
			return true;
		}
		}else {
			//Patron invalido
		}
	}
}
}(jQuery));