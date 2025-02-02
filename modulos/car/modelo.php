<?php	
	class car extends devices
	{   
		##############################################################################	
		##  Metodos	
		##############################################################################&sys_action=__SAVE
		public function __CONSTRUCT($option=NULL)
		{
			$this->sys_table="devices";
			
			$this->sys_fields["name"]["title"]				="Modelo";					
			$this->sys_fields["placas"]["description"]		="Placas actuales del vehiculo";			
			$this->sys_fields["telefono"]["description"]	="Numero telefonico del celular";			
			$this->sys_fields["image"]["description"]		="Imagen que se presentara en el mapa";			
			$this->sys_fields["image"]["source"]=array(
			    	"01"	=>	"Tracto Azul Caja Blanca",
			    	"06"	=>	"Tracto Blanco Caja Blanca",
			    	"02"	=>	"Carro Rojo",
			    	"03"	=>	"Camioneta Gris",			    	
			    	"06"	=>	"Camioneta Blanca",
			    	"07"	=>	"Camioneta Azul",
			    	"30"	=>	"Moto",
		    );		
		    
			$this->sys_fields["telcel"]["type"]		="hidden";					    
			$this->sys_fields["vehicle"]["type"]	="hidden";
		
			$return=parent::__CONSTRUCT($option);			
			
			return $return;			
		}				

   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		
    		$datas["vehicle"]			="1";
    	    $datas["company_id"]		=$_SESSION["company"]["id"];

    	    $files_id					=$this->files_obj->__SAVE();    	    
    	    if(!is_null($files_id))		$datas["file_id"]			=$files_id;    	    

	  		$return=parent::__SAVE($datas,$option);
	  		
	  		
	  		
	  		return $return;
		}				
		public function cars($option=NULL)
    	{
    		if(is_null($option))			$option=array();
			if(!isset($option["where"]))    $option["where"]    =array();
			if(!isset($option["select"]))   $option["select"]   =array();
			
			$option["where"][]      ="vehicle=1";
			
			return $this->devices($option);    	
		}						
		public function tab_files()		
    	{
			$this->words["files_title"]				="";
			$this->words["files_description"]		="";
			
			if(isset($this->sys_fields["file_id"]) AND isset($this->sys_fields["file_id"]["value"]) AND $this->sys_fields["file_id"]["value"]!="")
			{
				$this->words["files_title"]				="<li  class=\"form\"><a href=\"#tabs-10\">Imagenes</a></li>";    		
				$aux									="modulos/files/file/{$this->sys_fields["file_id"]["value"]}";
			
				if(file_exists("../$aux".".jpg"))						$path		="../$aux".".jpg";
				else if(file_exists("../$aux".".jpeg"))					$path		="../$aux".".jpeg";
				else if(file_exists("$aux.jpg"))	$path		="http://solesgps.com/$aux.jpg";						
				else if(file_exists("$aux.jpeg"))	$path		="http://solesgps.com/$aux.jpeg";
			
				if(isset($path))
					$this->words["files_description"]		="
						<div id=\"tabs-10\"  class=\"form\">					  
							<img src=\"$path\" width=\"300\">
						<div>
					";
			}    		    		
		}						
		public function __VIEW_REPORT($option=NULL)
    	{    		
    		if(is_null($option)) 			$option					=array();
    		
    		$option["actions"]		=array(
    			"show"		=>"false",
    		);
    		return parent::__VIEW_REPORT($option);
		}
		
	}
?>
