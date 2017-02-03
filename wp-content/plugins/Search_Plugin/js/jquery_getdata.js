jQuery(document).ready(function(){
	jQuery('#dataModal').hide();
	//alert("search thayu");
		jQuery("#search_btn").click(function(e){
        e.preventDefault();
       		//alert("search thayu");
       		var s=jQuery('#search_zip').val();
       		//alert(s);
       		jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data:{
               'action':'getData','search_txt':s,
            }  ,           
            success: function(data)   
            {
            	console.log(data);
            	data=data.slice(0,-1);
               	jQuery('#location_info').html(data);  
               	jQuery('#dataModal').modal("show");
            }
        });
    });
}); 