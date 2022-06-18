@extends('layouts.master')
@section('title')
    Laporan Keuntungan <br> pada tanggal {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }} <br> {{ isset($messageproduk) ? 'produk '.$messageproduk->nama_produk : 'Semua Produk' }}
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Laporan Keuntungan Penjualan</li>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="updatePeriode()" class="btn btn-info btn-flat"><i
                            class="fa fa-plus-circle"></i> Filter periode dan produk</button>
                    <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir, $idproduk]) }}" target="_blank" class="btn btn-success btn-flat"><i
                            class="fa fa-file-excel-o"></i> Export PDF</a>
                </div>
                <div class="box-body table-responsive">
                        @csrf
                        <table id="tableku" class="table table-stiped table-bordered">
                            <thead>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Harga Jual</th>
                                <th>Harga Beli</th>
                                <th>Keuntungan</th>
                                <th>Jumlah</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
    <div class="kotakpesan">

    </div>
@endsection
@includeIf('laporan.form')
@push('scripts')
@if (empty("{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir, $idproduk]) }}"))
<script>
    location.href = "{{ route('laporan.index') }}";
</script>
@endif
<script src="{{ asset('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        let table;

        $(document).ready(function() {
            table = $('#tableku').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir, $idproduk]) }}",
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'produk'
                    },
                    {
                        data: 'harga_jual'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: 'keuntungan'
                    },
                    {
                        data: 'jumlah'
                    },
                ],
                dom: 'Brt',
                bSort: false,
                bPaginate: false
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });

        function updatePeriode() {
            $('#modal-form').modal('show');
        }


    </script>
@endpush
