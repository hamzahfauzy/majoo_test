<x-app-layout>
    <x-slot name="header">
        {{ __('Produk') }}
    </x-slot>

    <button class="btn btn-primary mb-3" onclick="focusCreate()" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Buat Baru
    </button>

    @include('product.modal-create')
    @include('product.modal-update')

    <div class="table-responsive">
        <table class="table table-striped datatable" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    <x-slot name="js">
    <script>
        var images = []
        $('.datatable').DataTable({
            processing: true,
            search: {
                return: true
            },
            serverSide: true,
            ajax: "{{url('/api/products')}}"
        });

        function saveCat()
        {
            var frm = $('#form-create')[0]
            if(!frm.checkValidity()){
                frm.reportValidity()
                return false;
            }

            if(ckeditor.getData() == '')
            {
                alert('Deskripsi Tidak Boleh Kosong')
                return false;
            }

            if(images.length == 0)
            {
                alert('Gambar Tidak Boleh Kosong')
                return false;
            }

            $('.btn-save').html('Menyimpan...')
            $('.btn-save').prop('disabled', true)
            var form = new FormData(frm)
            form.append('description',ckeditor.getData())
            for(idx in images)
                form.append('images[]',images[idx])
            fetch("{{url('/api/products/create')}}",{
                method:'POST',
                headers:{
                    Accept:'application/json'
                },
                body:form
            })
            .then(res => {
                if(res.ok)
                    return res.json()
                else
                    throw new Error('Something went wrong');
            })
            .then(res => {
                alert('Data Berhasil Disimpan')
                $('.datatable').DataTable().ajax.reload();
                $('#form-create')[0].reset()
                ckeditor.setData('')
                images = []
                $('#image-preview').html('')
                $('#exampleModal').modal('hide')
                $('.btn-save').html('Submit')
                $('.btn-save').prop('disabled', false)
            })
            .catch(err => {
                console.log(err)
                alert(err)
                $('.btn-save').html('Submit')
                $('.btn-save').prop('disabled', false)
            })
        }

        function saveEditCat()
        {
            $('.btn-save').html('Menyimpan...')
            $('.btn-save').prop('disabled', true)
            var form = new FormData($('#form-update')[0])
            fetch("{{url('/api/products/update')}}/"+$('input[name=id]').val(),{
                method:'POST',
                headers:{
                    Accept:'application/json'
                },
                body:form
            })
            .then(res => res.json())
            .then(res => {
                $('.datatable').DataTable().ajax.reload();
                $('#form-update')[0].reset()
                $('#modalUpdate').modal('hide')
                $('.btn-save').html('Submit')
                $('.btn-save').prop('disabled', false)
            })
            .catch(err => {
                console.log(err)
                $('.btn-save').html('Submit')
            })
        }

        function editCat(cat_id)
        {
            fetch("{{url('/api/products')}}/"+cat_id)
            .then(res => res.json())
            .then(res => {
                $('#modalUpdate').modal('show')
                $('input[name=id]').val(res.id)
                $('input[name=name]').val(res.name)
            })
            .catch(err => {
                console.log(err)
            })
        }

        function deleteCat(cat_id)
        {
            var c = confirm('Apakah anda yakin ingin menghapus data ini ?')
            if(c)
            {
                fetch("{{url('/api/products/delete')}}/"+cat_id,{
                    method:'POST',
                    headers:{
                        Accept:'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    $('.datatable').DataTable().ajax.reload();
                })
                .catch(err => {
                    console.log(err)
                })
            }
        }

        function focusCreate()
        {
            setTimeout( e => {
                // $('input[name=name]').focus()
                $('.select2').select2({
                    dropdownParent: $("#exampleModal")
                });
            },500)
        }

        function appendImage(event)
        {
            var files = event.target.files
            var form  = new FormData;
            for(i in files)
                form.append('files[]',files[i])
            var config = {
                onUploadProgress: function(progressEvent) {
                    var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    // $("div.progress > div.progress-bar").css({ "width": percentComplete + "%" })
                    $('#upload-progress').css({'width':percentCompleted+'%'})
                    $('#upload-progress').html(percentCompleted+'% Completed')
                    if(percentCompleted == 100)
                    {
                        $('#upload-progress').html('Upload Completed')
                        setTimeout(e => {
                            $('#upload-progress').css({'width':'0%'})
                            $('.progress').hide()
                        },2000)
                    }
                    // console.log(percentCompleted)
                }
            };
            $('.progress').show()
            axios.post('/api/images/upload', form, config)
            .then(res => {
                var imagePreview = $('#image-preview')
                var data = res.data
                for(index in data)
                {
                    images.push(data[index].id)
                    var el = '<div class="mx-4 mb-4"><img src="'+data[index].file_url+'" width="100px" height="100px" style="object-fit:cover;display:block"><button class="btn btn-danger w-100" onclick="hapusGambar(this, '+index+')">Hapus</button></div>'
                    imagePreview.append(el)                    
                }
            })
        }

        function hapusGambar(el, id)
        {
            $(el).parent().remove()
            images.splice(index,1)
        }
    </script>
    </x-slot>
</x-app-layout>
