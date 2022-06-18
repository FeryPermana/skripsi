@extends('layouts.master')
@section('title')
    Transaksi Pembelian
@endsection
@section('breadcrumb')
    @parent
    <li class="active">Transaksi Pembelian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <table>
                        <tr>
                            <td>Supplier</td>
                            <td>: {{ $supplier->nama }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $supplier->alamat }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>: {{ $supplier->telepon }}</td>
                        </tr>
                    </table>
                </div>
                <div class="box-body table-responsive">
                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input type="hidden" name="id_pembelian" id="id_pembelian"
                                        value="{{ $id_pembelian }}">
                                    <input type="hidden" name="id_produk" id="id_produk">
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button">Pilih
                                        Produk >>></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-group"></div>
                    <table id="table" class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Merk</th>
                            <th>Stock</th>
                            <th>Harga</th>
                            <th width="15%">Jumlah</th>
                            <th>Subtotal</th>
                            <th width="15%"><i class="fa fa-cog"></i>Aksi</th>
                        </thead>
                        <tbody id="pembelianddetail"></tbody>
                    </table>
                    <div class="row">
                        <style>
                            .tampil-bayar {
                                font-size: 5em;
                                text-align: center;
                                height: 100px;
                                z-index: 2;
                            }

                            .tampil-terbilang {
                                padding: 10px;
                                background: #f0f0f0;
                            }

                            .table-pembelian tbody tr:last-child {
                                display: none;
                            }

                            @media(max-width: 768px) {
                                .tampil-bayar {
                                    font-size: 3em;
                                    height: 70px;
                                    padding-top: 5px;
                                }
                            }

                        </style>
                        <div class="col-lg-8">
                            <div class="tampil-bayar bg-primary"></div>
                            <div class="tampil-terbilang"></div>
                        </div>
                        <div class="col-lg-4">
                            <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                                @csrf
                                <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">
                                <div class="form-group row">
                                    <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="totalrp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="bayarrp" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i
                            class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@includeIf('pembelian_detail.produk')
@includeIf('pembelian_detail.modalharga')
@push('scripts')
    <script>
        $('body').addClass('sidebar-collapse');

        let table, table2;

        $(document).ready(function() {
            table = $('#table').DataTable({
                    processing: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('pembelian_detail.data', $id_pembelian) }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: 'nama_produk'
                        },
                        {
                            data: 'id_merk'
                        },
                        {
                            data: 'stock'
                        },
                        {
                            data: 'harga_beli'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'subtotal'
                        },
                        {
                            data: 'aksi',
                            searchable: false,
                            sortable: false
                        },
                    ],
                    dom: 'Brt',
                    bSort: false,
                    paginate: false
                })
                .on('draw.dt', function() {
                    loadForm();
                    setTimeout(() => {
                        $('#diterima').trigger('input');
                    }, 3000);
                });
            table2 = $('#table-produk').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('pembelian_detail.dataproduk') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'nama_merk'
                    },
                    {
                        data: 'kode_produk'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
            $(document).on('change', '#harga_berubah', function() {
                if ($(this).prop("checked") == true) {
                } else if ($(this).prop("checked") == false) {
                    console.log("Checkbox is unchecked.");
                }
            });

            $(document).on('change', '.quantity', function() {
                let id = $(this).data('id');
                let dataid = $(this).data('produk');
                let myproduk = parseInt($("#myproduk" + dataid).text());
                let jumlah = parseInt($("#quantity" + myproduk).val());
                let stock = parseInt($('#mystock' + myproduk).text());

                // if($(this).val() == ""){
                //     $(this).val(0).select();
                // }
                if (jumlah < 1) {
                    $(this).val(1);
                    $('#quantity').focus();
                    swal({
                        type: "warning",
                        icon: "warning",
                        title: "GAGAL !",
                        text: "Jumlah tidak boleh kurang dari satu",
                        showConfirmButton: true,
                        showCancelButton: false,
                    });

                    return;
                }
                if (jumlah > 10000) {
                    $(this).val(10000);
                    $('#quantity').focus();
                    swal({
                        type: "warning",
                        icon: "warning",
                        title: "GAGAL !",
                        text: "Jumlah tidak boleh lebih dari 10000",
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                    return;
                }



                $.post(`{{ url('/pembelian_detail') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'put',
                        'jumlah': jumlah
                    })
                    .done(response => {
                        table.ajax.reload();
                        $(this).focus();
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    })
            });

            $('.btn-simpan').on('click', function() {
                let jmltr = $('.myproduk').text();
                if (jmltr) {
                    $('.form-pembelian').submit();
                } else {
                    swal({
                        type: "warning",
                        icon: "warning",
                        title: "Ada Kesalahan!",
                        text: "Anda belum memilih satu produk sama sekali",
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                }
            });
        });

        function tampilProduk() {
            $('#modal-produk').modal('show');
        }

        function hideProduk() {
            $('#modal-produk').modal('hide');
        }

        function ubahHarga(url) {
            $('#modal-harga').modal('show');
            $('#modal-harga form').attr('action', url);
            $('#modal-harga [name=_method]').val('post');
        }

        function pilihProduk(id) {
            let myproduk = $('#myproduk' + id).text();
            $('#id_produk').val(id);
            if (myproduk == id) {
                swal({
                    title: 'GAGAL !',
                    text: 'Produk sudah ada di tabel transaksi',
                    icon: 'warning',
                    showConfirmButton: true,
                    showCancelButton: false,
                })
                return;
            } else {
                hideProduk();
                tambahProduk();
            }
        }

        function tambahProduk() {
            $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
                .done(response => {
                    table.ajax.reload();
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
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
                        url: "{{ route('pembelian_detail.index') }}/" + id,
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

        function loadForm() {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            var total = $('.total').text();
            $.get(`{{ url('/pembelian_detail/loadform') }}/${total}`)
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.totalrp);
                    $('#bayarrp').val(response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Rp. ' + response.bayarrp);
                    $('.tampil-terbilang').text('Rp. ' + response.terbilang);
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                })
        }
    </script>
@endpush
