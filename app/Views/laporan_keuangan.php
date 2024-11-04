<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total Biaya Produksi (Filter Tanggal)</h4>
                </div>
                
                <!-- Form untuk Filter Tanggal -->
                <form method="GET" action="<?= base_url('home/laporan_keuangan') ?>">
                    <div class="row m-2">
                        <!-- Filter Tanggal Awal -->
                        <div class="col-md-4">
                            <label for="tanggal_awal">Tanggal Awal:</label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control">
                        </div>

                        <!-- Filter Tanggal Akhir -->
                        <div class="col-md-4">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row m-2">
                        <div class="col-md-12">
                            <!-- Tombol Print Laporan -->
                            <button type="submit" formaction="<?= base_url('home/print_laporan_keuangan') ?>" class="btn btn-secondary me-2">PRINT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
