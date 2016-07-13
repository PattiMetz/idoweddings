CKEDITOR.plugins.addExternal('eqneditor', '/ckeditor/plugins/codesnippet/');

CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'codesnippet';
};