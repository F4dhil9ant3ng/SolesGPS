<?php
	#if(file_exists("nucleo/general.php")) require_once("nucleo/general.php");
	
	if(@file_exists("nucleo/GeometryLibrary/vendor/autoload.php"))			require_once("nucleo/GeometryLibrary/vendor/autoload.php");
	if(@file_exists("../nucleo/GeometryLibrary/vendor/autoload.php"))		require_once("../nucleo/GeometryLibrary/vendor/autoload.php");
	if(@file_exists("../../nucleo/GeometryLibrary/vendor/autoload.php"))	require_once("../../nucleo/GeometryLibrary/vendor/autoload.php");				
	
	class position extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $noactualizar	=array("stop");
		var $sys_fields		=array(
			"id"	    =>array(
			    "title"             => "id",
			    "showTitle"         => "si",
			    "type"              => "primary key",
			    "default"           => "",
			    "value"             => "",			    
			),		
			"devicetime"	    =>array(
			    "title"             => "Hora",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			    
			),			
			"protocol"	    =>array(
			    "title"             => "Protocolo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			    
			),
			"deviceid"	    =>array(
			    "title"             => "Dispositivo",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",
			),						
			"latitude"	    =>array(
			    "title"             => "Latitud",
			    "showTitle"         => "si",
			    "type"              => "font",
			    "default"           => "",
			    "value"             => "",
			),						
			"longitude"	    =>array(
			    "title"             => "Longitud",
			    "showTitle"         => "si",
			    "type"              => "font",
			    "default"           => "",
			    "value"             => "",
			),						
			"altitude"	    =>array(
			    "title"             => "Altura",
			    "showTitle"         => "si",
			    "type"              => "font",
			    "default"           => "",
			    "value"             => "",
			),						
			"speed_max"	    =>array(
			    "title"             => "Velocidad Maxima",
			    "showTitle"         => "si",
			    "type"              => "font",
			    "default"           => "",
			    "value"             => "",
			),						
			"speed_start"	    =>array(
			    "title"             => "Velocidad Inicio",
			    "showTitle"         => "si",
			    "type"              => "font",
			    "default"           => "",
			    "value"             => "",
			),						
			"speed_end"	    =>array(
			    "title"             => "Velocidad Fin",
			    "showTitle"         => "si",
			    "type"              => "font",
			    "default"           => "",
			    "value"             => "",
			),						

			"course"	    =>array(
			    "title"             => "Curso",
			    "showTitle"         => "si",
			    "type"              => "font",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),						
			"address"	    =>array(
			    "title"             => "Localizacion",
			    "showTitle"         => "si",
			    "type"              => "font",
			    "default"           => "",
			    "value"             => "",
			),						
			
			"ubicacion"	    =>array(
			    "title"             => "Ubicacion",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",

			),	
			"leido"	    =>array(
			    "title"             => "leido",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",

			),
			"event"	    =>array(
			    "title"             => "Evento",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",

			),	
			"geofence"	    =>array(
			    "title"             => "Geocerca",
			    "showTitle"         => "si",
			    "type"              => "input",
			    "default"           => "",
			    "value"             => "",

			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			$this->sys_table="positions";
			parent::__CONSTRUCT();
		}
		
		public function __SAVE($datas=NULL,$option=NULL)
    	{    		
    		#echo "<br>SAVE MODULO";
    		#$this->__PRINT_R($datas);    		
    		parent::__SAVE($datas,$option);
    		
		}	
		public function cron_retraso()
    	{			    		
			$comando_sql="
				SELECT v.*, md5(ID) as md5_id 
				FROM V_ULTIMOREPORTE v 
				WHERE 1=1
					AND tipo_vehiculo='GPS'
					AND reporto_hace>'00:05:00'
			";
			$position_data 		=$this->__EXECUTE($comando_sql);
			
			#$this->__PRINT_R($position_data);
			if(count($position_data)>0)
			{								
				#$comando_sql		="INSERT INTO logs SET text='RETARDO DE ". count($position_data) ."'";
				#$this->__EXECUTE($comando_sql);
				
				$devices_tr			="<tr><td>Status</td><td>WA</td><td>Contacto</td><td>Dispositivo</td><td>Tiempo</td><td></td></tr>";			
				
				foreach($position_data as $row)
				{
					if($row["ESTADO"]=="RETRASADO")
					{
						echo "<br>#### RETRASO {$row["REPORTO_HACE"]} :: {$row["NOMBRE"]} ######## ";
						$devices_tr		.="
							<tr>
								<td>
									<a href=\"http://solesgps.com/seguimientos/&a={$row["md5_id"]}\">
										<img height=\"30\" src=\"http://solesgps.com/modulos/execute/status_device.php?ID={$row["ID"]}&time=".date("YmdHis")."\">
									</a>
								</td>				
								<td>
									<a href=\"https://api.whatsapp.com/send?phone={$row["TEL_COMPANY"]}&text=Detectamos ausencia de senal de su {$row["NOMBRE"]}\">
										<img height=\"30\" src=\"http://solesgps.com/sitio_web/img/WA.png\">
									</a>								
								</td>	
								<td><a href=\"tel:{$row["TELEFONO"]}\">
									<img src=\"http://solesgps.com/sitio_web/img/phone.png\">
								</a></td>        
								<td>{$row["NOMBRE"]}<br>{$row["EMPRESA"]}</td>
								<td>{$row["REPORTO_HACE"]}<br>{$row["REPORTO_HACE"]}</td>
								<td><a href=\"http://solesgps.com/execute/&a={$row["md5_id"]}&sys_section_execute=saldo_correo\">
									<img height=\"40\" src=\"http://solesgps.com/sitio_web/img/recarga.png\">
								</a></td>
							</tr>
						";
					}
				}
				$mensaje   = "
					<html>
						<body>
							CRONS RETRASO
							<table>	$devices_tr </table>
						</body>	
					</html>				
				";								
				$this->sys_date					=date("Y-m-d H:i:s");
				$option=array(
					"to"	=>"evigra@gmail.com, daniel.dazaet@gmail.com,judith.avi03@gmail.com",
					"title"	=>"SOLESGPS ".$this->date." :: Dispositivos Retrasados",										
					"html"	=>"$mensaje",			
				);				
				$this->send_mail($option);				
			}
			return count($position_data) . " Dispositivos retrazados";
									
		}
		public function cron_retraso_ALERTAS()
    	{			    		
			$comando_sql="
				SELECT v.*, md5(ID) as md5_id 
				FROM V_ULTIMOREPORTE v 
				WHERE 1=1
					AND tipo_vehiculo='GPS'
					AND reporto_hace>'00:30:00'
					AND reporto_hace<'01:10:00'					
			";
			$position_data 		=$this->__EXECUTE($comando_sql);
			
			if(count($position_data)>0)
			{								
				foreach($position_data as $row)
				{					
					$mensaje= "SolesGPS :: Detectada ausencia de senal de {$row["NOMBRE"]}, Tiempo ausente {$row["REPORTO_HACE"]}";
					#$row["TEL_COMPANY"]="5213143520972";
					
					$this->__SMS("+{$row["TEL_COMPANY"]}", $mensaje, false, "");					
					$this->__WA(array("telefono"=>$row["TEL_COMPANY"], "mensaje"=>$mensaje));
				}
			}
		}
		public function cron_retraso_WA()
    	{			    		
			$comando_sql="
				SELECT v.*, md5(ID) as md5_id 
				FROM V_ULTIMOREPORTE v 
				WHERE 1=1
					AND tipo_vehiculo='GPS'
					AND reporto_hace>'00:30:00'
					AND reporto_hace<'01:10:00'
					
			";
			$position_data 		=$this->__EXECUTE($comando_sql);
			
			if(count($position_data)>0)
			{								
				foreach($position_data as $row)
				{					
					$mensaje= "SolesGPS :: Detectada ausencia de senal de {$row["NOMBRE"]}, Tiempo ausente {$row["REPORTO_HACE"]}";
					#$row["TEL_COMPANY"]="5213143520972";
					
					$this->__SMS("+{$row["TEL_COMPANY"]}", $mensaje, false, "");
				}
			}
		}

		public function cron_retraso_mayor()
    	{			    		
			$comando_sql="
				SELECT v.*, md5(ID) as md5_id FROM V_ULTIMOREPORTE v 
				WHERE 1=1
					AND tipo_vehiculo='GPS'
					AND reporto_hace>'05:00:00'
			";
			$position_data 		=$this->__EXECUTE($comando_sql);
			
			#$this->__PRINT_R($position_data);
			if(count($position_data)>0)
			{								
				$comando_sql		="INSERT INTO logs SET text='RETARDO DE ". count($position_data) ."'";
				$this->__EXECUTE($comando_sql);
				
				$devices_tr			="<tr><td>Status</td><td>Dispositivo</td><td>Empresa</td><td>Tiempo</td></tr>";			
				
				foreach($position_data as $row)
				{
					echo "<br>#### RETRASO {$row["REPORTO_HACE"]} :: {$row["NOMBRE"]} ######## ";
					
					
					$devices_tr		.="
						<tr>
							<td><a href=\"http://solesgps.com/seguimientos/&a=\">
								<img src=\"http://solesgps.com/modulos/execute/status_device.php?ID={$row["ID"]}&time=".date("YmdHis")."\">
								</a>
							</td>
							<td>{$row["NOMBRE"]}</td>
							<td>{$row["EMPRESA"]}</td>
							<td>{$row["REPORTO_HACE"]}</td>
							<td><a href='tel:{$row["TELEFONO"]}'>{$row["TELEFONO"]}</a></td>
							
							
						</tr>
					";
				}
				$mensaje   = "
					<html>
						<body>
							CRONS RETRASO
							<table>	$devices_tr </table>
						</body>	
					</html>				
				";								
				$this->sys_date					=date("Y-m-d H:i:s");
				$option=array(
					"to"	=>"evigra@gmail.com, daniel.dazaet@gmail.com,judith.avi03@gmail.com",
					"title"	=>"SOLESGPS ".$this->date." :: Dispositivos Retrasados",										
					"html"	=>"$mensaje",			
				);				
				$this->send_mail($option);				
			}						
		}


		public function cron_delete_position()
    	{			    		
			$comando_sql="
				delete from positions
				where valid=0 OR
					deviceTime<date_sub(NOW(), INTERVAL (
						SELECT 
							case 
								when history is NULL then 45 
								else history  
							end 
						FROM devices d 
						WHERE d.id=positions.deviceId
					) DAY); 
			";
			$position_data 		=$this->__EXECUTE($comando_sql);
			return "Posiciones borradas";
		}
		public function cron_log_block()
    	{			    		
			$comando_sql="	
				DELETE FROM DATABASECHANGELOGLOCK
			";
			$position_data 		=$this->__EXECUTE($comando_sql);
			
			return "Log borrado";
		}

		public function cron_distance()
    	{			    		
			$comando_sql="
				insert into odometer (device_id,start,end,distance,date)
				select 	
					d.id as dev_id,    
					min(truncate((extract_JSON(p.attributes,'totalDistance') + d.odometro_inicial)/1000,1)) as inicial,
					max(truncate((extract_JSON(p.attributes,'totalDistance') + d.odometro_inicial)/1000,1)) as final,
					max(truncate((extract_JSON(p.attributes,'totalDistance') + d.odometro_inicial)/1000,1)) -
					min(truncate((extract_JSON(p.attributes,'totalDistance') + d.odometro_inicial)/1000,1)) as distance,
					left(DATE_SUB(p.devicetime,INTERVAL 6 HOUR),10) as fecha    
				from 
					positions p join 
					devices d on p.deviceId=d.id 
				where 	1=1				
					and extract_JSON(p.attributes,'totalDistance') > 0    
					and left(DATE_SUB(p.devicetime,INTERVAL 6 HOUR),10) > left(DATE_SUB(now(),INTERVAL 2 day),10)
					and left(DATE_SUB(now(),INTERVAL 1 day),10) = left(DATE_SUB(p.devicetime,INTERVAL 6 HOUR),10)
				group by dev_id, left(DATE_SUB(p.devicetime,INTERVAL 6 HOUR),10)
				having distance>0			
			";
			$position_data 		=$this->__EXECUTE($comando_sql);
			
			return "Distancia calculada";
		}

		public function cron_position()
    	{			 
    		$descripcion="";
			$comando_sql="
				select p.*,
					p.id as pos_id,
					d.id as dev_id,
					c.id as com_id,
					DATE_SUB(p.devicetime,INTERVAL {$_SESSION["user"]["huso_h"]} HOUR) as devicetime,
					c.*,
					f.*,
					d.*,
					d.name as dispo,
					CASE 
						WHEN protocol='meitrack' 	THEN EXTRACT_JSON(p.attributes,'event')
						WHEN protocol='gps103' 		THEN EXTRACT_JSON(p.attributes,'alarm')					
						WHEN protocol='tk103' 		THEN 'REPORTE DE TIEMPO'
						WHEN protocol='osmand' 		THEN 'REPORTE DE TIEMPO'
						WHEN protocol='h02' 		THEN 'REPORTE DE TIEMPO'
                        else  'REPORTE DE TIEMPO'
					END
                    as cve_evento,
                    c.telefono as c_telefono,
					CASE 
						WHEN e.descripcion IS NOT NULL THEN e.descripcion
                        else 'REPORTE DE TIEMPO'
					END	 as event 
				from 
					positions p left join 
					event e on 
					CASE
						WHEN protocol='meitrack' 		THEN leido=0 AND p.protocol=e.protocolo AND EXTRACT_JSON(p.attributes,'event')=e.codigo
						WHEN protocol='gps103' 			THEN leido=0 AND p.protocol=e.protocolo AND EXTRACT_JSON(p.attributes,'alarm')=e.codigo
                        WHEN protocol='osmand' 			THEN leido=0 AND p.protocol=e.protocolo
                        WHEN protocol='h02' 			THEN leido=0 
                        WHEN protocol='tk103' 			THEN leido=0 AND p.protocol=e.protocolo
                        ELSE  leido=0
                    END left join
                    devices d on p.deviceid=d.id join
                    company c on d.company_id=c.id left join
                    files f on c.files_id=f.id
				where 1=1					
					AND leido=0
					AND protocol in ('meitrack','gps103','osmand','h02','tk103','' )
					AND valid=1
				LIMIT 500
			";		

			#echo "<br><br>$comando_sql <br><br><br>"; # AND event not in ('REPORTE DE TIEMPO','ALERTA EXCESO DE VELOCIDAD')
			$position_data 				=$this->__EXECUTE($comando_sql);
			#$this->__PRINT_R($position_data);
			#/*
			$aux_descripcion="";
            foreach($position_data as $row)
            {
           
            	echo "<br><br><br>#### POSICION {$row["pos_id"]} :: {$row["dispo"]} ########";
            	$data_update	=array();
            	
            	$data_update["geofence"]	="{$this->geofences($row)}";            	
                $this->travels($row);
                                
                if($row["event"]=="REPORTE DE TIEMPO")
                {                	                	
                	if($data_update["geofence"]!="")
                	{
	            	    $data_update["event"]		="REPORTE POR GEOCERCA";
	            	    $row["event"]				=$data_update["event"];
	            	}    
				}
                if(@$data_update["event"]=="")
	                $data_update["event"]		="{$row["event"]}";
            	
            	
            	$row_new					=$row;
            	$speed_end					="0000-00-00 00:00:00";
            	$speed_start				="0000-00-00 00:00:00";
            	$asunto						="";
            	if($row["speed_max"]>0 AND $row["speed"]*1.852 >= $row["speed_max"] AND $row["speed"]*1.852<=180)		$asunto="VELOCIDAD";
            	else if($row["speed"]*1.852>=110 AND $row["speed"]*1.852<=180)											$asunto="VELOCIDAD";
            	else
            	{
            		if($row["speed_start"]!="0000-00-00 00:00:00")
            			$speed_end			=$row["devicetime"];            	
            	}
            	$option						="";
            	$aux_descripcion			=$this->position_description($row,$option);
            	            	
            	if($asunto=="VELOCIDAD")
            	{       
            		#$row["event"]			="ALERTA EXCESO DE VELOCIDAD";     		
            		if($row["speed_start"]=="0000-00-00 00:00:00")
            		{            			
            			$row["event"]			="ALERTA EXCESO DE VELOCIDAD";     		
            			$descripcion				="
		        			Esta es una alerta de exceso de velocidad
		        			$aux_descripcion
            			";            			            			            			
            			$speed_start				=$row["devicetime"];
            			$speed_end					="0000-00-00 00:00:00";
            	
            			#$row_new["speed"]			=$row["speed"]*1.852;
            		}	
            	}   
            	$comando_sql_complemento="";         	            	
				if($speed_end!="0000-00-00 00:00:00" OR $speed_start!="0000-00-00 00:00:00")
				{					
					$comando_sql_complemento="
						, speed_end='$speed_end', speed_start='$speed_start'							
					";						
				}            	
				
    			$menu_id					="2";
    			$submenu_id					="13";
    			$opcion_id					="46";
    			$color						="yellow";
    			
				###################################################
				# ALERTAS #########################################
				###################################################
				
				$descripcion	.="$aux_descripcion";
				#echo $row["descripcion"];
            	if(substr($row["event"],0,5)=="ALERT")
            	{	
            		echo "<br>  ALERT {$row["event"]}";
            		$enviar_mail=0;	
					$option_mail=array(
						"to"		=>"{$row["mail_to"]}",
						"bbc"		=>"evigra@gmail.com",
						"title"		=>"SOLESGPS :: {$row["event"]}"
					);						
					$option_mail["to"].="{$row["mail_speed"]}";			
            
            	
            		$comando_sql		="";
            		$PRE_comando_sql	="
            			INSERT INTO alert SET 
            				device_id='{$row["dev_id"]}', 
            				company_id	='{$row["company_id"]}', 
            				fechaEvento	='{$row["devicetime"]}', 
            			";
            		#if($speed_end!="0000-00-00 00:00:00")            	
            		if($speed_end!="0000-00-00 00:00:00" AND $speed_start!="0000-00-00 00:00:00")
            		{	# VELOCIDAD
            			$enviar_mail=1;
            			$descripcion	="
		        			Esta es una alerta por exceso de velocidad
		        			$aux_descripcion
            			";            			            			
						$comando_sql="
							$PRE_comando_sql
							descripcion='{$descripcion}',
							asunto		='{$row["event"]}',
							menu_id		='$menu_id',
							submenu_id	='$submenu_id',
							opcion_id	='$opcion_id',
							color		='$color'
						";		

						$mensaje		="SolesGPS [{$row["dispo"]}] :: Alerta por exceso de velocidad";
						$this->__SMS("+{$row["c_telefono"]}", $mensaje, false, "");					
						$this->__WA(array("telefono"=>$row["$c_telefono"], "mensaje"=>$mensaje));
					}	
            		else if($row["event"]=="ALERTA ALARMA DE BATERIA")
            		{	# BATERIA BAJA
            			$enviar_mail=1;
            			$color			="yellow";
            			$descripcion	="
		        			Esta es una alerta por exceso de velocidad
		        			$aux_descripcion
            			";        
            			    			            			            			
						$comando_sql="
							$PRE_comando_sql
							descripcion='{$descripcion}',
							asunto		='{$row["event"]}',
							menu_id		='$menu_id',
							submenu_id	='$submenu_id',
							opcion_id	='$opcion_id',
							color		='$color'
						";		
						$mensaje		="SolesGPS [{$row["dispo"]}] :: Alerta por falta de bateria";
						$this->__SMS("+{$row["c_telefono"]}", $mensaje, false, "");					
						$this->__WA(array("telefono"=>$row["$c_telefono"], "mensaje"=>$mensaje));
					}	
            		else if($row["event"]=="ALERTA SOS PRESIONADO")
            		{	# BATERIA BAJA
            			$enviar_mail=1;
            			$color			="red";
            			$descripcion	="
		        			Esta es una alerta por SOS
		        			$aux_descripcion
            			";            			            			
						$comando_sql="
							$PRE_comando_sql
							descripcion='{$descripcion}',
							asunto		='{$row["event"]}',
							menu_id		='$menu_id',
							submenu_id	='$submenu_id',
							opcion_id	='$opcion_id',
							color		='$color'
						";														
						$mensaje		="SolesGPS [{$row["dispo"]}] :: Alerta SOS";
						$this->__SMS("+{$row["c_telefono"]}", $mensaje, false, "");					
						$this->__WA(array("telefono"=>$row["$c_telefono"], "mensaje"=>$mensaje));
					}	
            		else if($row["event"]=="ALERTA BATERIA BAJA")
            		{	# BATERIA BAJA
	            		$enviar_mail=1;
            			$color			="red";
            			$descripcion	="
		        			Esta es una alerta por bateria baja
		        			$aux_descripcion
            			";            			            			
						$comando_sql="
							$PRE_comando_sql
							descripcion='{$descripcion}',
							asunto		='{$row["event"]}',
							menu_id		='$menu_id',
							submenu_id	='$submenu_id',
							opcion_id	='$opcion_id',
							color		='$color'
						";		
						$mensaje		="SolesGPS [{$row["dispo"]}] :: Alerta bateria baja";
						$this->__SMS("+{$row["c_telefono"]}", $mensaje, false, "");					
						$this->__WA(array("telefono"=>$row["$c_telefono"], "mensaje"=>$mensaje));
					}	

            		else
            		{	# CUALQUIER OTRO
	            		$enviar_mail=1;
            			$descripcion	="
		        			Esta es una alerta automatica
		        			$aux_descripcion
            			";            			            			

						$comando_sql="
							$PRE_comando_sql
							descripcion='{$descripcion}',
							asunto		='{$row["event"]}',
							menu_id		='$menu_id',
							submenu_id	='$submenu_id',
							opcion_id	='$opcion_id',
							color		='$color'
						";
								
					}	
					
					if($comando_sql!="")
					{
						echo "<br>$comando_sql";
						$this->__EXECUTE($comando_sql);
					}	
					if($enviar_mail==1)
						$this->mail_position($row_new,$option_mail);					
            	}	            	
                $this->sys_primary_id		=$row["pos_id"];
                $data_update["leido"]		="1";
                $data_update["status"]		="1";
                $data_update["company_id"]	=$row["com_id"];
                
                $option_position			=array();

                $this->__SAVE($data_update,$option_position);
                
				$comando_sql="
					UPDATE devices d, positions p
					SET d.positionid='{$row["pos_id"]}' $comando_sql_complemento
					WHERE 1=1
						AND p.id='{$row["pos_id"]}'
						AND p.deviceid=d.id					
						AND d.lastupdate<p.devicetime
						AND d.id='{$row["dev_id"]}'
				";		
				#$this->__EXECUTE($comando_sql);				
                
            }		
			return count($position_data) . " POSICIONES";				
            #*/
		}

		public function cron_position_ausencia_senal($position=NULL,$option=NULL)
		{
				$comando_sql="
					UPDATE devices d, positions p
					SET d.positionid='{$row["pos_id"]}' $comando_sql_complemento
					WHERE 1=1
						AND p.id='{$row["pos_id"]}'
						AND p.deviceid=d.id					
						AND d.lastupdate<p.devicetime
						AND d.id='{$row["dev_id"]}'
				";		
				#$this->__EXECUTE($comando_sql);				

		}
		public function mail_position($position=NULL,$option=NULL)
    	{		 
			if(is_null($option))			$option				=array();
			
			if(!isset($option["to"]))		$option["to"]		="evigra@gmail.com";
			if(!isset($option["title"]))	$option["title"]	="SolesGPS Mail automatico";
			
			$mensaje   = $this->position_description($position,$option);
			
			$option["html"]	=$mensaje;
			
			$this->send_mail($option);
		}
		public function position_description($position=NULL,$option)
    	{		 
    		$title="";
    		if(isset($option["title"]))	$title=$option["title"];
    		
    		$position["speed"]	=$position["speed"]*1.852;
    		
			$nombre_fichero 	= "";			
			$img_streetview= "";
	
			$localizacion="";
			if($position["address"]!="")	$localizacion=$position["address"];
			else							$localizacion=$position["geofence"];
			
			$ruta="/alert_mail/&a=".md5($position["pos_id"]);

			if($position["file_id"]>0)			
				$logo="
					<tr><td colspan=\"2\"><img width=\"50\" border=\"0\" alt=\"\" src=\"http://solesgps.com/modulos/files/file/{$position["file_id"]}.{$position["extension"]}\"></td>		<td colspan=\"2\"></td></tr>
				";
			else $logo="";
			
			$return   = "			
				<div style=\"width:100%; background-color:#aaa;\">
					<br><br>
					<center>																				
						<table style=\"margin:5px; background-color:#fff;\">									
							$logo
							<tr><td><b>Dispositivo</b></td>		<td>{$position["dispo"]}</td>		<td><b>Identificador</b></td>	<td>{$position["placas"]}</td></tr>
							<tr><td><b>Localizacion</b></td>	<td>{$localizacion}</td>			<td><b>Velocidad</b></td>		<td>{$position["speed"]}</td></tr>
							<tr><td><b>Fecha</b></td>			<td>{$position["devicetime"]}</td>	<td><b>Evento</b></td>			<td>{$position["event"]}</td> </tr>
							<tr>
								<td colspan=\"4\">
									<a href=\"{$position["sistema_web"]}$ruta\">
									<img width=\"600\" border=\"0\" alt=\"IMAGEN\" src=\"http://maps.googleapis.com/maps/api/streetview?key=AIzaSyCTDTeSJ3Uu3hHCy73RzGoJbx6vmKcmmUI&size=600x300&location={$position["latitude"]},{$position["longitude"]}\"><br>
			        				<img width=\"600\" border=\"0\" alt=\"IMAGEN\" src=\"http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyCTDTeSJ3Uu3hHCy73RzGoJbx6vmKcmmUI&zoom=16&size=600x300&maptype=roadmap&markers=color:red%7C{$position["latitude"]},{$position["longitude"]}\"><br>
			        				<img width=\"600\" border=\"0\" alt=\"IMAGEN\" src=\"http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyCTDTeSJ3Uu3hHCy73RzGoJbx6vmKcmmUI&zoom=16&size=600x300&maptype=hybrid&markers=color:red%7C{$position["latitude"]},{$position["longitude"]}\">				
			        				</a>
								</td>
							</tr>
						</table>						
						Este mensaje fue generado por un sistema automatizado. Por favor, no respondas a este mensaje.<br>
						©2017 <a href=\"http://solesgps.com\">Soluciones Satelitales :: SolesGPS</a>. Todos los derechos reservados.<br>
						Localiza tus unidades desde $349 Mensuales (+ IVA)
					</center>
					<br><br>&nbsp;		
				</div>									
			";								
			return $return;
		}

		public function geofences($position=NULL)
    	{		     		
           	$option						="";
        	$aux_descripcion			=$this->position_description($position,$option);

    		if(!isset($_SESSION["geofence"]))	
    			$_SESSION["geofence"]=array();
    		#if(!isset($_SESSION["geofence"][$position["company_id"]]))	
			{
				$comando_sql				="
					SELECT a.id as aid, a.*, ad.*, ag.*, ag.id as agid, g.*, g.id as gid
					FROM 
						alerts a join
						alerts_device ad on ad.alerts_id=a.id and ad.status=1 join
						alerts_geofence ag on ag.alerts_id=a.id and ag.status=1 join
						geofences g on g.id=ag.geofence_id
					WHERE 1=1
						AND a.status='activo'	
					 	AND a.company_id={$position["company_id"]}
		                AND (
							a.geofence_in!=''
		                    OR a.geofence_out!=''
		                )    					 
				";
				#echo "<br><br>$comando_sql";
				$geofence_data 				=$this->__EXECUTE($comando_sql);				
				$_SESSION["geofence"][$position["company_id"]]=$geofence_data;									
			}
			$geofence_data					=$_SESSION["geofence"][$position["company_id"]];
			$return="";			

            foreach($geofence_data as $row)
            { 
            	# LA POSICION DEL DISPOSITIVO DEBE CONINCIDIR CON LAS GEOCERCAS ASIGNADAS
            	if($row["device_id"]==$position["dev_id"])
            	{
            		#echo "GEOCERCA >>>>>>>>>>>>>>>>>>> <br>";
		        	$row["area"]	=substr($row["area"],9,strlen($row["area"])-11);
		        	#$points		=str_replace(",", " ", $row["area"]);            	
		        	$polygon		=explode(",",$row["area"]);
		        	$total			=count($polygon)-1;
		        	if(count($polygon)>0)
		        	{
				    	#unset($polygon[$total]);            	            	
				    	$respueta	=$this->pointInPolygon("{$position["latitude"]} {$position["longitude"]}", $polygon);
				    	#echo "RESPUESTA: $respueta<br>";
						$comando_sql="
							select * from devices_geofences 
							WHERE 1=1
								AND deviceid	={$position["dev_id"]} 
								AND geofenceid	={$row["gid"]}
								AND alertid		={$row["aid"]}
								AND STATUS		='1' 						
								AND tipo		='GEOFENCES'
								AND del IS NULL
						";				    	
						$devicegeofence_data 		=$this->__EXECUTE($comando_sql);
						#echo "<br><br>$comando_sql";
						#$this->__PRINT_R(array($respueta,count($devicegeofence_data),$devicegeofence_data,$comando_sql));
												
				    	if($respueta=="DENTRO")
				    	{   		        		
				    		#echo "DENTRO >>>>>>>>> <br>";
							$return="";					
							if(count($devicegeofence_data)==0)
							{
								$comando_sql="
									select * from devices_geofences 
									WHERE 1=1
										AND deviceid	={$position["dev_id"]} 
										AND geofenceid	={$row["gid"]}
										AND alertid		={$row["aid"]}
										AND time_end > DATE_SUB('{$position["devicetime"]}',INTERVAL 4 MINUTE)
										AND STATUS		='1' 						
										AND tipo		='GEOFENCES'

								";				    	
								$devicegeofence_data 		=$this->__EXECUTE($comando_sql);

								if(count($devicegeofence_data)==0)
								{
									$comando_sql="
										INSERT INTO devices_geofences SET 
											deviceid	={$position["dev_id"]}, 
											geofenceid	={$row["gid"]}, 
											alertid		={$row["aid"]},  
											time		='{$position["devicetime"]}',
											positionid	='{$position["pos_id"]}',
											company_id	={$row["company_id"]},
											tipo		='GEOFENCES',
											status		=1
									";									
									$this->__EXECUTE($comando_sql);
									$option_mail=array(
										"to"		=>$row["geofence_in"],
										#"bbc"		=>$row["geofence_email_in"],
										"title"		=>"SOLESGPS ".$this->date2." :: Entrada a Geocercas"
									);
									$position["geofence"]=$row["name"];
									$this->mail_position($position,$option_mail);

									$descripcion	="
										Esta es una alerta ingreso a geocerca
										$aux_descripcion
									";            			            																			
									$comando_sql	="
										INSERT INTO alert SET
											company_id	={$position["company_id"]},
											device_id	='{$position["dev_id"]}',  
											geofence_id	={$row["gid"]},  										
											fechaEvento	='{$position["devicetime"]}', 
											asunto		='ENTRADA A GEOCERCA',
											descripcion	='{$descripcion}',
											menu_id		='$menu_id',
											submenu_id	='$submenu_id',
											opcion_id	='$opcion_id',
											color		='$color'
										";		
									$this->__EXECUTE($comando_sql);
									echo "<br>GEOCERCA -> $comando_sql";
									
								}
								else
								{
									$comando_sql	="UPDATE devices_geofences SET 
											time_end is NULL, 
											del is NULL 
										WHERE 1=1
											AND deviceid={$position["dev_id"]} 
											AND geofenceid={$row["gid"]} 
											AND alertid={$row["aid"]}
											AND tipo ='GEOFENCES'
											AND time_end > DATE_SUB('{$position["devicetime"]}',INTERVAL 4 MINUTE)
									";
									$this->__EXECUTE($comando_sql);
								}
								
							}    					
				    		$return.="{$row["name"]}";
				    	}
				    	else if($respueta=="AFUERA")
				    	{        		        		
				    		#echo "AFUERA >>>>>>>>> <br>";							
							if(count($devicegeofence_data)>0)
							{
								$comando_sql	="UPDATE devices_geofences SET 
										time_end='{$position["devicetime"]}', 
										del=1 
									WHERE 1=1
										AND deviceid={$position["dev_id"]} 
										AND geofenceid={$row["gid"]} 
										AND alertid={$row["aid"]}
										AND time_end is NULL
										AND tipo ='GEOFENCES'
								";
								#echo "<br>AFUERA UPD :: $comando_sql";
								$this->__EXECUTE($comando_sql);
								
								$option_mail=array(
									"to"		=>@$row["geofence_out"],
									#"bbc"		=>@$row["geofence_email_out"],
									"title"		=>"SOLESGPS ".$this->date2." :: Salida de Geocercas"
								);
								$position["geofence"]=$row["name"];
								$this->mail_position($position,$option_mail);
								$return.="{$row["name"]}";
				    			$descripcion	="
									Esta es una alerta por egreso de geocerca
									$aux_descripcion
				    			";            			            																			
								$comando_sql	="
									INSERT INTO alert SET
										company_id	={$position["company_id"]},
										device_id	='{$position["dev_id"]}',  
										geofence_id	={$row["gid"]},  										
										fechaEvento	='{$position["devicetime"]}', 
										asunto		='SALIDA DE GEOCERCA',
										descripcion='{$descripcion}',
										menu_id		='$menu_id',
										submenu_id	='$submenu_id',
										opcion_id	='$opcion_id',
										color		='$color'
									";				
								$this->__EXECUTE($comando_sql);
								echo "<br>GEOCERCA -> $comando_sql";
							}
				    	}  
		        	}          	
				}
			}	
			return $return;
		}		
		public function crear_route($points, $position)
    	{		     		
    		$ida	=array();
    		$vuelta	=array();
    		$anterior="";
    		    		
    		$latitud_mayor	=$position["latitude"]+0.01;
    		$latitud_menor	=$position["latitude"]-0.01;
    		
    		$longitud_mayor	=$position["longitude"]+0.01;
    		$longitud_menor	=$position["longitude"]-0.01;
    		  
            foreach($points as $point)
            { 
            	$t_punto_actual	=@explode(" ",$point);
            	
            	if($latitud_menor<$t_punto_actual[0] AND $latitud_mayor>$t_punto_actual[0] AND $longitud_menor<$t_punto_actual[1] AND $longitud_mayor>$t_punto_actual[1])
            	{	#echo "<br>$latitud_menor < {$t_punto_actual[0]} > $latitud_mayor";            		

					if(@$anterior=="")		$anterior=$t_punto_actual;
					else
					{
						$nuevo	=$t_punto_actual;
					
						if(abs($nuevo[0]-$anterior[0])>0.00000001 AND abs($nuevo[1]-$anterior[1])>0.00000001)
						{								
							$response1 =  \GeometryLibrary\SphericalUtil::computeHeading(
								array('lat' => $anterior[0], 'lng' => $anterior[1]), 
								array('lat' => $nuevo[0], 'lng' => $nuevo[1])
							);	
											
						  	$nuevo_p1 =  \GeometryLibrary\SphericalUtil::computeOffset(array('lat' => $nuevo[0], 'lng' => $nuevo[1]), 60, $response1 - 90);
						  	$nuevo_p2 =  \GeometryLibrary\SphericalUtil::computeOffset(array('lat' => $nuevo[0], 'lng' => $nuevo[1]), 60, $response1 + 90);
							
						  	$anterior_p1 =  \GeometryLibrary\SphericalUtil::computeOffset(array('lat' => $anterior[0], 'lng' => $anterior[1]), 60, $response1 - 90);
						  	$anterior_p2 =  \GeometryLibrary\SphericalUtil::computeOffset(array('lat' => $anterior[0], 'lng' => $anterior[1]), 60, $response1 + 90);
						
								
							if(@$nue_ant_p1=="")
							{
								$nue_ant_p1	=$nuevo_p1;
								$nue_ant_p2	=$nuevo_p2;
							
						  		$ida[]		=$anterior_p1["lat"]." ".$anterior_p1["lng"];					  						  		
						  		array_unshift($vuelta, $anterior_p2["lat"]." ".$anterior_p2["lng"]);
							}				
							else
							{							
								$actual_p1_lat	=($nue_ant_p1["lat"] + $anterior_p1["lat"])/2;
								$actual_p1_lng	=($nue_ant_p1["lng"] + $anterior_p1["lng"])/2;
							
								$actual_p2_lat	=($nue_ant_p2["lat"] + $anterior_p2["lat"])/2;
								$actual_p2_lng	=($nue_ant_p2["lng"] + $anterior_p2["lng"])/2;								
								
								$point_ida		=$actual_p1_lat." ".$actual_p1_lng;
								$point_vuelta	=$actual_p2_lat." ".$actual_p2_lng;
								
								$respueta_ida	="AFUERA";
								$respueta_vuelta="AFUERA";
								
								
								if(is_array(@$polygon) AND count($polygon)>5)
								{	
									$respueta_ida		=$this->pointInPolygon($point_ida, $polygon);
									$respueta_vuelta	=$this->pointInPolygon($point_vuelta, $polygon);								
								}
								if($respueta_ida=="AFUERA")		$ida[]			=$point_ida;
								if($respueta_vuelta=="AFUERA")	array_unshift($vuelta, $point_vuelta);
						  		
						  		$polygon		=array_merge($ida, $vuelta);			

								$nue_ant_p1		=$nuevo_p1;
								$nue_ant_p2		=$nuevo_p2;							
							}
						}
						$anterior=$nuevo;
					}

				}
			}
	  		$ida[]		=$nue_ant_p1["lat"]." ".$nue_ant_p1["lng"];
	  		array_unshift($vuelta, $nue_ant_p2["lat"]." ".$nue_ant_p2["lng"]);
				
			$ida=array_merge($ida, $vuelta);			

			$ida[]=$ida[0];
			
			return $ida;
		}		
		
		
		
		
		public function travels($position=NULL)
    	{		     		
    		$aux_descripcion			=$this->position_description($position,"");
    		if(!isset($_SESSION["travels"]))	
    			$_SESSION["travels"]=array();
    		#if(!isset($_SESSION["geofence"][$position["company_id"]]))	
			{
				$comando_sql				="
					select 
						r.*, r.id as gid, r.id as aid
					from 
						travels t join route r on r.id=t.route_id
						
					where  1=1
						AND t.company_id={$position["company_id"]}
						AND left(sysdate(),10) BETWEEN t.inicio AND t.fin					
				";
				#echo "<br><br>$comando_sql >>>>>>>>>>>>>>>>";
				$geofence_data 				=$this->__EXECUTE($comando_sql);
				
				$_SESSION["travels"][$position["company_id"]]=$geofence_data;									
			}
			$geofence_data					=$_SESSION["travels"][$position["company_id"]];
			
			#$this->__PRINT_R($geofence_data);
			$return="";			
            foreach($geofence_data as $row)
            {
            	#echo "<br><br>$comando_sql >>>>>>>>>>>>>>>>";
            	#echo "<br>recorre routas"; 
            	# LA POSICION DEL DISPOSITIVO DEBE CONINCIDIR CON LAS GEOCERCAS ASIGNADAS
            	#if($row["device_id"]==$position["dev_id"])
            	#$this->__PRINT_r($row);
            	{
            		$points_route	=explode(",",$row["points_route"]);
		        	$polygon		=$this->crear_route($points_route, $position);
		        	$total			=count($polygon)-1;
		        	if(count($polygon)>0)
		        	{		        
		        		#echo "<br>ANTES RESPUESTA=><br><br>";
				    	$respueta	=$this->pointInPolygon("{$position["latitude"]} {$position["longitude"]}", $polygon);
				    	#echo "<br>RESPUESTA=>$respueta<br><br>";
				    	
						$comando_sql="
							select * from devices_geofences 
							WHERE 1=1
								AND deviceid	={$position["dev_id"]} 
								AND geofenceid	={$row["gid"]}
								AND alertid		={$row["aid"]}  
								AND STATUS		='1' 						
								AND del IS NULL
								AND tipo		='TRAVEL'
						";				

						$devicegeofence_data 		=$this->__EXECUTE($comando_sql);
				    	if($respueta=="DENTRO")
				    	{   		        		
							$return="";					
							if(count($devicegeofence_data)==0)
							{
								$comando_sql="
									INSERT INTO devices_geofences SET 
										deviceid	={$position["dev_id"]}, 
										geofenceid	={$row["gid"]}, 
										alertid		={$row["aid"]},  
										time		='{$position["devicetime"]}',
										positionid	='{$position["pos_id"]}',
										tipo		='TRAVEL',
										status		=1
								";
								$this->__EXECUTE($comando_sql);
								$option_mail=array(
									"to"		=>"evigra@gmail.com",
									"title"		=>"SOLESGPS ".$this->date2." :: Entrando a Ruta"
								);
								$position["geofence"]="ENTRANDO A RUTA";
								$this->mail_position($position,$option_mail);
				    			$descripcion	="
									Esta es una alerta por ingreso a ruta
									$aux_descripcion
				    			";            			            																			
								$comando_sql	="
									INSERT INTO alert SET 
										company_id	={$position["company_id"]}, 
										fechaEvento	='{$position["devicetime"]}', 
										asunto		='{$position["geofence"]}',
										descripcion='{$descripcion}',
										menu_id		='$menu_id',
										submenu_id	='$submenu_id',
										opcion_id	='$opcion_id',
										color		='$color'
									";		
								$this->__EXECUTE($comando_sql);

							}    					
				    		$return.="{$row["name"]}";
				    	}
				    	else if($respueta=="AFUERA")
				    	{        		        		
							if(count($devicegeofence_data)>0)
							{								
								$comando_sql	="UPDATE devices_geofences SET 
										time_end='{$position["devicetime"]}', 
										del=1 
									WHERE 1=1
										and deviceid={$position["dev_id"]} 
										AND geofenceid={$row["gid"]} 
										AND alertid={$row["aid"]}
										AND tipo='TRAVEL'
								";
								$this->__EXECUTE($comando_sql);
								#$this->__PRINT_R($comando_sql);
								
								
								$option_mail=array(
									"to"		=>"evigra@gmail.com",
									"title"		=>"SOLESGPS ".$this->date2." :: ALERTA Salida de ruta"
								);
								$position["geofence"]="SALIDA DE RUTA";
								$this->mail_position($position,$option_mail);
								$return.="{$row["name"]}";
				    			$descripcion	="
									Esta es una alerta por salida de ruta
									$aux_descripcion
				    			";            			            																			
								$comando_sql	="
									INSERT INTO alert SET 
										company_id	={$position["company_id"]}, 
										fechaEvento	='{$position["devicetime"]}', 
										asunto		='{$position["geofence"]}',
										descripcion='{$descripcion}',
										menu_id		='$menu_id',
										submenu_id	='$submenu_id',
										opcion_id	='$opcion_id',
										color		='$color'
									";		
								$this->__EXECUTE($comando_sql);
							}
				    	}  
		        	}          	
				}
			}	
			return $return;
		}		
		public function cron_update_positionid()
    	{
			$comando_sql        ="
				UPDATE devices d JOIN (
					SELECT max(p.id) as pid, d.id as did FROM admin_soles37.positions p join devices d on p.deviceid = d.id
					WHERE company_id=9 AND left(devicetime,10)=left(now(),10)
					GROUP BY deviceid
				) dev  on d.id=dev.did
				SET d.positionid=dev.pid
			";
			$datas_event     =$this->__EXECUTE($comando_sql);	
		}		

		public function position($option=NULL)
    	{
    		if(is_null($option))	$option=array();

			if(!isset($option["from"]))
				$option["from"]		="
					positions p	 	join 
					devices d 		on p.deviceid=d.id
				";	
			if(isset($_SESSION["company"]["id"]))	
				$option["where"][]	="d.company_id={$_SESSION["company"]["id"]}";
			
			if(!isset($option["order"]))
				$option["order"]	="date DESC";			
			
			return $this->__VIEW_REPORT($option);						
		}		
		public function distancias($option=NULL)
    	{
    		if(is_null($option))	$option=array();

			$option["select"]						=array();
		
			$option["select"][]						="name";
			$option["select"]["DATE(servertime)"]	="date";
			$option["select"]["min(truncate((extract_JSON(p.attributes,'totalDistance')/1000) +d.odometro_inicial ,1) )"]			="start";
			$option["select"]["max(truncate((extract_JSON(p.attributes,'totalDistance')/1000) +d.odometro_inicial ,1) )"]			="end";
			$option["select"]["max(truncate((extract_JSON(p.attributes,'totalDistance')/1000) +d.odometro_inicial ,1) )-min(truncate((extract_JSON(p.attributes,'totalDistance')/1000) +d.odometro_inicial ,1) )"]				="distance";

			$option["group"]	="name,left(DATE_SUB(p.devicetime,INTERVAL 6 HOUR),10)";
			
			$option["from"]		="
				positions p	 							join 
				devices d 		on p.deviceid=d.id
			";	
			$option["where"][]	="d.company_id={$_SESSION["company"]["id"]}";

			if(!isset($option["order"]))
				$option["order"]	="date DESC";
			#$option["echo"]		="POSITION";
			
			return $this->__VIEW_REPORT($option);						
		}		

		public function time_position($option=NULL)
    	{
    		if(is_null($option))	$option=array();
			#$option["echo"]	="TIME POSITION";
			if(!isset($option))				$option=array();
			if(!isset($option["select"]))	$option["select"]		=array();

			$option["select"][]						="p.id";
			#$option["select"]["device"]				="d.id";
			$option["select"][]						="name";
			$option["select"][]						="latitude";
			$option["select"][]						="longitude";
			$option["select"][]						="speed";
			$option["select"]["DATE(servertime)"]	="date";
			$option["select"]["TIMEDIFF(MAX(TIME(DATE_SUB(devicetime,INTERVAL {$_SESSION["user"]["huso_h"]} HOUR))),MIN(TIME(DATE_SUB(devicetime,INTERVAL {$_SESSION["user"]["huso_h"]} HOUR))))"]			="time";
			$option["select"]["MIN(TIME(DATE_SUB(devicetime,INTERVAL {$_SESSION["user"]["huso_h"]} HOUR)))"]			="start";
			$option["select"]["MAX(TIME(DATE_SUB(devicetime,INTERVAL {$_SESSION["user"]["huso_h"]} HOUR)))"]			="end";
			$option["select"][]						="address";
			$option["select"]["event"]				="other";

			if(!isset($option["group"]))
				$option["group"]	="CONCAT(longitude,latitude,course),DATE(DATE_SUB(devicetime,INTERVAL {$_SESSION["user"]["huso_h"]} HOUR))";
			if(!isset($option["having"]))	
				$option["having"]	=array("time > TIME(SEC_TO_TIME(60))");
			$option["order"]	="date DESC";
	
			return $this->position($option);						
		}		

		#################################################################################
	}
?>

