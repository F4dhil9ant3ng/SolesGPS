<?php
	class movimiento_plantilla extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu			=array();
		var $sys_enviroments	="DEVELOPER";
		var $sys_table			="movimiento";
		
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),
			"company_id"	    =>array(
			    "title"             => "Empresa",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",			    
			),			

			"empresa_id"	=>array(
			    "title"             => "Empresa",
			    "title_filter"      => "Empresa",	
			    "showTitle"         => "si",
			    "type"              => "autocomplete",
			    #"source"           	=> "../modulos/empresa/ajax/autocomplete.php",
			    "value"             => "",			    
			    "procedure"       	=> "autocomplete_empresa",
			    "relation"          => "one2many",			    
			    "class_name"       	=> "company",
			    "class_field_l"    	=> "nombre",				# Label
			    "class_field_o"    	=> "empresa_id",
			    "class_field_m"    	=> "id",			    
			),			
			
			"movimientos_ids"	    =>array(
			    "title"             => "Horario",
			    "showTitle"         => "si",
			    "type"              => "form",
			    "default"           => "",
			    "value"             => "",
			    "relation"          => "many2one",			    
			    "class_name"       	=> "movimientos",			    
				#"class_template"  	=> "many2one_lateral",			    
				#"class_report" 		=> "kanban",			    
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "movimiento_id",				
				#"class_field_l"    	=> "horario",	
			),
			"tipo"	    =>array(
			    "title"             => "Tipo",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",
			),			
			"compra"	    =>array(
			    "title"             => "Lista de compra",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",
			),			
			"venta"	    =>array(
			    "title"             => "Lista de venta",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",
			),			
			"movimiento_id"	    =>array(
			    "title"             => "Relacion",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",
			),			
			"registro"	    =>array(
			    "title"             => "Registrado",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),			
			"fecha"	    =>array(
			    "title"             => "Fecha",
			    "title_filter"      => "Fecha",
			    "showTitle"         => "si",
			    "type"              => "datetime",
			    "default"           => "",
			    "value"             => "",
			),				

			"caducidad"	    =>array(
			    "title"             => "Caducidad",
			    "title_filter"      => "Caducidad",
			    "showTitle"         => "si",
			    "type"              => "date",
			    "default"           => "",
			    "value"             => "",
			),
			"folio"	    =>array(
			    "title"             => "Folio",
			    "title_filter"      => "Folio",
			    "showTitle"         => "si",
			    "type"              => "hidden",
			    "default"           => "",
			    "value"             => "",
			),	
			/*		
			"plazos_id"	    =>array(
			    "title"             => "Plazos",
			    "title_filter"      => "Plazos",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),
			*/
				
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
        
		public function __CONSTRUCT()
		{	
			parent::__CONSTRUCT();		
			#$this->__PRINT_R($_SESSION["SAVE"]);
			
		}
		#/*
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		
    		## GUARDAR USUARIO
    		#$datas["total"]		=count(explode(",",$datas["dias"]));
			$datas["registro"]			=$this->sys_date;
			$datas["company_id"]		=$_SESSION["company"]["id"];
			$datas["tipo"]				="plantilla";
			
    	    $return= parent::__SAVE($datas,$option);
    	    return $return;
		}
		#*/		
   		public function __GENERAR_PDF()
    	{
			$_SESSION["pdf"]	=array();	
			
			$_SESSION["pdf"]["title"]				="INSTITUTO MEXICANO DEL SEGURO SOCIAL";
			$_SESSION["pdf"]["subject"]				="";
			$_SESSION["pdf"]["save_name"]			="";
			$_SESSION["pdf"]["PDF_MARGIN_TOP"]		=10;
			
			$_SESSION["pdf"]["template"]			=$this->__FORMATO($this->sys_primary_id);
		}		

   		public function __REPORTE($option="")
    	{			    	
			if($option=="")	$option=array();
			
			if(!isset($option["where"]))	$option["where"]=array();
			
			$option["where"][]				="tipo='plantilla'";
			
			
			#$option["select"][]							="*";
			#$option["select"]["concat(tipo,folio)"]		="folio";
			
			#$option["from"]								="movimiento m";
			
			$option["template_title"]	                = $this->sys_module . "html/report_title";
			#$option["template_title"]	                = "";
			$option["template_body"]	                = $this->sys_module . "html/report_body";
	
			
			if(!isset($option["actions"]))	
			{	
				$option["actions"]							= array();
				#$option["actions"]["write"]					="$"."row[\"estatus\"]==''  OR $"."this->__NIVEL_SESION(\"<=20\")==true";
				$option["actions"]["show"]					="$"."row[\"estatus\"]!='CANCELADO'";			
				$option["actions"]["check"]					="false";
				$option["actions"]["delete"]				="false";
			}	
			
			if(!isset($this->request["sys_order_movimiento"]))
				$option["order"]="id desc";
			
			return $this->__VIEW_REPORT($option);
		}						
	}
?>

