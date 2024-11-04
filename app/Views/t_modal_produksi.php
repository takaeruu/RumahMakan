<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Modal Produksi RM. H. Yoga Slamet</h4>
                </div>
                <div class="card-body">
                    <!-- Form Utama -->
                    <form method="POST" action="<?= base_url('home/aksi_t_modal_produksi') ?>" id="modalForm">

                        <div id="form-container">
                            <!-- Form Tambah Modal 1 (Form Pertama) -->
                            <div class="modal-form">
                                <div class="row align-items-center">
                                    <div class="col-md-4 mb-3">
                                        <label for="kategori">Pilih Kategori Modal:</label>
                                        <select class="form-control" id="kategori" name="kategori[]" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach ($kategori_menu as $kategori): ?>
                                                <option value="<?= $kategori->id_menu ?>"><?= $kategori->nama_menu ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-4 mb-3">
                                        <label for="deskripsi">Deskripsi Modal:</label>
                                        <input type="text" class="form-control" name="deskripsi[]" placeholder="Masukkan deskripsi modal" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="jumlah">Jumlah:</label>
                                        <input type="number" class="form-control jumlah" name="jumlah[]" placeholder="Masukkan jumlah" required oninput="calculateTotal(this)" min="0">
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="unit">Satuan:</label>
                                        <input type="text" class="form-control unit" name="unit[]" placeholder="kg, liter, dll" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="harga_satuan">Harga Satuan:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control harga-satuan" name="harga_satuan[]" placeholder="Masukkan harga satuan" required oninput="calculateTotal(this)" min="0">
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label for="total_bahan">Total Bahan:</label>
                                        <input type="text" class="form-control total-bahan" name="total_bahan[]" placeholder="Total Bahan" readonly>
                                    </div>

                                    <!-- Delete Button -->
                                    <div class="col-md-1 mb-3">
                                        <button type="button" class="btn btn-danger" onclick="removeForm(this)" title="Hapus Form" style="display: none;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button Tambah Form Modal Baru -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-info" id="addModalForm">Tambah Modal</button>
                            </div>
                        </div>

                        <!-- Button Simpan Semua Modal -->
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

<script>
    document.getElementById('addModalForm').addEventListener('click', function() {
    // Template form yang akan ditambahkan
    let newForm = `
        <div class="modal-form">
            <hr>
            <div class="row align-items-center">
                <div class="col-md-4 mb-3">
                    <label for="kategori">Pilih Kategori Modal:</label>
                    <select class="form-control" name="kategori[]" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori_menu as $kategori): ?>
                            <option value="<?= $kategori->id_menu ?>"><?= $kategori->nama_menu ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-4 mb-3">
                    <label for="deskripsi">Deskripsi Modal:</label>
                    <input type="text" class="form-control" name="deskripsi[]" placeholder="Masukkan deskripsi modal" required>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" class="form-control jumlah" name="jumlah[]" placeholder="Masukkan jumlah" required oninput="calculateTotal(this)" min="0">
                </div>

                <div class="col-md-2 mb-3">
                    <label for="unit">Satuan:</label>
                    <input type="text" class="form-control unit" name="unit[]" placeholder="kg, liter, dll" required>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="harga_satuan">Harga Satuan:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control harga-satuan" name="harga_satuan[]" placeholder="Masukkan harga satuan" required oninput="calculateTotal(this)" min="0">
                    </div>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="total_bahan">Total Bahan:</label>
                    <input type="text" class="form-control total-bahan" name="total_bahan[]" placeholder="Total Bahan" readonly>
                </div>

                <div class="col-md-1 mb-3">
                    <button type="button" class="btn btn-danger" onclick="removeForm(this)" title="Hapus Form">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('form-container').insertAdjacentHTML('beforeend', newForm);
});

    function calculateTotal(element) {
        // Get the parent form
        const parent = element.closest('.modal-form');
        
        // Get the values of jumlah and harga_satuan
        const jumlah = parseFloat(parent.querySelector('.jumlah').value) || 0;
        const hargaSatuan = parseFloat(parent.querySelector('.harga-satuan').value) || 0;
        
        // Calculate total
        const total = jumlah * hargaSatuan;
        
        // Format total as Rupiah
        const formattedTotal = formatCurrency(total);
        
        // Update total_bahan field
        parent.querySelector('.total-bahan').value = formattedTotal;
    }

    function formatCurrency(amount) {
        // Format number to currency (Rupiah)
        return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function removeForm(button) {
        // Get the parent form
        const form = button.closest('.modal-form');
        
        // Remove the entire form element from the DOM only if it's not the first form
        if (form !== document.querySelector('.modal-form:first-child')) {
            form.remove();
        }
    }
</script>

<!-- Custom CSS to enhance the layout -->
<style>
    .modal-form {
        margin-bottom: 20px; /* Add spacing between forms */
    }
</style>
