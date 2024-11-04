<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pengeluaran RM. H. Yoga Slamet</h4>
                </div>
                <div class="card-body">
                    <!-- Form Utama -->
                    <form method="POST" action="<?= base_url('home/aksi_t_pengeluaran') ?>" id="modalForm">

                        <div id="form-container">
                            <!-- Form Tambah Modal 1 (Form Pertama) -->
                            <div class="modal-form">
                                <div class="row align-items-center">
                                    <div class="col-md-4 mb-3">
                                        <label for="deskripsi">Tanggal:</label>
                                        <input type="date" class="form-control" name="tanggal" placeholder="Masukkan deskripsi modal" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
    <label for="kategori">Kategori:</label>
    <select class="form-control kategori" name="kategori" required>
        <option value="" disabled selected>Pilih Kategori</option>
        <option value="gaji_karyawan">gaji_karyawan</option>
        <option value="pengeluaran_lainnya">pengeluaran_lainnya</option>
    </select>
</div>

                                    <div class="col-md-2 mb-3">
                                        <label for="unit">Nama Pengeluaran:</label>
                                        <input type="text" class="form-control unit" name="nama_pengeluaran" placeholder="Masukkan Nama Pengeluaran" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="unit">Total Pengeluaran:</label>
                                        <input type="text" class="form-control unit" name="total_pengeluaran" placeholder="Total Pengeluaran" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success">Simpan Semua Modal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


