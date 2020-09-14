CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'vi';
    config.height = 600;
    config.uiColor = '#AADC6E';
    config.allowedContent = true;
    config.extraAllowedContent = 'button(*)';
    config.filebrowserBrowseUrl      = '/public/backend/libs/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/public/backend/libs/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserUploadUrl      = '/public/backend/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/public/backend/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
};