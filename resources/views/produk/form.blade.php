<div class="modal fade" id="modal-form" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal" id="form-horizontal">
            @csrf
            @method('post')
            <input type="hidden" name="id_stock" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                    <p class="text-danger" id="pesan"></p>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_produk" class="col-lg-2 col-lg-offset-1 control-label">Nama Produk</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" required
                                autofocus>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_kategori" class="col-md-2 col-md-offset-1 control-label">
                            Kategori
                        </label>
                        <div class="col-lg-4">
                            <select name="id_kategori" id="id_kategori" data-width="100%" class="form-control kategori"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="btn btn-warning btn-sm" id="kategoribaru" style="width: 100%;"><i
                                    class="fa fa-plus-square"></i> Kategori Baru</a>
                        </div>
                    </div>
                    <div class="form-group" id="formkategoribaru" style="display: none;">
                        <label for="id_merk" class="col-md-2 col-md-offset-1 control-label">
                            Tambah kategori baru
                        </label>

                        <div class="col-lg-2">
                            <input type="text" id="forminputkategoribaru" class="form-control" autofocus>
                            <span class="text-danger with-errors" style="display: none;" id="messagekategori"></span>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="btn btn-warning mt-2" id="submitkategoribaru" style="width: 100%;">
                                Kirim</a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="btn btn-danger mt-2" id="batalkanformkategoribaru" style="width: 100%;">
                                Tutup</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_merk" class="col-md-2 col-md-offset-1 control-label">
                            Merk
                        </label>
                        <div class="col-lg-4">
                            <select name="id_merk" id="id_merk" data-width="100%" class="form-control merk" required>
                                <option value="">Pilih Merk</option>
                                @foreach ($merk as $k => $itm)
                                    <option value="{{ $k }}">{{ $itm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="btn btn-warning btn-sm" id="merkbaru" style="width: 100%;"><i
                                    class="fa fa-plus-square"></i> Merk Baru</a>
                        </div>
                    </div>
                    <div class="form-group" id="formmerkbaru" style="display: none;">
                        <label for="id_merk" class="col-md-2 col-md-offset-1 control-label">
                            Tambah merk baru
                        </label>
                        <div class="col-lg-2">
                            <input type="text" id="forminputmerkbaru" class="form-control" autofocus>
                            <span class="text-danger with-errors" id="messagemerk"></span>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="btn btn-warning mt-2" id="submitmerkbaru" style="width: 100%;"> Kirim</a>
                        </div>
                        <div class="col-lg-2">
                            <a href="#" class="btn btn-danger mt-2" id="batalkanformmerkbaru" style="width: 100%;">
                                Tutup</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_beli" class="col-lg-2 col-lg-offset-1 control-label">Harga Beli</label>
                        <div class="col-lg-6">
                            <input type="number" name="harga_beli" id="harga_beli" class="form-control" min="0"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_jual" class="col-lg-2 col-lg-offset-1 control-label">Harga Jual</label>
                        <div class="col-lg-6">
                            <input type="number" name="harga_jual" id="harga_jual" min="0" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="form-group row" id="stockkontainer">

                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 text-center" id="stockbarukontainer">

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 text-center" id="statuskontainer">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="reset" class="btn btn-sm btn-flat btn-info"><i class="fa fa-window-restore"></i>
                        reset</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i
                            class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
