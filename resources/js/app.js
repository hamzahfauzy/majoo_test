import Alpine from 'alpinejs';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    // require( '@ckeditor/ckeditor5-build-classic' )
    require('datatables.net-bs5');
    require('select2');
    window.axios = require('axios');
    window.Swal = require('sweetalert2')

    $('.select2').select2();


    window.Alpine = Alpine;
    window.ckeditor = null;
    ClassicEditor
    .create( document.querySelector( '#editor' ),{
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
        }
    } )
    .then( editor => {
        // console.log( editor );
        window.ckeditor = editor
    } )
    .catch( error => {
        console.error( error );
    } );

    Alpine.start();
} catch (e) {}