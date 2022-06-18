<div class="modal fade" id="modal-harga" tabindex="-1" role="dialog" aria-labelledby="modal-harga">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal" id="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">Isi ini jika harga produk atau pasar berubah</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="harga_beli" class="col-lg-2 col-lg-offset-1 control-label">Harga Beli Baru</label>
                        <div class="col-lg-6">
                            <input type="number" name="harga_beli" id="harga_beli" class="form-control" min="0"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_beli" class="col-lg-2 col-lg-offset-1 control-label">Harga Jual Baru</label>
                        <div class="col-lg-6">
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control" min="0"
                                required>
                        </div>
                    </div>
                    <input type="hidden" id="status" name="status" value="1">
                    <input type="hidden" id="id_pembelian" name="id_pembelian" value="{{ $id_pembelian }}">
                    <input type="hidden" id="jumlah" name="jumlah" value="">
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
