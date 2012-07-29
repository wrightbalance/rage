$(document).ready(function(){

		$('#file_upload').uploadify({
			'swf'      			: '/resources/swf/uploadify.swf',
			'uploader' 			: '/uploader/avatar',
			'buttonClass'		: 'btn btn-primary',
			'width'				: 121,
			'height'			: 31,
			'buttonText'		: 'Choose Avatar',
			'formData'			: {accountid:accountid},
			'onUploadSuccess' 	: function(file, data, response)
			{
				//console.log(data);
			},
			'onUploadComplete' : function(file) {
				//console.log(file);
				$('.avatar').html('Cropping photo....');
				setTimeout(function(){
					location.reload();
				},5000);
			}
		});	
 
});

