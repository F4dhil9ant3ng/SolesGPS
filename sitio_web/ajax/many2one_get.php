<?php	
	$objeto_json									=json_decode($_REQUEST["many2one_json"], true);	
	unset($_REQUEST["many2one_json"]);
		
	require_once("../../nucleo/sesion.php");
	$class_one										=$objeto_json["class_one"];
	$class_one_id									=@$objeto_json["class_one_id"];
	$class_field									=$objeto_json["class_field"];
	$class_field_id									=$objeto_json["class_field_id"];
	
	$row											=@$objeto_json["row"];
	
	$obj											=$objeto_json;			
	
	$eval="
		$"."objeto									=new {$class_one}();				
		$"."objeto->__SESSION();	
		
		
		$"."valor									=$"."objeto->sys_fields[$"."class_field];
		
		if(isset($"."valor[\"class_name\"]))
		{
			$"."obj_class							=new $"."valor"."[\"class_name\"]();							
			#$"."obj_class->__PRINT_R($"."obj_class->sys_fields);	
		}
	";		
	eval($eval);	
	
	
	if(!isset($valor["class_template"]))			$valor["class_template"]="many2one_standar";					

	$js												="";
	$row 											=$_SESSION["SAVE"][$objeto->sys_object][$class_field]["data"][$class_field_id];
	$_SESSION["SAVE"][$objeto->sys_object][$class_field]["active_id"]			=$class_field_id;
	
	foreach($row as $field=>$value)
	{
		if(@$obj_class->sys_fields[$field]["type"]=="autocomplete")
		{
			if($obj_class->sys_primary_field==$field)
			{
				$obj_class->__FIND_FIELDS($value);												
			}															
			if(@$obj_class->sys_fields[$field]["type"]=="autocomplete")
			{												
		    	if(isset($obj_class->sys_fields[$field]["class_field_l"]))
		    	{					    		
		    		if(isset($obj_class->sys_fields[$field]["values"]) AND count($obj_class->sys_fields[$field]["values"])>0)
		    		{
		    			$row["auto_".$field]=$obj_class->sys_fields[$field]["values"][0][$obj_class->sys_fields[$field]["class_field_l"]];
					}
					else $row["auto_".$field]="";
				}				
				else $row["auto_".$field]="";

				if(isset($obj_class->sys_fields[$field]["values"][0]))
					$row["auto_".$field]	=$obj_class->sys_fields[$field]["values"][0][$obj_class->sys_fields[$field]["class_field_l"]];
				else $row["auto_".$field]="";							
			}	



			#$obj_class->__PRINT_R($valor);
		}
		$objeto->__PRINT_R($row);
		
		$js.="$(\"#$field".".$class_field\").val(\"$value\");
		";
	}
	
	echo "
		<script>
			$js
		</script>
	";
?>
