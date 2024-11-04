<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Penjualan Produk</h3>
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
                            <form action="<?= base_url('home/aksi_e_penjualan_produk') ?>" method="POST">
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
        <label for="jumlah_jual">Jumlah Jual</label>
        <input type="text" id="jumlah_jual" class="form-control" name="jumlah_jual" value="<?= $satu->jumlah_jual ?>" oninput="calculateTotal()">
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
        <label for="total">Total</label>
        <!-- Read-only display of formatted value for Total Harga -->
        <input type="text" id="total_display" class="form-control" 
               value="Rp. <?= number_format((float)str_replace(['Rp. ', '.'], '', $satu->total), 0, ',', '.') ?>" readonly>

        <!-- Hidden input to hold the actual numeric value -->
        <input type="hidden" id="total" name="total" 
               value="<?= str_replace(['Rp. ', '.'], '', $satu->total) ?>">
    </div>
</div>


                                        <input type="hidden" name="id_penjualan_produk" value="<?= $satu->id_penjualan_produk ?>">
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
        let jumlah = parseFloat(document.getElementById('jumlah_jual').value.replace(/\./g, '') || 0);

        let total = hargaSatuan * jumlah;

        let totalFormatted = "Rp. " + total.toLocaleString('id-ID', {
            minimumFractionDigits: 0
        });

        document.getElementById('total_display').value = totalFormatted;
        document.getElementById('total').value = totalFormatted; // Simpan nilai terformat
    }

    window.onload = function() {
        let hargaSatuan = document.getElementById('harga_satuan');
        let jumlahJual = document.getElementById('jumlah_jual');
        
        // Format harga satuan saat halaman dimuat
        hargaSatuan.value = parseFloat(hargaSatuan.value).toLocaleString('id-ID');
        
        // Hitung total saat halaman dimuat
        calculateTotal();
        
        // Tambahkan event listener untuk input
        hargaSatuan.addEventListener('input', calculateTotal);
        jumlahJual.addEventListener('input', calculateTotal);
    };
</script>




