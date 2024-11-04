<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Biaya Produksi RM. H. Yoga Slamet</h4>
                    <a href="<?= base_url('home/t_modal_produksi') ?>" class="btn btn-primary">Tambah Modal Produksi</a>
                </div>

                <!-- Form untuk filter kategori menu dan tanggal -->
                <form method="GET" action="<?= base_url('home/modal_produksi') ?>">
    <div class="row m-2">
        <div class="col-md-3">
            <select name="id_menu" class="form-control" onchange="this.form.submit()">
                <option value="">-- Pilih Kategori Menu --</option>
                <?php foreach ($kategori_menu as $kategori): ?>
                    <option value="<?= $kategori->id_menu ?>" <?= isset($_GET['id_menu']) && $_GET['id_menu'] == $kategori->id_menu ? 'selected' : '' ?>>
                        <?= $kategori->nama_menu ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="bulan" class="form-control" onchange="this.form.submit()">
                <option value="">-- Pilih Bulan --</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $month = date('F', mktime(0, 0, 0, $i, 1));
                    echo "<option value='{$i}' " . (isset($_GET['bulan']) && $_GET['bulan'] == $i ? 'selected' : '') . ">{$month}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="tahun" class="form-control" onchange="this.form.submit()">
                <option value="">-- Pilih Tahun --</option>
                <?php
                $currentYear = date('Y');
                for ($year = $currentYear; $year >= $currentYear - 5; $year--): ?>
                    <option value="<?= $year ?>" <?= isset($_GET['tahun']) && $_GET['tahun'] == $year ? 'selected' : '' ?>>
                        <?= $year ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="col-md-3">
            <a class="btn btn-info" href="<?= base_url('home/modal_produksi') ?>">Reset Filter</a>
        </div>
    </div>
</form>


                <!-- Tabel Data Modal -->
                <div class="card-content">
                    <div class="card-body">
                        <table class="table table-lg">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Produksi</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (!empty($oke)) {
                                    foreach ($oke as $key) {
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $key->nama_menu ?></td>
                                        <td><?= $key->tanggal ?></td>
                                        <td><?= $key->deskripsi ?></td>
                                        <td><?= $key->satuan ?></td>
                                        <td><?= $key->jumlah ?></td>
                                        <td><?= $key->harga_satuan ?></td>
                                        <td><?= $key->total_bahan ?></td>
                                        <td>
                                        <a href="<?= base_url('home/edit_modal_produksi/'.$key->id_modal) ?>">
				<button class="btn btn-primary" >Edit</button>
			</a>

            <a href="<?= base_url('home/hapus_modal_produksi/'.$key->id_modal) ?>">
				<button class="btn btn-danger" >Delete</button>
			</a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="text-center">Data tidak ditemukan.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>