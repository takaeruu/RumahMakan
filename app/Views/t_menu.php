<div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Tambah Menu</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                
                            </nav>
                        </div>
                    </div>
                </div>

<section id="basic-vertical-layouts">
<div class="row match-height">
    <div class="col-md-6 col-12">
        <div class="card">
                                
            <div class="card-content">
                <div class="card-body">
                    <form action="<?= base_url('home/aksi_t_menu')?>" method="POST">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Nama Menu</label>
                                        <input type="text" id="password-vertical" class="form-control" name="namamenu" placeholder="Masukkan Nama Menu">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical"> Kategori Menu</label>
                                        <select class="form-control" name="kategorimenu">
                                            <option value="">Pilih</option>
                                            <?php foreach ($yoga as $item): ?>
                                                <option value="<?= $item->id_kategori ?>"><?= $item->nama_kategori ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="contact-info-vertical">Harga Menu</label>
                                        <input type="text" id="password-vertical" class="form-control" name="hargamenu" placeholder="Masukkan Harga Menu">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="password-vertical">Stok</label>
                                        <input type="text" id="password-vertical" class="form-control" name="stokmenu" placeholder="Masukkan Stok Menu">
                                    </div>
                                </div>
                                
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit"
                                        class="btn btn-primary me-1 mb-1">Submit</button>
                                   
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                        
</div></section>
                <!-- // Basic Vertical form layout section end -->


                <!-- // Basic multiple Column Form section start -->
                
                <!-- // Basic multiple Column Form section end -->
            </div>