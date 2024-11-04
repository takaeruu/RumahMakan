/*
 Navicat Premium Data Transfer

 Source Server         : yoga
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : rumahmakan

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 28/10/2024 18:43:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bahan
-- ----------------------------
DROP TABLE IF EXISTS `bahan`;
CREATE TABLE `bahan`  (
  `id_bahan` int NOT NULL AUTO_INCREMENT,
  `nama_bahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_bahan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bahan
-- ----------------------------

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'nasi');
INSERT INTO `kategori` VALUES (2, 'mie');
INSERT INTO `kategori` VALUES (3, 'minum');

-- ----------------------------
-- Table structure for laporan_keuangan
-- ----------------------------
DROP TABLE IF EXISTS `laporan_keuangan`;
CREATE TABLE `laporan_keuangan`  (
  `id_laporan_keuangan` int NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NULL DEFAULT NULL,
  `total_bahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_penjualan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `beban` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `laba_bersih` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_laporan_keuangan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of laporan_keuangan
-- ----------------------------
INSERT INTO `laporan_keuangan` VALUES (1, '2024-10-28 00:00:00', '2635060', '30000', '1000000', '1605060');

-- ----------------------------
-- Table structure for laporan_pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `laporan_pengeluaran`;
CREATE TABLE `laporan_pengeluaran`  (
  `id_laporan_keuangan` int NOT NULL AUTO_INCREMENT,
  `id_modal` int NULL DEFAULT NULL,
  `id_penjualan_produk` int NULL DEFAULT NULL,
  `id_pengeluaran` int NULL DEFAULT NULL,
  `pendapatan_bersih` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_laporan_keuangan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of laporan_pengeluaran
-- ----------------------------

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `id_kategori` int NULL DEFAULT NULL,
  `kode_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `stok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT NULL,
  `create_by` int NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  `tanggal` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 1, 'M-001', 'Nasi Goreng ', '10.000', '5', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `menu` VALUES (2, 2, 'M-002', 'Mie Goreng', '20.000', '5', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `menu` VALUES (8, 2, 'M-003', 'Kwetiau Goreng', '50.000', '10', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `menu` VALUES (9, 3, 'M-004', 'Teh obeng', '5.000', '10', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `menu` VALUES (10, 3, 'M-005', 'Es Kosong', '20000', '20', NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for modal
-- ----------------------------
DROP TABLE IF EXISTS `modal`;
CREATE TABLE `modal`  (
  `id_modal` int NOT NULL AUTO_INCREMENT,
  `id_menu` int NULL DEFAULT NULL,
  `tanggal` datetime NULL DEFAULT NULL,
  `deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_bahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_modal`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of modal
-- ----------------------------
INSERT INTO `modal` VALUES (1, NULL, '2024-10-21 23:20:21', 'beras', '2', 'kg', '30.000', 'Rp 60.000');
INSERT INTO `modal` VALUES (2, 1, '2024-10-22 00:00:00', 'dada ayam', '3', 'kg', '30000', 'Rp 90.000');
INSERT INTO `modal` VALUES (3, 1, '2024-10-22 00:00:00', 'micin', '3', 'bungkus', '5000', 'Rp 15.000');
INSERT INTO `modal` VALUES (4, 1, '2024-10-22 00:00:00', 'bawang putih', '11', 'kg', '200000', 'Rp 2.200.000');
INSERT INTO `modal` VALUES (5, 2, '2024-10-22 00:00:00', 'mie', '3', 'kg', '70000', 'Rp 210.000');
INSERT INTO `modal` VALUES (6, 9, '2024-10-23 00:49:16', 'teh poci', '20', 'pcs', '4000', 'Rp 80.000');
INSERT INTO `modal` VALUES (7, 1, '2024-10-27 22:14:04', 'merica', '2', 'bungkus', '20000', 'Rp 40.000');

-- ----------------------------
-- Table structure for pemesanan
-- ----------------------------
DROP TABLE IF EXISTS `pemesanan`;
CREATE TABLE `pemesanan`  (
  `id_pemesanan` int NOT NULL AUTO_INCREMENT,
  `id_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_pelanggan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor_pemesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pemesanan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pemesanan
-- ----------------------------
INSERT INTO `pemesanan` VALUES (3, NULL, NULL, '67110ac3cf728', NULL);
INSERT INTO `pemesanan` VALUES (4, NULL, 'yoga', '67110bd182c31', NULL);
INSERT INTO `pemesanan` VALUES (5, NULL, 'asdad', '67110bd7c4390', NULL);
INSERT INTO `pemesanan` VALUES (6, '1', 'asda', '671123ec8fe6b', '1');
INSERT INTO `pemesanan` VALUES (7, '2', 'asda', '671123ec8fe6b', '1');
INSERT INTO `pemesanan` VALUES (8, '1', 'MANTAP JIWAAAAA', '671123f0984be', '1');
INSERT INTO `pemesanan` VALUES (9, '1', 'SIWA MATAP', '6711247a98c3d', '3');
INSERT INTO `pemesanan` VALUES (10, '2', 'SIWA MATAP', '6711247a98c3d', '2');
INSERT INTO `pemesanan` VALUES (11, '1', 'yoga ganteng', '67123d0cebbcb', '1');
INSERT INTO `pemesanan` VALUES (12, '2', 'yoga ganteng', '67123d0cebbcb', '1');
INSERT INTO `pemesanan` VALUES (13, '1', 'yoga ganteng', '67123d3b48807', '1');
INSERT INTO `pemesanan` VALUES (14, '2', 'yoga ganteng', '67123d3b48807', '1');
INSERT INTO `pemesanan` VALUES (15, '1', 'yogurt', '67123dcf3abfa', '1');
INSERT INTO `pemesanan` VALUES (16, '1', 'yoga ganteng', '67123fe5c6ecd', '1');
INSERT INTO `pemesanan` VALUES (17, '2', 'yoga ganteng', '67123fe5c6ecd', '1');
INSERT INTO `pemesanan` VALUES (18, '1', 'asd', '671241ba0decc', '1');
INSERT INTO `pemesanan` VALUES (19, '1', 'Yogawu', '671244db87a7b', '1');
INSERT INTO `pemesanan` VALUES (20, '2', 'Yogawu', '671244db87a7b', '1');
INSERT INTO `pemesanan` VALUES (21, '1', 'sadasd', '671245e74ec08', '1');
INSERT INTO `pemesanan` VALUES (22, '2', 'sadasd', '671245e74ec08', '1');
INSERT INTO `pemesanan` VALUES (23, '1', 'qweq', '671245fc5733a', '1');
INSERT INTO `pemesanan` VALUES (24, '2', 'qweq', '671245fc5733a', '1');
INSERT INTO `pemesanan` VALUES (25, '1', 'aasd', '6712463942393', '1');
INSERT INTO `pemesanan` VALUES (26, '2', 'aasd', '6712463942393', '1');
INSERT INTO `pemesanan` VALUES (27, '1', 'takawu', '67124a04bab92', '1');
INSERT INTO `pemesanan` VALUES (28, '2', 'takawu', '67124a04bab92', '2');
INSERT INTO `pemesanan` VALUES (29, '1', 'dorrin', '67150e7f8acdd', '1');
INSERT INTO `pemesanan` VALUES (30, '2', 'dorrin', '67150e7f8acdd', '1');
INSERT INTO `pemesanan` VALUES (31, '1', 'tinardo', '67151276ca87a', '2');
INSERT INTO `pemesanan` VALUES (32, '2', 'tinardo', '67151276ca87a', '1');
INSERT INTO `pemesanan` VALUES (33, '2', 'mantapujasw', '6715f0aceaf8f', '2');

-- ----------------------------
-- Table structure for pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE `pengeluaran`  (
  `id_pengeluaran` int NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NULL DEFAULT NULL,
  `kategori_pengeluaran` enum('gaji_karyawan','pengeluaran_lainnya') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_pengeluaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_pengeluaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengeluaran`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO `pengeluaran` VALUES (1, '2024-10-27 23:40:23', 'gaji_karyawan', 'gaji karyawan', 'Rp 1.000.000');

-- ----------------------------
-- Table structure for penjualan_produk
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_produk`;
CREATE TABLE `penjualan_produk`  (
  `id_penjualan_produk` int NOT NULL AUTO_INCREMENT,
  `id_menu` int NULL DEFAULT NULL,
  `tanggal` datetime NULL DEFAULT NULL,
  `jumlah_jual` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga_satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_penjualan_produk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_produk
-- ----------------------------
INSERT INTO `penjualan_produk` VALUES (1, 1, '2024-10-01 23:09:16', '1', '10000', 'Rp 10.000');
INSERT INTO `penjualan_produk` VALUES (2, 2, '2024-10-22 11:34:36', '2', '10000', 'Rp 20.000');

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting`  (
  `id_setting` int NOT NULL AUTO_INCREMENT,
  `nama_website` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `logo_website` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tab_icon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `login_icon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `create_by` int NULL DEFAULT NULL,
  `update_by` int NULL DEFAULT NULL,
  `deleted_by` int NULL DEFAULT NULL,
  `create_at` datetime NULL DEFAULT NULL,
  `update_at` datetime NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_setting`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO `setting` VALUES (1, 'RM. H. Yoga Slamet', '', '', '', NULL, 1, NULL, NULL, '2024-10-10 11:43:20', NULL);

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `nomor_pemesanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` datetime NULL DEFAULT NULL,
  `bayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kembalian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 62 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES (6, '67110954d7b67', '2024-10-17 07:55:51', '', '', '30000');
INSERT INTO `transaksi` VALUES (7, '6711097652d1d', '2024-10-17 07:56:26', '111111111', '111061111', '50000');
INSERT INTO `transaksi` VALUES (8, '671109f4f075e', '2024-10-17 07:58:41', '30000', '0', '30000');
INSERT INTO `transaksi` VALUES (9, '67110ac3cf728', '2024-10-17 08:02:01', '10000', '0', '10000');
INSERT INTO `transaksi` VALUES (10, '67110bd182c31', '2024-10-17 08:06:31', '', '', '');
INSERT INTO `transaksi` VALUES (11, '67110bd7c4390', '2024-10-17 08:06:35', '', '', '');
INSERT INTO `transaksi` VALUES (12, '67110c3b63875', '2024-10-17 08:08:20', '222222', '192222', '30000');
INSERT INTO `transaksi` VALUES (13, '67110c3b63875', '2024-10-17 08:08:41', '222222', '192222', '30000');
INSERT INTO `transaksi` VALUES (14, '67110c3b63875', '2024-10-17 08:09:17', '222222', '192222', '30000');
INSERT INTO `transaksi` VALUES (15, '67110c3b63875', '2024-10-17 08:09:20', '222222', '192222', '30000');
INSERT INTO `transaksi` VALUES (16, '67110c3b63875', '2024-10-17 08:10:45', '222222', '192222', '30000');
INSERT INTO `transaksi` VALUES (17, '67110c3b63875', '2024-10-17 08:12:29', '222222', '192222', '30000');
INSERT INTO `transaksi` VALUES (18, '67111255b050e', '2024-10-17 08:56:45', '11111', '-18889', '30000');
INSERT INTO `transaksi` VALUES (19, '67111d256c63b', '2024-10-17 09:20:30', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');
INSERT INTO `transaksi` VALUES (20, '67111fe25b9a5', '2024-10-17 09:32:10', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (21, '67111fe25b9a5', '2024-10-17 09:33:09', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (22, '671120260ed51', '2024-10-17 09:33:27', '', '', 'Rp 210.000');
INSERT INTO `transaksi` VALUES (23, '6711208cec23b', '2024-10-17 09:34:58', 'Rp 222.222', 'Rp 132.222', 'Rp 90.000');
INSERT INTO `transaksi` VALUES (24, '671120f4609c9', '2024-10-17 09:36:45', 'Rp 200.000', 'Rp 170.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (25, '671120f4609c9', '2024-10-17 09:37:05', 'Rp 200.000', 'Rp 170.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (26, '671121142c0d6', '2024-10-17 09:37:19', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (27, '671121891c638', '2024-10-17 09:39:12', 'Rp 40.000', 'Rp 10.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (28, '671121891c638', '2024-10-17 09:39:33', 'Rp 40.000', 'Rp 10.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (29, '671121a776f16', '2024-10-17 09:39:41', 'Rp 22.222', 'Rp -7.778', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (30, '671121a776f16', '2024-10-17 09:39:53', 'Rp 22.222', 'Rp -7.778', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (31, '671121baaae46', '2024-10-17 09:39:58', 'Rp 133.123', 'Rp 123.123', 'Rp 10.000');
INSERT INTO `transaksi` VALUES (32, '671121baaae46', '2024-10-17 09:40:08', 'Rp 133.123', 'Rp 123.123', 'Rp 10.000');
INSERT INTO `transaksi` VALUES (33, '671121ccebe4b', '2024-10-17 09:40:16', '', '', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (34, '6711222a7267d', '2024-10-17 09:41:51', 'Rp 40.000', 'Rp 10.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (35, '671122bd0d27e', '2024-10-17 09:44:15', '', '', 'Rp 10.000');
INSERT INTO `transaksi` VALUES (36, '6711235e0fb20', '2024-10-17 09:48:14', '', '', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (37, '6711235e0fb20', '2024-10-17 09:48:21', '', '', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (38, '6711235e0fb20', '2024-10-17 09:49:02', '', '', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (39, '6711235e0fb20', '2024-10-17 09:49:15', '', '', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (40, '671123ec8fe6b', '2024-10-17 09:49:20', 'Rp 222', 'Rp -29.778', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (41, '671123f0984be', '2024-10-17 09:50:08', 'Rp 100.000', 'Rp 50.000', 'Rp 50.000');
INSERT INTO `transaksi` VALUES (42, '6711247a98c3d', '2024-10-17 09:51:52', 'Rp 100.000', 'Rp 30.000', 'Rp 70.000');
INSERT INTO `transaksi` VALUES (43, '67123d0cebbcb', '2024-10-18 05:48:55', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (44, '67123d3b48807', '2024-10-18 05:49:45', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (45, '67123dcf3abfa', '2024-10-18 05:52:07', 'Rp 10.000', 'Rp 0', 'Rp 10.000');
INSERT INTO `transaksi` VALUES (46, '67123fe5c6ecd', '2024-10-18 06:00:59', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (47, '671241ba0decc', '2024-10-18 06:08:47', 'Rp 22.222', 'Rp 12.222', 'Rp 10.000');
INSERT INTO `transaksi` VALUES (48, '671244db87a7b', '2024-10-18 06:22:13', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (49, '671245e74ec08', '2024-10-18 06:26:38', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (50, '671245fc5733a', '2024-10-18 06:26:57', 'Rp 131.232', 'Rp 101.232', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (51, '6712463942393', '2024-10-18 06:27:55', '', '', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (52, '67124a04bab92', '2024-10-18 06:44:19', 'Rp 100.000', 'Rp 50.000', 'Rp 50.000');
INSERT INTO `transaksi` VALUES (53, '67150e7f8acdd', '2024-10-20 09:07:14', 'Rp 50.000', 'Rp 20.000', 'Rp 30.000');
INSERT INTO `transaksi` VALUES (54, '67151276ca87a', '2024-10-20 09:24:45', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');
INSERT INTO `transaksi` VALUES (55, '6715efe3450ec', '2024-10-21 01:08:48', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');
INSERT INTO `transaksi` VALUES (56, '6715efe3450ec', '2024-10-21 01:09:51', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');
INSERT INTO `transaksi` VALUES (57, '6715f0aceaf8f', '2024-10-21 01:12:05', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');
INSERT INTO `transaksi` VALUES (58, '6715f0aceaf8f', '2024-10-21 01:13:00', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');
INSERT INTO `transaksi` VALUES (59, '6715f0aceaf8f', '2024-10-21 01:13:33', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');
INSERT INTO `transaksi` VALUES (60, 'RMHYS-001', '2024-10-21 01:50:30', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');
INSERT INTO `transaksi` VALUES (61, '6715f9695f8e8', '2024-10-21 01:54:55', 'Rp 50.000', 'Rp 10.000', 'Rp 40.000');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('admin','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', 'admin@gmail.com', NULL, 'admin');

SET FOREIGN_KEY_CHECKS = 1;
