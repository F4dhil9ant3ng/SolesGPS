	$(document).ready(function()
	{
	    
	    var location;
	    var iZoom       =5;
	    var iMap        ="ROADMAP";
	    var coordinates ={latitude:19.057522756727606,longitude:-104.29785901920393};
	    var object      ="map";
        
        CreateMap(iZoom,iMap,coordinates,object); 
        status_device();

		$(".select_devices").click(function()
		{		    
			$(".select_devices").removeClass("device_active");
			$(this).addClass("device_active");
			device_active=$(this).attr("device");
			
			$("div#tablero").html("Dispositivo seleccionado :: Esperando filtrado");
			$("div#tablero2").html("");
			
	    	$("#form_map").dialog(
	    	{
	    		position: { my: "center top", at	: "center top+45"},
	    		width:621	    	
	    	});

			$("#buscar_map").button({
				icons: {	primary: "ui-icon-search" },
				text: true
				})
				.click(function()
				{
					$("#form_map").dialog("destroy");
					
					var str = $("form").serialize() + "&device_active="+device_active;				
					
					var html_load="Cargando datos<br>\
					<img id=\"loader1\" height=\"30\" width=\"30\" src=\"../sitio_web/img/loader1.gif\">";
					$("div#tablero").html(html_load);
					map_history(str);
					
				}
			);			
		});    
        
    });    
    
	function map_history(str)
	{
		$.ajax(
		{
			async:false,
			cache:false,
			dataType:"html",
			type: "POST",  
			data: str,
			url: "../modulos/street_history/ajax/history.php",
			success:  function(res)
			{					
				//$("#tablero").html("");
				$("#script").html(res);
			},
			beforeSend:function()
			{
			
			},
			error:function(res)
			{			    
				map_history(str);
				$("div#tablero").html("Se presento un error :: Estamos intentando nuevamente");
			}						
		});	
	}
	    
    
    
    
