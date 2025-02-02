	$(document).ready(function()
	{	    
	    var location;
	    var iZoom       =5;
	    var iMap        ="ROADMAP";
	    var coordinates ={latitude:19.057522756727606,longitude:-104.29785901920393};
	    var object      ="map";
		
        
        CreateMap(iZoom,iMap,coordinates,object); 
		
		google.maps.event.addListener(map, 'zoom_changed',showGeofence);        
        
        
        if(window.location.hostname=="developer.solesgps.com" || window.location.hostname=="localhost")
        {
        	ajax_positions_now("../modulos/travels/ajax/index.php",100);              
        }	

        ajax_positions_now("../modulos/geofences/ajax/index.php",100);
        
        ajax_positions_now("../sitio_web/ajax/map_online.php");
        ajax_positions("../sitio_web/ajax/map_online.php");
        status_device();
                
		$(".select_devices").click(function()
		{	
			var ind=undefined;
			var obj=$(this);
			device_active			=obj.attr("device");	
		
			if(device_active==-1)	device_random=1;
			else					device_random=0;

			if(device_random==1)
			{
				devices_all	=new Array();	
				$("table.select_devices[device!=0][device!=-1]").each(function() 
				{
					devices_all.push($(this).attr("device"));
				});			 	
				obj=$("table.select_devices[device="+devices_all[0]+"]");
				var ind=0;				
			}
			select_devices_send(obj,ind);
		});    	
		
    });    
	function select_devices_send(obj, ind) 
	{		
		device_active			=obj.attr("device");	
		
		if(device_random==1)
		{
			if(ind==undefined)				ind=0;

			if(devices_all.length==ind)		
			{			
				ind=-1;	
			}	
			setTimeout(function()
			{  				
				ind++;
				obj=$("table.select_devices[device="+devices_all[ind]+"]");
				select_devices_send(obj, ind);				
			},10000);	
		}

		ajax_positions_now("../sitio_web/ajax/map_online.php");
		$(".select_devices").removeClass("device_active");
		$(obj).addClass("device_active");
		
		var actualiza="no";
        status_device(actualiza, obj);
	}    
	function messageMap(marcador, vehicle) 
	{
		var contentString = '<div id="contentIW"> \
								<table> \
									<tr> <th align=\"left\"> FECHA	</th>  <td> '+vehicle["da"]+'	</td> 	</tr> \
									<tr> <th align=\"left\"> VELOCIDAD </th> <td> '+vehicle["sp"]+'</td> 	</tr> \
								</table> \
							</div>';

		var infowindow = map_info({content: contentString});
		
		messageMaps(marcador, vehicle,infowindow);		
	}	
    

