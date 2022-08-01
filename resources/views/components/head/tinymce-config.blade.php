{{-- ## TinyMCE ##  --}}
<script src="https://cdn.tiny.cloud/1/{{env('TINY_API_KEY')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script> tinymce.init({
        selector: '#myTextarea2',
        height: 350,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic underline strikethrough forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'fontselect fontsizeselect formatselect | ' +
            'bullist numlist outdent indent | ' +
            'removeformat | help',
        toolbar_mode: 'sliding',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>
{{-- <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script> --}}
 {{-- ## CKEditor ##  --}}
 {{-- <script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/decoupled-document/ckeditor.js"></script> --}}
