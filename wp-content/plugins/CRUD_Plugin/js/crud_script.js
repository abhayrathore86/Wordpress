jQuery(document).ready(function (e) {
   jQuery.ajax({
            url: "../wp-content/plugins/CRUD_Plugin/display.php",
            type: "POST",             
            success: function(data)   
            {
               jQuery('#disp').html(data);
            }
          });
   jQuery("#insertForm").on('submit',(function(e) {
      e.preventDefault();
      
      jQuery.ajax({
         url: "../wp-content/plugins/CRUD_Plugin/insert.php", 
         type: "POST",             
         data: new FormData(this), 
         contentType: false,       
         processData:false,        
         success: function(data) 
         {
            alert(data);
            jQuery('#insertForm')[0].reset();
            //location.reload();
            jQuery.ajax({
            url: "../wp-content/plugins/CRUD_Plugin/display.php",
            type: "POST",             
            success: function(data)   
            {
               jQuery('#disp').html(data);
            }
          });
         }
   });
   }));
});
 function UpdateRecord(id)
  {
      jQuery.ajax({
       type: "POST",    
       url: "../wp-content/plugins/CRUD_Plugin/update.php?id="+id,
       cache: false,
       success: function(response)
       {
         jQuery('#insertForm').html('');
         alert(response);
         jQuery('#editForm').html(response);

       }
     });
 }