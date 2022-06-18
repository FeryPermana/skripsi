@extends('layouts.master')
@section('title')
    Merk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Merk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('merk.store') }}')" class="btn btn-success btn-flat"><i
                            class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table id="tabel" class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Merk</th>
                            <th width="15%"><i class="fa fa-cog"></i>Aksi</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@includeIf('merk.form')
@push('scripts')
    <script>
        let table;

        $(document).ready(function() {
            table = $('#tabel').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('merk.data') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_merk'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $("#modal-form").validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            swal({
                                type: "success",
                                icon: "success",
                                title: "BERHASIL!",
                                text: response,
                                showConfirmButton: true,
                                showCancelButton: false,
                                buttons: false,
                            });
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            swal({
                                type: "warning",
                                icon: "error",
                                title: "Tidak dapat menyimpan data !",
                                text: "Data yang anda inputkan sudah ada",
                                showConfirmButton: true,
                                showCancelButton: false,
                            });
                            return;
                        })
                }
            })
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Merk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_merk]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').html('Edit Merk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_merk]').focus();
            // url show sama url update itu sama
            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama_merk]').val(response.nama_merk);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }

        function deleteData(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS MERK INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    //ajax delete
                    jQuery.ajax({
                        url: "{{ route('merk.index') }}/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'MERK BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            } else if (response.status == "notworking") {
                                swal({
                                    title: 'TIDAK BISA DIHAPUS!',
                                    text: 'ADA PRODUK YANG MEMAKAI MERK INI.!',
                                    icon: 'error',
                                    timer: false,
                                    showConfirmButton: true,
                                    showCancelButton: false,
                                    buttons: true,
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            } else {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'MERK GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            }
                        }
                    });
                } else {
                    return true;
                }
            })
        }
    </script>
@endpush
