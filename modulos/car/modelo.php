<?php	
	class car extends devices
	{   
		##############################################################################	
		##  Metodos	
		##############################################################################&sys_action=__SAVE
		public function __CONSTRUCT()
		{
			$this->sys_table="devices";
			
			$this->sys_fields["name"]["title"]				="Modelo";			
			$this->sys_fields["placas"]["description"]		="Placas actuales del vehiculo";			
			$this->sys_fields["telefono"]["description"]	="Numero telefonico del celular";			
			$this->sys_fields["image"]["description"]		="Imagen que se presentara en el mapa";			
			$this->sys_fields["image"]["source"]=array(
					"01"	=>	"Tracto Azul",
			    	"02"	=>	"Carro Rojo",
			    	"03"	=>	"Carro Blanco",	
		    );		
			parent::__CONSTRUCT();			
		}				

   		public function __SAVE($datas=NULL,$option=NULL)
    	{    	    
    	    $datas["company_id"]		=$_SESSION["company"]["id"];

    	    $files_id					=$this->files_obj->__SAVE();    	    
    	    if(!is_null($files_id))		$datas["file_id"]			=$files_id;    	    

			#$option["echo"]="CLASS CAR";
    		parent::__SAVE($datas,$option);
		}				
		public function cars($option=NULL)
    	{
    		if(is_null($option))			$option=array();
			if(!isset($option["where"]))    $option["where"]    =array();
			if(!isset($option["select"]))   $option["select"]   =array();
			
			/*			
			$option["select"]["distinct(d.id)"]					="d_id";			
			$option["select"][]									="d.*";
			$option["select"]["md5(d.id)"]						="attr";					
			$option["select"]["IF(image!=0,CONCAT('../sitio_web/img/car/vehiculo_',image,'/i225.png'),'../modulos/device/img/cell.png')"]	="file_id";
			$option["select"]["IF(vehicle=1,'../modulos/device/img/car.png','../modulos/device/img/cell.png')"]								="file_id1";
			
			*/
			$option["where"][]      ="vehicle=1";
			
			#$option["echo"]      ="vehicle=1";
			
			return $this->devices($option);    	
		}						
		public function tab_files()		
    	{
			$this->words["files_title"]				="";
			$this->words["files_description"]		="";
			
			if($this->sys_fields["file_id"]["value"]!="")
			{
				$this->words["files_title"]				="<li  class=\"form\"><a href=\"#tabs-10\">Imagenes</a></li>";    		
				$aux									="modulos/files/file/{$this->sys_fields["file_id"]["value"]}";
			
				if(file_exists("../$aux".".jpg"))						$path		="../$aux".".jpg";
				else if(file_exists("../$aux".".jpeg"))					$path		="../$aux".".jpeg";
				else if(file_exists("http://solesgps.com/$aux.jpg"))	$path		="http://solesgps.com/$aux.jpg";						
				else if(file_exists("http://solesgps.com/$aux.jpeg"))	$path		="http://solesgps.com/$aux.jpeg";
			
				$this->words["files_description"]		="
					<div id=\"tabs-10\"  class=\"form\">
					  $path
						<img src=\"$path\" width=\"300\">
					<div>
				";
			}    		    		
		}						
	}
?>

