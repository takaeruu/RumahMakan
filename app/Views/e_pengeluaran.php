<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Pengeluaran RM. H. Yoga Slamet</h4>
                </div>
                <div class="card-body">
                    <!-- Form Utama -->
                    <form method="POST" action="<?= base_url('home/aksi_e_pengeluaran') ?>" id="modalForm">

                        <div id="form-container">
                            <!-- Form Tambah Modal 1 (Form Pertama) -->
                            <div class="modal-form">
                                <div class="row align-items-center">
                                    <div class="col-md-4 mb-3">
                                        <label for="deskripsi">Tanggal:</label>
                                        <input type="date" class="form-control" name="tanggal" placeholder="Masukkan deskripsi modal" value ="<?= $satu->tanggal ?>">
                                    </div>

                                    <div class="col-md-2 mb-3">
    <label for="kategori">Kategori:</label>
    <select class="form-control kategori" name="kategori" required>
        <option value="" disabled>Pilih Kategori</option>
        <option value="gaji_karyawan" <?= $satu->kategori_pengeluaran == 'gaji_karyawan' ? 'selected' : '' ?>>Gaji Karyawan</option>
        <option value="pengeluaran_lainnya" <?= $satu->kategori_pengeluaran == 'pengeluaran_lainnya' ? 'selected' : '' ?>>Pengeluaran Lainnya</option>
    </select>
</div>


                                    <div class="col-md-2 mb-3">
                                        <label for="unit">Nama Pengeluaran:</label>
                                        <input type="text" class="form-control unit" name="nama_pengeluaran" placeholder="Masukkan Nama Pengeluaran" value ="<?= $satu->nama_pengeluaran ?>">
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="unit">Total Pengeluaran:</label>
                                        <input type="text" class="form-control unit" name="total_pengeluaran" placeholder="Total Pengeluaran" value ="<?= $satu->total_pengeluaran ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                            <input type="hidden" name="id" value="<?= $satu->id_pengeluaran ?>">
                                <button type="submit" class="btn btn-success">Simpan Semua Modal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


