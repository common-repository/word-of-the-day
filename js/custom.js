jQuery( document ).ready(function() {
    console.log("JS FIled is called");
    jQuery("#file_info").hide();
    jQuery("#upload_excel_sheet").click(function(){
    	console.log("Button is called");
    });
    jQuery("#colletion_of_word").change(function(){
    	var file_data = jQuery('#colletion_of_word').prop('files')[0]; 
    	var file_data = jQuery('#colletion_of_word').prop('files')[0];  
    	var form_data = new FormData();                  
    	form_data.append('action', "file_upload");
    	form_data.append('file', file_data);
	    console.log(myAjax.ajaxurl);
        jQuery.ajax({
	        url: myAjax.ajaxurl,
	        dataType: 'json',
	        cache:false,
	        processData: false,
			contentType: false,
	        data: form_data,                         
	        type: 'post',
	        success: function(responce){
        		if(responce.status == "1"){
        			jQuery("#file_info").show();
        			jQuery("#file_info").text("file upload successfully");
        			jQuery("#file_info").css("color", "green");
        		}else{
        			jQuery("#file_info").show();
        			jQuery("#file_info").text("file uploading failed");
        			jQuery("#file_info").css("color", "red");
        		}
			}
	    });
    })
});