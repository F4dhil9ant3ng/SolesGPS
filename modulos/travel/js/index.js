	function auto_empresa_id(ui)
	{
		$("input#empresa_id").val(ui.item.clave);					
		$("input#auto_empresa_id").val(ui.item.label);
		
		
		$("input#venta").val(ui.item.cliente);
		$("input#compra").val(ui.item.proveedor);
	}
	$(document).ready(function()
	{		
		$("#action_pagar").click(function(){
		
			/*
			var mod_destino	="pago_venta";
			var mod_actual	="orden_venta";
			var variables	="../"+mod_destino+"/";
			variables		+="&sys_section_"+mod_destino+"=create";
			variables		+="&sys_action_"+mod_destino+"=";
			variables		+="&"+mod_destino+"_total=" + $("#total[name='"+mod_actual+"_total']").val();
			variables		+="&"+mod_destino+"_fecha=" + $("#fecha[name='"+mod_actual+"_fecha']").val();
			variables		+="&"+mod_destino+"_auto_empresa_id=" + $("#auto_empresa_id[name='"+mod_actual+"_auto_empresa_id']").val();
			variables		+="&"+mod_destino+"_empresa_id=" + $("#empresa_id[name='"+mod_actual+"_empresa_id']").val();																



			$("form").attr({"action":variables});					
			$("form").submit();
			*/
		});
		$("#action_abonar").click(function(){
			$("#sys_action_movimiento").val("__SAVE_abonar");
			$("form").submit();
		});
		$("#action_pagar").click(function(){
			$("#action_cancelar").val("__SAVE_cancelar");
			$("form").submit();
		});
    });
    // ###########################################################################
