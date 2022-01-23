<x-app-layout>
    <x-slot name="header">
        {{ __('Kategori') }}
    </x-slot>

    <button class="btn btn-primary mb-3" onclick="focusCreate()" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Buat Baru
    </button>

    @include('category.modal-create')
    @include('category.modal-update')

    <div class="table-responsive">
        <table class="table table-striped datatable" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

    <x-slot name="js">
    <script>
        $('.datatable').DataTable({
            processing: true,
            search: {
                return: true
            },
            serverSide: true,
            ajax: "{{url('/api/categories')}}"
        });

        function saveCat()
        {
            $('.btn-save').html('Menyimpan...')
            $('.btn-save').prop('disabled', true)
            var form = new FormData($('#form-create')[0])
            fetch("{{url('/api/categories/create')}}",{
                method:'POST',
                headers:{
                    Accept:'application/json'
                },
                body:form
            })
            .then(res => res.json())
            .then(res => {
                $('.datatable').DataTable().ajax.reload();
                $('#form-create')[0].reset()
                $('#exampleModal').modal('hide')
                $('.btn-save').html('Submit')
                $('.btn-save').prop('disabled', false)
            })
            .catch(err => {
                console.log(err)
                $('.btn-save').html('Submit')
            })
        }

        function saveEditCat()
        {
            $('.btn-save').html('Menyimpan...')
            $('.btn-save').prop('disabled', true)
            var form = new FormData($('#form-update')[0])
            fetch("{{url('/api/categories/update')}}/"+$('input[name=id]').val(),{
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
            fetch("{{url('/api/categories')}}/"+cat_id)
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
                fetch("{{url('/api/categories/delete')}}/"+cat_id,{
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
                $('input[name=name]').focus()
            },500)
        }
    </script>
    </x-slot>
</x-app-layout>
