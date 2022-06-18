@extends('layouts.master')
@section('title')
    Transaksi Penjualan
@endsection
@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input type="hidden" name="id_penjualan" id="id_penjualan"
                                        value="{{ $id_penjualan }}">
                                    <input type="hidden" name="id_produk" id="id_produk">
                                    @if (!empty($message))
                                    @else
                                        <span class="input-group-btn">
                                            <button onclick="tampilProduk()" class="btn btn-info btn-flat"
                                                type="button">Pilih
                                                Produk >>></button>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="message">
                            @if (!empty($message))
                                <div class="alert alert-success">
                                    Transaksi Berhasil anda bisa cetak nota atau membuat transaksi baru
                                    <a href="{{ route('transaksi.baru') }}" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i
                                            class="fa fa-floppy-o"></i> Transaksi Baru</a>
                                    @if ($setting->tipe_nota == 1)
                                        <button type="button" class="btn btn-warning btn-sm btn-flat pull-right"
                                            onclick="notaKecil('{{ route('transaksi.nota_besar') }}', 'Nota PDF')">Cetak
                                            Nota</button>
                                    @else
                                        <button type="button" class="btn btn-warning btn-sm btn-flat pull-right"
                                            onclick="notaBesar('{{ route('transaksi.nota_kecil') }}', 'Nota Kecil')">Cetak
                                            Nota</button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </form>
                    <div class="form-group"></div>
                    <table id="table-penjualan" class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Merk</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th width="15%">Jumlah</th>
                            <th>Subtotal</th>
                            <th width="15%"><i class="fa fa-cog"></i>Aksi</th>
                        </thead>
                        <tbody></tbody>
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
                            <form action="{{ route('transaksi.simpan') }}" class="form-transaksi" method="post">
                                @csrf
                                <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
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
                                        <input type="text" id="bayarrp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                    <div class="col-lg-8">
                                        <input type="number" id="diterima" class="form-control" name="diterima"
                                            value="{{ $penjualan->diterima ?? 0 }}" {{ !empty($message) ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="kembali" class="form-control" name="kembali" value="0"
                                            readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if (empty($message))
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i
                        class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@includeIf('penjualan_detail.produk')
@push('scripts')
    <script>
        let table;

        $(document).ready(function() {
            $('body').addClass('sidebar-collapse');

            table = $('#table-penjualan').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('transaksi.data', $id_penjualan) }}",
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
                            data: 'harga_jual'
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

            $('.table-produk').DataTable();

            $(document).on('change', '.quantity', function() {
                let id = $(this).data('id');
                let dataid = $(this).data('produk');
                let myproduk = parseInt($("#myproduk"+dataid).text());
                let jumlah = parseInt($("#quantity"+myproduk).val());
                let stock = parseInt($('#mystock'+myproduk).text());
                // console.log(jumlah);
                // if($(this).val() == ""){
                //     $(this).val(0).select();
                // }

                if (jumlah > stock) {
                    $("#stock").val(1);
                    $('#quantity').focus();
                    swal({
                        title: 'GAGAL !',
                        text: 'Stok produk kurang',
                        icon: 'warning',
                        timer: 2000,
                        showConfirmButton: true,
                        showCancelButton: false,
                    })
                    table.ajax.reload();
                    return;
                }

                if (jumlah < 1) {
                    $(this).val(1);
                    $('#quantity').focus();
                    swal({
                        title: 'GAGAL !',
                        text: 'Jumlah tidak boleh kurang dari satu',
                        icon: 'warning',
                        showConfirmButton: true,
                        showCancelButton: false,
                    })
                    return;
                }
                if (jumlah > 10000) {
                    $(this).val(10000);
                    $('#quantity').focus();
                    swal({
                        title: 'GAGAL !',
                        text: 'Jumlah tidak boleh lebih dari 10000',
                        icon: 'warning',
                        showConfirmButton: true,
                        showCancelButton: false,
                    })
                    return;
                }



                $.post(`{{ url('/transaksi') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'put',
                        'jumlah': jumlah
                    })
                    .done(response => {
                        table.ajax.reload();
                        $(this).focus();
                    })
            });

            $("#diterima").on('input', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                if ($(this).val() < 0) {
                    $(this).val(0);
                    $('#diterima').focus();
                    swal({
                        title: 'GAGAL !',
                        text: 'Uang diterima tidak boleh kosong',
                        icon: 'warning',
                        showConfirmButton: true,
                        showCancelButton: false,
                    })
                    return;
                }

                loadForm($(this).val());
            }).focus(function() {
                $(this).select();
            });

            $('.btn-simpan').on('click', function() {
                let jmltr = $('.myproduk').text();
                let diterima = $("#diterima").val();
                if(!jmltr)
                {
                    swal({
                        type: "warning",
                        icon: "warning",
                        title: "Ada Kesalahan!",
                        text: "Anda belum memilih satu produk sama sekali",
                        showConfirmButton: true,
                        showCancelButton: false,
                    });
                }
                else if(diterima == 0)
                {
                    swal({
                        title: 'GAGAL !',
                        text: 'Uang diterima Masih Kosong',
                        icon: 'warning',
                        showConfirmButton: true,
                        showCancelButton: false,
                    })
                    return;
                } else {
                    submit = $('.form-transaksi').submit();
                }
            });
        });

        function notaKecil(url, title) {
            popupCenter(url, title, 720, 675);
        }

        function notaBesar(url, title) {
            popupCenter(url, title, 720, 675);
        }

        function popupCenter(url, title, w, h) {
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;
            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                .documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;
            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
            scrollbars=yes,
            width  = ${w / systemZoom},
            height = ${h / systemZoom},
            top    = ${top},
            left   = ${left}
        `
            );
            if (window.focus) newWindow.focus();
        }

        function tampilProduk() {
            $('#modal-produk').modal('show');
        }

        function hideProduk() {
            $('#modal-produk').modal('hide');
        }

        function pilihProduk(id) {
            let myproduk = $('#myproduk'+id).text();
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
            $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
                .done(response => {
                    table.ajax.reload();
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        }

        function hideMember() {
            $('#modal-member').modal('hide');
        }

        function tampilMember() {
            $('#modal-member').modal('show');
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
                        url: "{{ route('transaksi.index') }}/" + id,
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

        function loadForm(diterima = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            var total = $('.total').text();

            $.get(`{{ url('/transaksi/loadform') }}/${total}/${diterima}`)
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.totalrp);
                    $('#bayarrp').val(response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Bayar: Rp. ' + response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang);

                    $('#kembali').val('Rp.' + response.kembalirp);
                    if ($('#diterima').val() != 0) {
                        $('.tampil-bayar').text('kembali: Rp. ' + response.kembalirp);
                        $('.tampil-terbilang').text(response.kembali_terbilang);
                    }
                })
                .fail(errors => {
                    return;
                })
        }
    </script>
@endpush
