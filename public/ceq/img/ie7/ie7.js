/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoonCC\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-inicio': '&#xe900;',
		'icon-editar': '&#xe906;',
		'icon-imagen': '&#xe90d;',
		'icon-carpeta': '&#xe92f;',
		'icon-abrircarpeta': '&#xe930;',
		'icon-mascarpeta': '&#xe931;',
		'icon-menoscarpeta': '&#xe932;',
		'icon-descargar': '&#xe933;',
		'icon-descargarbox': '&#xe95e;',
		'icon-subirbox': '&#xe95f;',
		'icon-deshacer': '&#xe967;',
		'icon-rehacer': '&#xe968;',
		'icon-usuario': '&#xe971;',
		'icon-usuarioadd': '&#xe973;',
		'icon-usuariorem': '&#xe974;',
		'icon-usariotrue': '&#xe975;',
		'icon-llave': '&#xe98d;',
		'icon-seguro': '&#xe98f;',
		'icon-graficos': '&#xe99c;',
		'icon-switch': '&#xe9b6;',
		'icon-descarganuve': '&#xe9c2;',
		'icon-subenube': '&#xe9c3;',
		'icon-ojo': '&#xe9ce;',
		'icon-feliz': '&#xe9df;',
		'icon-asombro': '&#xe9f1;',
		'icon-llora': '&#xea01;',
		'icon-alerta': '&#xea07;',
		'icon-cancelar': '&#xea0d;',
		'icon-false': '&#xea0f;',
		'icon-true': '&#xea10;',
		'icon-entrar': '&#xea13;',
		'icon-salir': '&#xea14;',
		'icon-chrome': '&#xeae5;',
		'icon-firefox': '&#xeae6;',
		'icon-IE': '&#xeae7;',
		'icon-opera': '&#xeae8;',
		'icon-safari': '&#xeae9;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
