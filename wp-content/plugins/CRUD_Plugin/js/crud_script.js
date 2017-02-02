jQuery(document).ready(function (e) {
   jQuery.ajax({
            url: myAjax.ajaxurl,
            type: "POST",
            data:{
               'action':'dispData'
            }  ,           
            success: function(data)   
            {
               jQuery('#disp').html(data);
            }
          });
   jQuery("#insertForm").on('submit',(function(e) {
      e.preventDefault();
      var file_data = jQuery('#imageUp').prop('files')[0];   
       var form_data = new FormData();                  
       form_data.append('file', file_data);
       //alert(form_data);  
      var fn=jQuery("#firstname").val();
      var ln=jQuery("#lastname").val();
      var age=jQuery("#age").val();
      var gen=jQuery("#gender").val();
      var im=form_data.get('file');
      console.log(im);
      jQuery.ajax({
      url: myAjax.ajaxurl,
      data: {
         'action':'insertData','fn':fn,'ln':ln,'age':age,'gen':gen,'im':form_data
      },
      success:function(data) {
         jQuery('#disp').html(data);
      },
      error: function(errorThrown){
          console.log(errorThrown);
      }
   }); 
   }));
   
});
 function UpdateRecord(id)
  {
      jQuery.ajax({
       type: "POST",    
       url: ajaxurl,
       cache: false,
       data:{
               'action':'updateData',
               'id' : id
            }  ,
       success: function(response)
       {
         //alert(response);
         jQuery('#Form').html(response);

       }
     });
 }
 function DeleteRecord(id)
  {
      jQuery.ajax({
       type: "POST",    
       url: ajaxurl,
       cache: false,
       data:{
               'action':'deleteData',
               'id' : id
            }  ,
       success: function(response)
       {
         alert(response);
         jQuery.ajax({
            url: ajaxurl,
            type: "POST", 
            data:{
               'action':'dispData'
            }  ,            
            success: function(data)   
            {
               jQuery('#disp').html(data);
            }
          });
       }
     });
 }