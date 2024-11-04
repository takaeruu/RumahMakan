<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">History Transaksi RM H. Yoga Slamet</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <!-- Form Filter Tanggal -->
                        <form method="GET" action="">
                            <div class="form-group row">
                                <label for="start_date" class="col-sm-2 col-form-label">Tanggal Awal:</label>
                                <div class="col-sm-4">
                                    <input type="date" id="start_date" name="start_date" class="form-control" 
                                           value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>" 
                                           onchange="filterTanggal()">
                                </div>
                                <label for="end_date" class="col-sm-2 col-form-label">Tanggal Akhir:</label>
                                <div class="col-sm-4">
                                    <input type="date" id="end_date" name="end_date" class="form-control" 
                                           value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>" 
                                           onchange="filterTanggal()">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 offset-sm-2">
                                    <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <table class="table table-lg">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nomor Pemesanan</th>
                                    <th>Tanggal</th>
                                    <th>Bayar</th>
                                    <th>Kembalian</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Hitung nomor urut berdasarkan halaman
                                $no = ($page - 1) * $limit + 1; 
                                foreach ($oke as $key) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $key->nomor_pemesanan ?></td>
                                    <td><?= $key->tanggal ?></td>
                                    <td><?= $key->bayar ?></td>
                                    <td><?= $key->kembalian ?></td>
                                    <td><?= $key->total ?></td>
                                    <td>
                                        <!-- Tambahkan aksi yang sesuai di sini -->
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item <?= ($page == 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $page - 1; ?>&start_date=<?= isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>&end_date=<?= isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" onclick="event.preventDefault(); changePage(<?= $page - 1; ?>);">Previous</a>
                                </li>
                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                    <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?= $i; ?>&start_date=<?= isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>&end_date=<?= isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" onclick="event.preventDefault(); changePage(<?= $i; ?>);"><?= $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= ($page == $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $page + 1; ?>&start_date=<?= isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>&end_date=<?= isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" onclick="event.preventDefault(); changePage(<?= $page + 1; ?>);">Next</a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .fade {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    .fade.show {
        opacity: 1;
    }
</style>

<script>
function filterTanggal() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    // Membangun URL dengan parameter GET
    const params = new URLSearchParams();
    if (startDate) params.append('start_date', startDate);
    if (endDate) params.append('end_date', endDate);

    // Mengalihkan ke URL dengan parameter baru
    window.location.search = params.toString();
}

function changePage(page) {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    // Membangun URL dengan parameter GET
    const params = new URLSearchParams();
    if (startDate) params.append('start_date', startDate);
    if (endDate) params.append('end_date', endDate);
    params.append('page', page); // Tambahkan parameter halaman

    // Mengalihkan ke URL dengan parameter baru
    window.location.search = params.toString();
}

function clearFilters() {
    // Menghapus nilai input tanggal
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';

    // Mengalihkan ke URL tanpa filter
    window.location.search = '';
}

// Menambahkan event listener untuk transisi pada page load
document.addEventListener("DOMContentLoaded", function() {
    document.body.classList.add('fade');
    setTimeout(() => {
        document.body.classList.add('show');
    }, 50); // Waktu singkat untuk memicu animasi
});
</script>
