<section class="section">
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Pengeluaran</h4>
      <a href="<?= base_url('home/t_pengeluaran') ?>" class="btn btn-primary">Tambah Pengeluaran</a>
        <span class="mdi mdi-cart-plus"></span>
      </a>
      <div class="table-responsive">
        <table class="table">

          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Kategori Pengeluaran</th>
              <th>Nama Pengeluaran</th>
              <th>Total Pengeluaran</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($yoga as $key) {
            ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $key->tanggal ?></td>
                <td><?= $key->kategori_pengeluaran ?></td>
                <td><?= $key->nama_pengeluaran ?></td>
                <td><?= $key->total_pengeluaran ?></td>

                <td>
                  <a href="<?= base_url('home/edit_pengeluaran/' . $key->id_pengeluaran) ?>">
                    <button class="btn btn-danger">
                      <i class="now-ui-icons ui-1_check"></i> Edit
                    </button>
                  </a>
                  <a href="<?= base_url('home/hapus_pengeluaran/' . $key->id_pengeluaran) ?>">
                    <button class="btn btn-danger">
                      <i class="now-ui-icons ui-1_check"></i> Delete
                    </button>
                  </a>
                
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</section>