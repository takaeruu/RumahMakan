<?php $currentUri = uri_string(); ?>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <img src="<?= base_url('images/' . $yogi->logo_website) ?>" alt="logo" style="max-width: 150%; height: auto; max-height: 100px;"/>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <!-- Dashboard -->
                        <li class="sidebar-item <?= ($currentUri == 'home/dashboard') ? 'active' : '' ?>">
                            <a href="<?= base_url('home/dashboard') ?>" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Menu -->
                        <li class="sidebar-item <?= ($currentUri == 'home/makanan') ? 'active' : '' ?>">
                            <a href="<?= base_url('home/makanan') ?>" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Menu</span>
                            </a>
                        </li>

                        <!-- Pemesanan -->
                        <li class="sidebar-item <?= ($currentUri == 'home/pemesanan') ? 'active' : '' ?>">
                            <a href="<?= base_url('home/pemesanan') ?>" class='sidebar-link'>
                                <i class="bi bi-cash"></i>
                                <span>Pemesanan</span>
                            </a>
                        </li>

                        <!-- History Transaksi -->
                        <li class="sidebar-item <?= ($currentUri == 'home/histroy_transaksi') ? 'active' : '' ?>">
                            <a href="<?= base_url('home/histroy_transaksi') ?>" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>History Transaksi</span>
                            </a>
                        </li>

                        <!-- Modal - Submenu with multiple items -->
                        <li class="sidebar-item has-sub <?= (in_array($currentUri, ['home/modal_produksi', 'home/penjualan_produk', 'home/pengeluaran', 'home/laporan_keuangan'])) ? 'active' : '' ?>">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Modal</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item <?= ($currentUri == 'home/modal_produksi') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home/modal_produksi') ?>">Modal Produksi</a>
                                </li>
                                <li class="submenu-item <?= ($currentUri == 'home/penjualan_produk') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home/penjualan_produk') ?>">Penjualan Produk</a>
                                </li>
                                <li class="submenu-item <?= ($currentUri == 'home/pengeluaran') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home/pengeluaran') ?>">Pengeluaran</a>
                                </li>
                                <li class="submenu-item <?= ($currentUri == 'home/laporan_keuangan') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home/laporan_keuangan') ?>">Laporan Laba Rugi</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Settings -->
                        <li class="sidebar-item <?= ($currentUri == 'home/setting') ? 'active' : '' ?>">
                            <a href="<?= base_url('home/setting') ?>" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Settings</span>
                            </a>
                        </li>

                        <!-- Soft Delete -->
                        <li class="sidebar-item <?= ($currentUri == 'home/soft_delete') ? 'active' : '' ?>">
                            <a href="<?= base_url('home/soft_delete') ?>" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Soft Delete</span>
                            </a>
                        </li>

                        <!-- Restore Edit -->
                        <li class="sidebar-item <?= ($currentUri == 'home/restore_edit_menu') ? 'active' : '' ?>">
                            <a href="<?= base_url('home/restore_edit_menu') ?>" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Restore Edit</span>
                            </a>
                        </li>

                        <!-- Log Activity -->
                        <li class="sidebar-item <?= ($currentUri == 'home/log_activity') ? 'active' : '' ?>">
                            <a href="<?= base_url('home/log_activity') ?>" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Log Activity</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3"></header>
