<?php
	$objeto										=new map_online();
	
	$objeto->__SESSION();
	
	$objeto->words["system_body"]               =$objeto->__TEMPLATE($objeto->sys_html."system_body"); 			# TEMPLATES ELEJIDOS PARA EL MODULO
	$files_js									=array("maps","responsivevoice");

	$files_js[]									="../{$objeto->sys_var["module_path"]}js/map";        
	
	$objeto->words["system_module"]             =$objeto->__TEMPLATE($objeto->sys_html."system_module_not");
	$objeto->words["module_body"]               =$objeto->__VIEW_CREATE($objeto->sys_var["module_path"] . "html/map");	
	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);      

	$objeto->words["html_head_js"]              =$objeto->__FILE_JS($files_js);								# ARCHIVOS JS DEL MODULO
	$objeto->words["html_head_css"]             =$objeto->__FILE_CSS(array("../sitio_web/css/basicItems"));
	
    $objeto->words["system_submenu2"]           =$objeto->menu_vehicle();    	

	$objeto->words["module_title"]              ="MAP ONLINE";
	
    $objeto->words["html_head_description"] =   "EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE POSICIONES RECIBIDAS DURANTE EL RASTREO SATELITAL.";
    $objeto->words["html_head_keywords"]    =   "GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";
    $objeto->words["html_head_title"]           ="SOLES GPS :: {$_SESSION["company"]["nombre"]} :: {$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);
?>
