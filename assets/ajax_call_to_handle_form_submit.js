jQuery( document ).ready(function() {
    // Handler for .ready() called.
    //
  jQuery(function(){
  jQuery("#form_101687").submit(function(event){
   event.preventDefault();
   event.stopPropagation();
 
            var formOk = true;
            // do js validation 
   jQuery.ajax({
    url:ajaxsld_object.ajaxsld_url,
                type:'POST',
                data: jQuery(this).serialize() + "&action=ajaxsld_do_something",
                cache: false,
    success:function(response){ 
     if(response=="true"){
                       //alert('success'); 
        jQuery("#display_rec").html("<div style='color: green;' class='success'><p>SAVED</p></div>")
                    }else{
                        jQuery("#display_rec").html("<div style='color: red' class='fail'>Please input required fields.</div>")
                        //alert('Please input required fields.'); 
                    } 
                }
   });
  }); 
    });
});


