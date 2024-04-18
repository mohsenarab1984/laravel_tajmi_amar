<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
   
    <link href="{{ asset('assets/css/vendor/bootstrap.min.css')}}"/>
    <script src="{{ asset('assets/js/vendor/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/popper.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> --}}

    {{-- import "../assets/js/vendor/jquery-3.4.1.min.js";
import "../assets/js/vendor/popper.js";
import "../assets/js/vendor/bootstrap.min.js"; --}}
</head>
<body>
    <div id="main">

        <textarea class="form-control" id="editor" rows="10" cols="5" style="height: 500px !important;"></textarea>
    </div>
    
        
        <button onclick="showContent()" class="btn btn-success">Send Content</button>
        <button onclick="getContentAndSend()">Send Content</button>
        <div id="view_output" style="border:1px solid #999; width:1000px; margin: 0 auto">

        </div>


        <script>
            ClassicEditor
            .create( document.querySelector( '#editor' ), {
                ckfinder: {
                    uploadUrl: '{{ route('editor.upload') . '?_token=' . csrf_token() }}',
                    options: {
                        resourceType: 'Images',
                        upload: {
                            fileName: 'photo' // Set the name of the uploaded file to 'photo'
                        }
                    }
                },
                language: {
                    content: 'ar'
                }
            })
            .then( createdEditor  => {
                editor = createdEditor;
                console.log( editor );
            })
            .catch( error => {
                console.error( error );
            })

            function showContent(){
                const editorContent = editor.getData();
                 $('#view_output').html(editorContent)
            }
    
            function getContentAndSend() {
                const editorContent = editor.getData();
                
                // Send the editor content using Axios
                
                axios.post('{{ route('admin.blog.create') }}', { content: editorContent })
                    .then(response => {
                        console.log('Content sent successfully', response.data);
                    })
                    .catch(error => {
                        console.error('Error sending content: ' + error.response);
                    });
            }
    
            </script>

    <style>
        .ck-editor__editable {
            height: 300px;
            
        }
        #main>div.ck-editor{
            width: 800px;
            margin: 10px auto;

        }
    </style>
    
</body>
</html>