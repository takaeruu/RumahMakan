<section class="section">
                    <div class="row" id="basic-table">
                        <div class="col-12 col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Restore Edit RM Padang Payakumbuah</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <!-- Table with outer spacing -->
                                            <table class="table table-lg">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Kode Menu</th>
                                                        <th>Nama Menu</th>
                                                        <th>Harga</th>
                                                        <th>Stok</th>
                                                        <th>Action</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
            $no = 1;
            foreach ($oke as $key) {
            ?>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $key->kode_menu ?></td>
                <td><?= $key->nama_menu ?></td>
                <td><?= $key->harga_menu ?></td>
                <td><?= $key->stok ?></td>
            <td>
                <a href="<?= base_url('home/aksi_restore_edit_menu/' . $key->id_menu) ?>">
                    <button class="btn btn-secondary">
                      <i class="now-ui-icons ui-1_check"></i> Restore
                    </button>
                  </a>
                  <a href="<?= base_url('home/hapus_menu/' . $key->id_menu  ) ?>">
                    <button class="btn btn-danger">
                      <i class="now-ui-icons ui-1_check"></i> Delete
                    </button>
                  </a>
            </td>
        </tr>

                
            <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>