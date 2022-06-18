<div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Produk</h4>
            </div>
            <div class="modal-body">
                <table class="table table-stiped table-bordered table-produk">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Merk</th>
                        <th>Stock</th>
                        <th>Kode</th>
                        <th>Harga Jual</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        @foreach ($produk as $key => $item)
                            @php
                                $cek = App\Models\Stock::where('id_produk', $item->id_produk)->first();
                            @endphp
                            @if ($cek->stock != '0')
                                <tr>
                                    <td width="5%">{{ $key + 1 }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->nama_merk }}</td>
                                    <?php
                                    $stock = App\Models\Stock::where('id_produk', $item->id_produk)
                                        ->where('status', '0')
                                        ->first();
                                    $stockbaru = App\Models\Stock::where('id_produk', $item->id_produk)
                                        ->where('status', '1')
                                        ->first();
                                    $totalstock = App\Models\Stock::where('id_produk', $item->id_produk)
                                        ->get()
                                        ->sum('stock');
                                    ?>
                                    <td>{{ $totalstock }}</td>
                                    <td><span class="label label-success">{{ $item->kode_produk }}</span></td>
                                    <td>{{ isset($stockbaru) ? $stockbaru->harga_jual : $stock->harga_jual }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-xs btn-flat"
                                            onclick="pilihProduk('{{ $item->id_produk }}', '{{ $item->kode_produk }}')">
                                            <i class="fa fa-check-circle"></i>
                                            Pilih
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </form>
    </div>
</div>
