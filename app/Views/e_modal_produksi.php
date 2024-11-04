<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Modal</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end"></nav>
            </div>
        </div>
    </div>

    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?= base_url('home/aksi_e_modal_produksi') ?>" method="POST">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="nama_menu">Nama Menu</label>
                                            <select class="form-control" id="id_menu" name="menu" required>
                                                <?php foreach ($menu as $item): ?>
                                                    <option value="<?= $item->id_menu ?>" 
                                                        <?= isset($satu->id_menu) && $satu->id_menu == $item->id_menu ? 'selected' : '' ?>>
                                                        <?= $item->nama_menu ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">Tanggal</label>
                                                <input type="date" id="tanggal" class="form-control" name="tanggal" value ="<?= $satu->tanggal ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi</label>
                                                <input type="text" id="deskripsi" class="form-control" name="deskripsi" value ="<?= $satu->deskripsi ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="satuan">Satuan</label>
                                                <input type="text" id="satuan" class="form-control" name="satuan" value ="<?= $satu->satuan ?>" >
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="jumlah">Jumlah</label>
                                                <input type="text" id="jumlah" class="form-control" name="jumlah" value ="<?= $satu->jumlah ?>" oninput="calculateTotal()">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="harga_satuan">Harga Satuan</label>
                                                <input type="text" id="harga_satuan" class="form-control" name="harga_satuan" value ="<?= $satu->harga_satuan ?>" oninput="calculateTotal()">
                                            </div>
                                        </div>

                                        <div class="col-12">
    <div class="form-group">
        <label for="total_bahan">Total Harga</label>
        <!-- Read-only display of formatted value for Total Harga -->
        <input type="text" id="total_bahan_display" class="form-control" 
               value="Rp. <?= number_format((float)str_replace(['Rp. ', '.'], '', $satu->total_bahan), 0, ',', '.') ?>" readonly>

        <!-- Hidden input to hold the actual numeric value -->
        <input type="hidden" id="total_bahan" name="total_bahan" 
               value="<?= str_replace(['Rp. ', '.'], '', $satu->total_bahan) ?>">
    </div>
</div>


                                        <input type="hidden" name="id_modal" value="<?= $satu->id_modal ?>">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript to calculate Total Harga -->
<!-- JavaScript to calculate Total Harga in Rupiah format -->
<script>
    function calculateTotal() {
        let hargaSatuan = parseFloat(document.getElementById('harga_satuan').value.replace(/\./g, '') || 0);
        let jumlah = parseFloat(document.getElementById('jumlah').value.replace(/\./g, '') || 0);

        let total = hargaSatuan * jumlah;

        let totalFormatted = "Rp. " + total.toLocaleString('id-ID', {
            minimumFractionDigits: 0
        });

        document.getElementById('total_bahan_display').value = totalFormatted;
        document.getElementById('total_bahan').value = totalFormatted; // Simpan nilai terformat
    }

    window.onload = function() {
        let initialHargaSatuan = parseFloat(document.getElementById('harga_satuan').value.replace(/\./g, '') || 0);
        let initialJumlah = parseFloat(document.getElementById('jumlah').value.replace(/\./g, '') || 0);
        
        if(initialHargaSatuan && initialJumlah) {
            calculateTotal();
        }
    };
</script>




