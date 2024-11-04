<div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Edit Menu</h3>
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
                    <form action="<?= base_url('home/aksi_e_menu')?>" method="POST">
                    <input type="hidden" name="id" value="<?= $yoga->id_menu ?>">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Nama Menu</label>
                                        <input type="text" id="password-vertical" class="form-control" name="namamenu" value="<?=$yoga->nama_menu ?>">
                                    </div>
                                </div>
                                <div class="form-group">
    <label for="email-id-vertical"> Kategori Menu</label>
    <select class="form-control" name="kategorimenu">
        <?php foreach ($yogurt as $item): ?>
            <option value="<?= $item->id_kategori ?>"
                <?= isset($yoga->id_kategori) && $item->id_kategori == $yoga->id_kategori ? 'selected' : '' ?>>
                <?= $item->nama_kategori ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="contact-info-vertical">Harga Menu</label>
                                        <input type="text" id="password-vertical" class="form-control" name="hargamenu" value="<?=$yoga->harga_menu?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="password-vertical">Stok</label>
                                        <input type="text" id="password-vertical" class="form-control" name="stokmenu" value="<?=$yoga->stok?>">
                                    </div>
                                </div>
                                
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit"
                                        class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset"
                                        class="btn btn-light-secondary me-1 mb-1">Reset</button>
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