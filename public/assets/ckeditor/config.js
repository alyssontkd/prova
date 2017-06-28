/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */


// Define changes to default configuration here. For example:
// config.language = 'fr';
// config.uiColor = '#AADC6E';

CKEDITOR.editorConfig = function( config ) {
    config.toolbarGroups = [
        // { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        // { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        // { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        // { name: 'forms', groups: [ 'forms' ] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        // { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        // { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        '/',
        // { name: 'styles', groups: [ 'styles' ] },
        // { name: 'colors', groups: [ 'colors' ] },
        // { name: 'tools', groups: [ 'tools' ] },
        // { name: 'others', groups: [ 'others' ] },
        // { name: 'about', groups: [ 'about' ] }
    ];

    config.removeButtons = 'HorizontalRule,SpecialChar,Strike,Table,Save,NewPage,Preview,Print,Source,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Redo,Undo,Find,Smiley,PageBreak,Iframe,ShowBlocks,About,Superscript,Subscript,CreateDiv,Link,Unlink,Anchor,Flash,SelectAll,Select,Textarea,TextField,Radio,Checkbox,HiddenField,ImageButton,Button,Form,Replace,Language,CopyFormatting';

};
        
        
        
        
        

