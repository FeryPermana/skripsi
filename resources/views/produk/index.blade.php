@extends('layouts.master')
@section('title')
    Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">produk</li>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-flat"><i
                            class="fa fa-plus-circle"></i> Tambah</button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')"
                        class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                    <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info btn-flat"><i
                            class="fa fa-print"></i> Cetak Label</button>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-produk">
                        @csrf
                        <table class="table table-stiped table-bordered" id="table">
                            <thead>
                                <th width="5%">
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Kode Produk</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@includeIf('produk.form')
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let table;

        $(document).ready(function() {
            $('.merk').select2();
            $('.kategori').select2();
            table = $('#table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('produk.data') }}",
                },
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'kode_produk'
                    },
                    {
                        data: 'nama_kategori'
                    },
                    {
                        data: 'nama_merk'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'harga_jual'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $("#harga_beli").on("input", function() {
                let harga = $(this).val();
                if (harga < 0) {
                    swal({
                        type: "error",
                        icon: "error",
                        title: "Ada kesalahan",
                        text: "Inputan tidak boleh minus",
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                    $(this).val(0);
                }
            });

            $("#harga_jual").on("input", function() {
                let harga = $(this).val();
                if (harga < 0) {
                    swal({
                        type: "error",
                        icon: "error",
                        title: "Ada kesalahan",
                        text: "Inputan tidak boleh minus",
                        showConfirmButton: true,
                        showCancelButton: false
                    });
                    $(this).val(0);
                }
            });

            $("#stock").on("input", function() {
                let harga = $(this).val();
                if (harga < 0) {
                    swal({
                        type: "error",
                        icon: "error",
                        title: "Ada kesalahan",
                        text: "Inputan tidak boleh minus",
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                    $(this).val(0);
                }
            });

            $("#merkbaru").on("click", function() {
                $("#formmerkbaru").removeAttr("style");
                $("#pesan").removeAttr("style");
            });

            $("#kategoribaru").on("click", function() {
                $("#formkategoribaru").removeAttr("style");
            });

            $("#batalkanformmerkbaru").on("click", function() {
                $("#formmerkbaru").attr("style", "display: none;");
                $("#messagemerk").attr("style", "display: none;");
            });

            $("#batalkanformkategoribaru").on("click", function() {
                $("#formkategoribaru").attr("style", "display: none;");
                $("#messagekategori").attr("style", "display: none;");
            });

            $("#submitmerkbaru").click(function() {
                let inputbaru = $("#forminputmerkbaru").val();

                if (inputbaru) {
                    $.ajax({
                        url: "{{ route('merk.store') }}",
                        type: "POST",
                        data: {
                            nama_merk: inputbaru,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            swal({
                                type: "success",
                                icon: "success",
                                title: "BERHASIL!",
                                text: "Merek berhasil disimpan",
                                timer: 1500,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            });
                            $("#forminputmerkbaru").val("");
                            $("#id_merk").append(
                                `<option value=${response.id_merk}>${response.nama_merk}</option>`
                            );
                        },
                        error: function(error) {
                            swal({
                                type: "warning",
                                icon: "error",
                                title: "Tidak dapat menyimpan data !",
                                text: "Data merk produk yang anda inputkan sudah ada",
                                showConfirmButton: true,
                                showCancelButton: false,
                            });
                        }
                    });
                } else {
                    $("#messagemerk").text("Please fill out this filed");
                    $("#messagemerk").removeAttr("style");
                }
            });

            $("#submitkategoribaru").click(function() {
                let inputbaru = $("#forminputkategoribaru").val();

                if (inputbaru) {
                    $.ajax({
                        url: "{{ route('kategori.store') }}",
                        type: "POST",
                        data: {
                            nama_kategori: inputbaru,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            swal({
                                type: "success",
                                icon: "success",
                                title: "BERHASIL!",
                                text: "Kategori berhasil disimpan",
                                timer: 1500,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            });
                            console.log(response);
                            $("#forminputkategoribaru").val("");
                            $("#id_kategori").append(
                                `<option value=${response.id_kategori}>${response.nama_kategori}</option>`
                            );
                        },
                        error: function(error) {
                            swal({
                                type: "warning",
                                icon: "error",
                                title: "Tidak dapat menyimpan data !",
                                text: "Data kategori produk yang anda inputkan sudah ada",
                                showConfirmButton: true,
                                showCancelButton: false,
                            });
                        }
                    });
                } else {
                    $("#messagekategori").text("Please fill out this filed");
                    $("#messagekategori").removeAttr("style");
                }
            });

            $("#modal-form").validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            console.log(response);
                            if (response.berhasil) {
                                swal({
                                    type: "success",
                                    icon: "success",
                                    title: "BERHASIL!",
                                    text: response.berhasil,
                                    timer: 1500,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                });
                                $('#modal-form').modal('hide');
                                table.ajax.reload();
                            } else {
                                swal({
                                    type: "warning",
                                    icon: "error",
                                    title: "Tidak dapat menyimpan data !",
                                    text: response.gagal,
                                    showConfirmButton: true,
                                    showCancelButton: false,
                                });
                                return;
                            }
                        })
                        .fail((errors) => {
                            swal({
                                type: "warning",
                                icon: "error",
                                title: "Tidak dapat menyimpan data !",
                                text: "Data nama produk yang anda inputkan sudah ada",
                                showConfirmButton: true,
                                showCancelButton: false,
                            });
                            return;
                        })
                }
            });

            $('[name=select_all]').on('click', function() {
                $(':checkbox').prop('checked', this.checked);
            });
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form #save').text('Simpan');
            $('#modal-form .modal-title').text('Tambah Produk');
            $('#pesan').text(``);

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_produk]').focus();
            $("#statuskontainer").html(``);
            $("#stockbarukontainer").html(``);
            $('.stk').text('Stock');
            $("#stockkontainer").html(`<label for="stock" class="col-lg-2 col-lg-offset-1 control-label stk">Stok</label>
                                                    <div class="col-lg-6">
                                                        <input type="number" name="stock" id="stock" class="form-control" min="0" value=""
                                                            required>
                                                    </div>`);
        }


        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Produk');
            $('#pesan').text(`Jika anda sudah menginputkan harga terbaru dan stock baru maka yang keluar adalah harga dan stock yang baru`);
            $('#modal-form #save').text('Update');
            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_produk]').focus();

            // url show sama url update itu sama
            $.get(url)
                .done((response) => {
                    if (response.stock) {
                        $('#modal-form [name=nama_produk]').val(response.stock.produk.nama_produk);
                        $('#modal-form [name=id_kategori]').val(response.stock.produk.id_kategori);
                        $('#modal-form [name=id_merk]').val(response.stock.produk.id_merk);
                        $('#modal-form [name=id_stock]').val(response.stock.id_stock);
                        $('#modal-form [name=harga_beli]').val(response.stock.harga_beli);
                        $('#modal-form [name=harga_jual]').val(response.stock.harga_jual);
                        $('#stocklama').remove();
                        $("#statuskontainer").html(``);
                        $("#stockkontainer").html(``);
                        $("#stockbarukontainer").html(`<div class="form-group row">
                                <label for="stock" class="col-lg-2 col-lg-offset-1 control-label">Stok harga Baru</label>
                                <div class="col-lg-3">
                                    <input type="number" name="stock" id="stock" class="form-control" min="0" value="${response.stock.stock}"
                                        required>
                                </div>
                                <div class="col-lg-3">
                                    Stok lama  &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp; ${response.stocklama} <br>
                                    Total stock  &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp; ${response.totalstock}
                                </div>
                            </div>`);
                    }
                    if (response.produk) {
                        $('#modal-form [name=nama_produk]').val(response.produk.produk.nama_produk);
                        $('#modal-form [name=id_kategori]').val(response.produk.produk.id_kategori);
                        $('#modal-form [name=id_merk]').val(response.produk.produk.id_merk);
                        $('#modal-form [name=id_stock]').val(response.produk.id_stock);
                        $('#modal-form [name=harga_beli]').val(response.produk.harga_beli);
                        $('#modal-form [name=harga_jual]').val(response.produk.harga_jual);
                        $('#modal-form [name=stock]').val(response.produk.stock);
                        $("#stockkontainer").html(`<label for="stock" class="col-lg-2 col-lg-offset-1 control-label stk">Stok</label>
                                                    <div class="col-lg-6">
                                                        <input type="number" name="stock" id="stock" class="form-control" min="0" value="${response.produk.stock}"
                                                            required>
                                                    </div>`);
                        $("#statuskontainer").html(``);
                        $('.stk').text('Stock Lama');
                        $("#statuskontainer").html(` <div class="icheck-primary d-inline">
                                <input type="checkbox" id="status" name="status" value="1">
                                <label for="status">
                                    Harga Pasar Berubah
                                    <p class="text-danger">Jika ingin menginputkan harga dan stok baru centak di kiri ini</p>
                                </label>
                            </div>`);
                        $("#stockbarukontainer").html(``);
                        $('.stk').text('Stock');
                    }

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
                text: "INGIN MENGHAPUS PRODUK INI!",
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
                        url: "{{ route('produk.index') }}/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'PRODUK BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            } else {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'PRODUK GAGAL DIHAPUS!',
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

        function deleteSelected(url) {
            if ($('input:checked').length > 1) {
                swal({
                    title: "APAKAH KAMU YAKIN ?",
                    text: "INGIN MENGHAPUS PRODUK INI!",
                    icon: "warning",
                    buttons: [
                        'TIDAK',
                        'YA'
                    ],
                    dangerMode: true,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        $.post(url, $('.form-produk').serialize())
                            .done((response) => {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'PRODUK BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            })
                            .fail((errors) => {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'PRODUK GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                })
                                return;
                            });
                    }
                })
            } else {
                swal({
                    title: 'GAGAL!',
                    text: 'PILIH DATA LEBIH DARI SATU!',
                    icon: 'error',
                    showConfirmButton: true,
                    showCancelButton: false,
                })
                return;
            }
        }

        function cetakBarcode(url) {
            if ($('input:checked').length < 1) {
                swal({
                    title: 'GAGAL!',
                    text: ' PILIH DATA YANG AKAN DICETAK!',
                    icon: 'error',
                    showConfirmButton: true,
                    showCancelButton: false,
                })
                return;
            } else if ($('input:checked').length < 3) {
                swal({
                    title: 'GAGAL!',
                    text: ' PILIH MINIMAL 3 DATA YANG AKAN DICETAK!',
                    icon: 'error',
                    showConfirmButton: true,
                    showCancelButton: false,
                })
                return;
            } else {
                $('.form-produk')
                    .attr('target', '_blank')
                    .attr('action', url)
                    .submit();
            }
        }
    </script>
@endpush
