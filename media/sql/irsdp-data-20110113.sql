-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2011 at 09:53 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `irsdp_1`
--

--
-- Dumping data for table `cerita`
--

INSERT INTO `cerita` (`idcerita`, `idproj_flow`, `tgl_cerita`, `deskripsi`, `follow_up`, `idpic`, `idstatuskontrak`) VALUES
(1, 1, '2011-01-11', 'Step initialized.', 'PAS begin to check administrative requirement.', 1, 0),
(2, 2, '2011-01-11', 'Step initialized.', 'TAS begin to check technical requirement.', 3, 0),
(3, 3, '2011-01-11', 'Step initialized.', 'PAS begin to check administrative requirement.', 1, 0),
(4, 4, '2011-01-11', 'Step initialized.', 'TAS begin to check technical requirement.', 3, 0),
(5, 5, '2011-01-11', 'Step initialized.', 'PAS begin to check administrative requirement.', 1, 0),
(6, 6, '2011-01-11', 'Step initialized.', 'TAS begin to check technical requirement.', 3, 0),
(7, 0, '2011-01-11', 'Step initialized.', 'PAS begin to check administrative requirement.', 1, 1),
(8, 0, '2011-01-11', 'Step initialized.', 'TAS begin to check technical requirement.', 3, 2),
(9, 0, '2011-01-11', 'Step initialized.', 'Consultant begin to check requirement.', 4, 3);

--
-- Dumping data for table `daftar_ruas`
--

INSERT INTO `daftar_ruas` (`iddaftar_ruas`, `tag`, `label`) VALUES
(1, '110', 'Panjang Jalan'),
(2, '120', 'Lebar Jalan');

--
-- Dumping data for table `dokumen`
--


--
-- Dumping data for table `group`
--

INSERT INTO `group` (`idgroup`, `group`) VALUES
(1, 'pas'),
(2, 'admin'),
(3, 'tas'),
(4, 'konsultan');

--
-- Dumping data for table `isian_ruas`
--

INSERT INTO `isian_ruas` (`idisian_ruas`, `tag`, `value`, `proyek_id`) VALUES
(1, '110', '500 m3', 1),
(2, '120', '100 m3', 1);

--
-- Dumping data for table `jenis_dok`
--

INSERT INTO `jenis_dok` (`idjenis_dok`, `jenis_dok`, `idpeserta_tender`, `idproject_profile`, `idkeuangan`, `idstatus_project`, `iddokumen`, `tgl_upload`, `idoperator`, `nama_berkas`, `idkontrak_flow`, `idanggaran`) VALUES
(1, NULL, NULL, NULL, NULL, 1, NULL, '2011-01-11', 1, 'dokumen_proyek27.doc', 0, 0),
(2, NULL, NULL, NULL, NULL, NULL, NULL, '2011-01-11', 4, 'dokumen_proyek28.doc', 0, 1);

--
-- Dumping data for table `kontraktor`
--


--
-- Dumping data for table `kontrak_flow`
--

INSERT INTO `kontrak_flow` (`idkontrak_flow`, `idproj_flow`, `kegiatan`, `tgl_rencana`, `pic`, `status`, `idref_kontrak`) VALUES
(1, 3, '', '2011-01-15', 0, 'on going', 1);

--
-- Dumping data for table `kontrak_flow_status`
--

INSERT INTO `kontrak_flow_status` (`idkontrak_flow_status`, `idpic`, `idgroup`, `status`, `idkontrak_flow`) VALUES
(1, 1, 0, 'on going', 1),
(2, 3, 0, 'on going', 1),
(3, 4, 0, 'on going', 1);

--
-- Dumping data for table `permohonan`
--

INSERT INTO `permohonan` (`idpermohonan`, `idtermin_bayar`, `tgl_permohonan`, `nilai_permintaan_rupiah`, `nilai_permintaan_dollar`, `nilai_disetujui_rupiah`, `nilai_disetujui_dollar`, `eq_idr_usd`, `disetujui`, `total_disetujui_dollar`, `loan_adb_usd`, `grant_gov_usd`, `tgl_dikirim`, `tgl_disetujui`, `dibayarkan`) VALUES
(1, 1, '2011-01-11', 1000000.00, 500.00, 900000.00, 450.00, 0.00, 1, 0.00, 0.00, 0.00, '2011-01-12', '2011-01-15', '2011-01-16');

--
-- Dumping data for table `peserta_tender`
--

--
-- Dumping data for table `proj_flow`
--

INSERT INTO `proj_flow` (`idproj_flow`, `kegiatan`, `tgl_rencana`, `pic`, `status`, `idproject_profile`, `idref_status`) VALUES
(1, '', '2011-01-11', 0, 'done', 1, 1),
(2, '', '2011-01-08', 0, 'done', 1, 2),
(3, '', '2011-01-15', 0, 'on going', 1, 3);

--
-- Dumping data for table `proj_flow_status`
--

INSERT INTO `proj_flow_status` (`idproj_flow_status`, `idproj_flow`, `idpic`, `status`) VALUES
(1, 1, 1, 'done'),
(2, 1, 3, 'done'),
(3, 2, 1, 'done'),
(4, 2, 3, 'done'),
(5, 3, 1, 'on going'),
(6, 3, 3, 'on going');

--
-- Dumping data for table `ref_kegiatan`
--


--
-- Dumping data for table `ref_kontrak`
--

INSERT INTO `ref_kontrak` (`idref_kontrak`, `detil_status`, `next_step`) VALUES
(1, 'Kontrak Step #1', 2),
(2, 'Kontrak Step #2', 3),
(3, 'Kontrak Step #3', 0);

--
-- Dumping data for table `ref_required`
--


--
-- Dumping data for table `ref_status_kontrak`
--

INSERT INTO `ref_status_kontrak` (`idstatuskontrak`, `idkontrak_flow`, `tgl_mulai`, `tgl_akhir`, `status_akhir`, `tgl_diisi`, `tgl_revisi`, `idoperator`) VALUES
(1, 1, '2011-01-11', '2011-01-15', 'on going', '2011-01-11', '0000-00-00', 1),
(2, 1, '2011-01-11', '2011-01-15', 'on going', '2011-01-11', '0000-00-00', 3),
(3, 1, '2011-01-11', '2011-01-15', 'on going', '2011-01-11', '0000-00-00', 4);

--
-- Dumping data for table `ref_status_project_profile`
--

INSERT INTO `ref_status_project_profile` (`idstatusproject`, `idref_status`, `idproject_profile`, `tgl_mulai`, `tgl_akhir`, `status_akhir`, `tgl_diisi`, `tgl_revisi`, `idoperator`) VALUES
(1, 1, 0, '2011-01-11', '2011-01-11', 'done', '2011-01-11', NULL, 1),
(2, 1, 0, '2011-01-11', '2011-01-11', 'done', '2011-01-11', NULL, 3),
(3, 2, 0, '2011-01-11', '2011-01-08', 'done', '2011-01-11', NULL, 1),
(4, 2, 0, '2011-01-11', '2011-01-08', 'done', '2011-01-11', NULL, 3),
(5, 3, 0, '2011-01-11', '2011-01-15', 'on going', '2011-01-11', NULL, 1),
(6, 3, 0, '2011-01-11', '2011-01-15', 'on going', '2011-01-11', NULL, 3);

--
-- Dumping data for table `ref_status_proyek`
--

INSERT INTO `ref_status_proyek` (`id_status`, `nama_status`) VALUES
(11, 'Perencanaan Proyek Kerjasama'),
(21, 'Tender Konsultan PraFS (QCBS)'),
(22, 'Tender Konsultan PraFS (CQS)'),
(23, 'Project Preparation Stage 1'),
(24, 'Project Preparation Stage 2'),
(31, 'Tender Konsultan Transaksi (QCBS)'),
(32, 'Tender Konsultan Transaksi (CQS)'),
(34, 'Rencana Pengadaan Badan Usaha'),
(35, 'Pelaksanaan Pengadaan Badan Usaha'),
(36, 'Penandatanganan Kontrak Kerjasama'),
(41, 'Manajemen Pelaksanaan Proyek Kerjasama'),
(33, 'Prepare FBC');

--
-- Dumping data for table `ref_status_tahapan`
--

INSERT INTO `ref_status_tahapan` (`id_tahapan`, `nama_tahapan`) VALUES
(1, 'Perencanaan Proyek Kerjasama'),
(2, 'Penyiapan FS Proyek Kerjasama'),
(3, 'Transaksi Proyek Kerjasama'),
(4, 'Manajemen Pelaksanaan Proyek');

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`idtemplate`, `tag`, `idcategory`) VALUES
(1, '110', 1),
(2, '120', 1);

--
-- Dumping data for table `tender_data`
--


--
-- Dumping data for table `termin_bayar`
--

INSERT INTO `termin_bayar` (`idtermin_bayar`, `kontrakflow_id`, `nilai_rupiah`, `nilai_dollar`, `nilai_total_dollar`, `sumber`) VALUES
(1, 1, 2000000.00, 800.00, 1000.00, 'Loan'),
(2, 1, 1000000.00, 500.00, 750.00, 'Loan');



--
-- Dumping data for table `project_profile`
--

INSERT INTO `project_profile` (`idproject_profile`, `pin`, `nama`, `ppp_book_code`, `usulan_lpd`, `lokasi`, `bpsid_propinsi`, `id_kategori`, `id_loan`, `surat_lpd`, `appr_dprd`, `ppp_form`, `doc_fs`, `tgl_usulan`, `tgl_diisi`, `tgl_revisi`, `idoperator`, `last_idref_status`, `tipe_proyek`) VALUES
(1, 'A1-SP-01', 'Margagiri Ketapang Ferry Terminal', '', 'Ministry of Transportation', 'Ketapang City', '3', 1, NULL, 1, 0, 1, 0, '2011-01-01', '2011-01-11', NULL, 1, 0, 0),
(2, 'A2-WS-02', 'Tukad Unda Klungkung', '', 'Local Government Klungkung Distric', 'Klungkung', '17', 10, NULL, 0, 0, 0, 0, '2007-07-17', '2010-12-06', '2010-12-06', 1, 0, 0),
(3, 'A2-WM-143', 'Integrated Solid Waste Final Disposal and Treatment  Facility for Greater Bandung Area and Bogor ', '', 'Settlement and Housing Agency for West Java P', 'Bandung Area and Bogor and Depok Area  ', '12', 6, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(4, 'A2-WS-01', 'Bulk Water ', '', 'Local Government of Kota Bandung', 'Cimenteng', '12', 10, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(5, 'A2-WS-13', 'Potable Water Project Kab. Maros, South Sulawesi ', '', 'Local Government of Maros District', 'Maros', '25', 10, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(6, 'A2-WS-70', 'Improvement of Water Supply Provision, Kota Palu', '', 'Local Government of Kota Palu', 'Kota Palu', '27', 10, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(7, 'A2-WS-99', 'Development of Water Supply Management Installation and Piping Lamongan District', '', 'Local Government of Kota Serang', 'Lamongan', '15', 10, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(8, 'A2-WS-131', 'Development of Drinking Water Provision System, Kota Serang', '', 'Local Government of Kota Serang', 'Serang', '11', 10, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(9, 'A2-WM-38', 'IPLT ', '', 'BAPPEDA Kota Palembang', 'Palembang', '7', 6, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(10, 'A2-WS-194', 'IPAL', '', 'Local Government of Kota Cimahi', 'Cimahi', '12', 10, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(11, 'A1-RW-03', 'Airport Raillink project', '', 'Transportation Ministry', 'Manggarai-Soekarno Hatta', '13', 4, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(12, 'A2-BT-03', 'Terminal, Kota Bandung', '', 'Local Government of Kota Bandung', 'Gedebage Kota Bandung', '12', 2, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(13, 'A2-SP-14', 'Cruise Ship Terminal ', '', 'Local Government of Karang asem District', 'Tanah Ampo ', '17', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(14, 'A2-SP-21', 'Development of Cargo Terminal of Pekan Baru, Riau', '', 'Local Government of Kota Pekanbaru', 'Pekan Baru', '5', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(15, 'A2-SP-29', 'Development of Multimoda Karya Jaya Integrated Terminal', '', 'Local Government of Kota Palembang', 'Palembang', '7', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(16, 'A2-AP-04', 'West Java, Kertajati International Airport', '', 'Local Government of West Java Province', 'Kertajati', '15', 3, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(17, 'A2-SP-186', 'Kendal Regency Port', '', 'Local Government of Central Java', 'kendal', '14', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(18, 'A2-SP-95', 'Construction of Ferry Terminal, Lhokseumawe Regency', '', 'Local Government of Aceh', 'Lhokseumawe', '1', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(19, 'A2-SP-183', 'Logistic, Port, Industrial Park, Power Plant at Sorong Papua', '', 'Local Government of Papua', 'Sorong', '32', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(20, 'A2-OT-185', 'Integrated Transportation Connection', '', 'Local Government of Kota Bojonegoro', 'Bojonegara', '11', 2, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(21, 'A2-SP-177', 'Construction and development of Lupak Dalam Sea Port', '', 'Local Government of Central Kalimantan', 'Kapuas Regency', '22', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', '2010-12-10', 1, 0, 0),
(22, 'A2-SP-179', 'Development of Teluk Sigintung Sea Port Seruyan ', '', 'Local Government of Central Kalimantan', 'Seruyan Regency', '22', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(23, 'A2-AP-42', 'Development of Sultan Thaha Airport', '', 'Local Government of Jambi', 'Jambi', '4', 3, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(24, 'A2-OT-140', 'Consolidated Urban Re-Development Project', '', 'Local Government of  Banda Aceh', 'Banda Aceh', '1', 8, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(25, 'A2-MK-12', 'Malioboro Area Development', '', 'Local Government of Central Java', 'Jogjakarta', '16', 8, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(26, 'A1-EN-56', 'PLTU Central Java', '', 'PLN', 'Central Java', '14', 9, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(27, 'A2-WM-176', 'Waste to Energy', '', 'Local Government of Kota Bandung', 'Gedebage', '12', 9, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(28, 'A2-RW-184', 'Jakarta Monorail Project', '', 'Local Government of DKI Jakarta Province', 'Jakarta ', '1', 1, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(29, 'A1-TR-02', 'Technical Assistance for BPJT', '', 'Regulatory Agency for Highway', 'Highway development along Java Island by inte', '1', 5, NULL, 0, 0, 0, 0, '2010-12-10', '2010-12-10', NULL, 1, 0, 0),
(30, 'A2-OT-105', 'Banten Water  Front City', '', '', 'Banten Province', '36', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(31, 'A2-EN-189', 'Contruction of Interconnection Network for Under Water Cable System of Kalimantan - Java', '', '', 'Central Kalimantan Province - Java', '62', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(32, 'A2-MK-139', 'Construction of Modern Grocery Market', '', '', 'Kota Subulusalam, Kecamatan Simpang Kiri, NAD', '11', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(33, 'A2-OT-55', 'Construction of Warehouse Baggage Check Facility Infrastructure for Agriculture Sector', '', '', 'Kel. Siring Agung, Kec. Lubuklinggau Selatan ', '16', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(34, 'A2-WM-45', 'Construction of Liquid and Solid Waste Disposal Facility', '', '', 'Moen Geudong, Kec. Banda Sakti dan Alue Liem,', '11', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(35, 'A2-OT-44', 'Lhokseumawe City Ring Road', '', '', 'Kota Lhokseumawe', '11', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(36, 'A2-OT-37', 'Development of Integrated Area (Musi River, Palembang City)', '', '', 'Kec. Gandus; IT I dan IT II', '16', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(37, 'A2-RW-40', 'Railway Construction', '', '', 'Desa Tanjung Katung, Kecamatan Ma. Sebo, Kab/', '15', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(38, 'A2-SP-41', 'Construction of Coal Port at Ujung Jabung', '', '', 'Ujung Jabung, Kec. Nipah Panjang, Kota Tanjab', '15', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(39, 'A2-WS-48', 'Construction of Water Supply at 3 Cities', '', '', 'Sipirok, Batangtoru dan Batang Angkola, Tapan', '12', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(40, 'A2-OT-101', 'Sport Centre / Sport City', '', '', 'Kemanisan, Curug, Serang, Banten', '36', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(41, 'A2-OT-102', 'Construction of Agribussiness Terminal', '', '', 'Kasemen,Serang,Banten', '36', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(42, 'A2-OT-103', 'Construction of Integrated Transportation Connection at Bojonegara Area', '', '', 'Margasari, Sumuranja, Puloampel, Serang, Bant', '36', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(43, 'A1-SP-01a', 'Margagiri Ketapang Ferry Terminal', '', '', 'Ketapang City', '1', 1, NULL, 1, 0, 0, 0, NULL, '2010-12-05', NULL, 1, 0, 0),
(44, 'A1-TR-02a', 'Technical Assistance for BPJT', '', '', 'Highway development along Java Island by inte', '1', 5, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(45, 'A1-RW-03a', 'Airport Raillink project', '', '', 'Manggarai-Soekarno Hatta', '13', 4, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(46, 'A2-WS-01a', 'Bulk Water ', '', '', 'Cimenteng', '12', 10, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(47, 'A2-WS-02a', 'Tukad Unda Klungkung', '', '', 'Klungkung', '17', 10, NULL, 0, 0, 0, 0, NULL, '2010-12-06', '2010-12-06', 1, 0, 0),
(48, 'A2-BT-03a', 'Terminal, Kota Bandung', '', '', 'Gedebage Kota Bandung', '12', 2, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(49, 'A2-AP-04a', 'West Java, Kertajati International Airport', '', '', 'Kertajati', '15', 3, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(50, 'A2-MK-12a', 'Malioboro Area Development', '', '', 'Jogjakarta', '16', 8, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(51, 'A2-SP-14a', 'Cruise Ship Terminal ', '', '', 'Tanah Ampo ', '17', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(52, 'A2-SP-15', 'Tanjung Api-Api Seaport', '', '', 'South Sumatra Province', '16', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(53, 'A2-SP-16', 'Development of Bay Port in Tanjung Balai City & Bagan Asahan Port.', '', '', 'North Sumatra Province', '12', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(54, 'A2-RW-17', 'Construction of Railway Network for Kuala Namu Airport Medan-Kuala Namu Route (PT.RAILINK).', '', '', 'North Sumatra Province', '12', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(55, 'A2-OT-18', 'Flood Management System in Medan City and Surroundings.', '', '', 'North Sumatra Province', '12', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(56, 'A2-WM-19', 'Integrated Waste Management System', '', '', 'North Sumatra Province', '12', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(57, 'A2-AP-20', 'Development of Silangit Taput Airport', '', '', 'North Sumatra Province', '12', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(58, 'A2-SP-21a', 'Development of Cargo Terminal of Pekan Baru, Riau', '', '', 'Pekan Baru', '5', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(59, 'A2-WS-22', 'Development of Water Supply System', '', '', 'Palu City', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(60, 'A2-MK-23', 'Construction for Art and Handicraft Market of Small and Medium Enterprises', '', '', 'Sleman District', '34', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(61, 'A2-SP-24', 'Operating Water Bus and Construction of River Dock', '', '', 'Palembang City', '16', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(62, 'A2-RW-25', 'Construction of Palangkaraya Railway, 185 km', '', '', 'Central Borneo Province', '62', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(63, 'A2-MK-26', 'Construction of Multifunction Market in Pannampu.', '', '', 'Makassar City', '73', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(64, 'A2-MK-27', 'Renovation of PYesng Selasa, Tangga Buntung, and 10 Ulu Market', '', '', 'Palembang City', '16', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(65, 'A2-AP-28', 'Development of Remote Airport to Commodities Airport', '', '', 'Jember District', '35', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(66, 'A2-SP-29a', 'Development of Multimoda Karya Jaya Integrated Terminal', '', '', 'Palembang', '7', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(67, 'A2-MK-30', 'Development of Prambanan Market to Multi-function Market', '', '', 'Sleman Regency', '33', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(68, 'A2-WS-31', 'Development of Water Supply System in Bandung Area', '', '', 'Bandung Regency', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(69, 'A2-WS-32', 'Development of Watter Suply', '', '', 'Purwakarta District', '33', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(70, 'A2-OT-33', 'Mebidang Transportation System', '', '', 'North Sumatra Province', '12', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(71, 'A2-OT-34', 'Immitation Lake Tourism Area', '', '', 'Pekanbaru City', '', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(72, 'A2-OT-35', 'Construction of Tenayan Industrial Area', '', '', 'Pekanbaru City', '', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(73, 'A2-WM-38a', 'IPLT ', '', '', 'Palembang', '7', 6, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(74, 'A2-WM-39', 'Waste management', '', '', 'Palembang City', '16', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(75, 'A2-AP-42a', 'Development of Sultan Thaha Airport', '', '', 'Jambi', '4', 3, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(76, 'A2-SP-46', 'Construction of Sea Wall', '', '', 'Lhokseumawe City', '01', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(77, 'A2-WS-47', 'Construction of WTP and Pipe Connection for Water Supply Distribution', '', '', 'Lhokseumawe City', '01', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(78, 'A2-BT-49', 'Development of Trade center and Integrated Terminal of Sipirok City', '', '', 'South Tapanuli District', '71', 2, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(79, 'A2-EN-50', 'Conctruction of Sipotangniari water-based power generator (PLTA)', '', '', 'South Tapanuli District', '71', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(80, 'A2-EN-51', 'Construction of Muara Upu vapor-based power generator (PLTU) at Muara Batangtoru sub-district', '', '', 'South Tapanuli District', '12', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(81, 'A2-SP-52', 'Construction of Breakwater at Sungai Liat Trade Port', '', '', 'Bangka District', '', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(82, 'A2-OT-53', 'Procurement of Crane and Forklift at Sungai Liat Trade Portt', '', '', 'Bangka District', '', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(83, 'A2-OT-54', 'Development of Facility and Infrastructure for Rest Area at Type B Terminal', '', '', 'Lubuk Linggau City', '', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(84, 'A2-AP-56', 'Airport construction', '', '', 'TojoUna-Una District', '', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(85, 'A2-OT-57', 'Structuring and Organizing of Blockplan stall and kiosk at the bay coastline', '', '', 'Palu City', '71', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(86, 'A2-WS-58', 'Water Supply at Muara Tami District', '', '', 'Jayapura City', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(87, 'A2-OT-59', 'Jayapura City Walk (Revitalization for City center Area)', '', '', 'Jayapura City', '', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(88, 'A2-WM-60', 'Integrated waste management', '', '', 'Jayapura City', '', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(89, 'A2-WS-61', 'Procurement of facility and infrastructure for water supply', '', '', 'North Mamuju District', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(90, 'A2-EN-62', 'Advanced feasibility study (Creation of DED) for construction of PLTM at Sipin Village 5,7 MW, Kota ', '', '', 'Ogan Komering Ulu District', '', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(91, 'A2-EN-63', 'Advanced feasibility study (Creation of DED) for construction of PLTP at Marga Bayu Village, Ulu Pan', '', '', 'Ogan Komering Ulu District', '', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(92, 'A2-MK-65', 'Wadungsari Integrated market', '', '', 'Sidoarjo District', '35', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(93, 'A2-WM-67', 'Partnership in construction of sanitation and waste management', '', '', 'Sidoarjo District', '', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(94, 'A2-WS-68', 'Construction of Water supply instalation', '', '', 'Bontang City', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(95, 'A2-WS-70a', 'Improvement of Water Supply Provision, Kota Palu', '', '', 'Kota Palu', '27', 10, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(96, 'A2-WS-72', 'Water Supply', '', '', 'Sigi District', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(97, 'A2-EN-73', 'PLTA at Gumbara River', '', '', 'Sigi District', '', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(98, 'A2-WS-76', 'Development of Water Supply facility', '', '', 'Parigi Moutong District', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(99, 'A2-WS-78', 'Water Supply', '', '', 'Poso District', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(100, 'A2-AP-79', 'Airport expansion (1400 to 2000m)', '', '', 'Poso District', '', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(101, 'A2-AP-84', 'Construction of Airport', '', '', 'Banyuwangi District', '35', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(102, 'A2-WS-85', 'Water supply for insustrial and outer island', '', '', 'Banyuwangi District', '35', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(103, 'A2-OT-86', 'Sea transportation, Maritime Tourism Resort', '', '', 'Banyuwangi District', '35', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(104, 'A2-MK-87', 'Banyuwangi central market', '', '', 'Banyuwangi District', '35', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(105, 'A2-MK-88', 'Construction of loading and discharging market', '', '', 'Banyuwangi District', '35', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(106, 'A2-WS-90', 'Construction of new WTP using the SIPA 1000 ltr/sec from CisYesne River.', '', '', 'Tangerang City', '36', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(107, 'A2-SP-92', 'Construction of Tanjung Bulu Pandan Bangkalan Port', '', '', 'East Java Province', '35', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(108, 'A2-RW-93', 'Development of Gerbangkertosusila (GKS) Regional train transportation system', '', '', 'East Java Province', '35', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(109, 'A2-MK-94', 'Construction of  Trailu multi-function market', '', '', 'Mamuju District', '', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(110, 'A2-SP-95a', 'Construction of Ferry Terminal, Lhokseumawe Regency', '', '', 'Lhokseumawe', '1', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(111, 'A2-WS-96', 'Construction of Water Supply', '', '', 'Sorong District', '92', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(112, 'A2-MK-97', 'Market Construction', '', '', 'Sorong District', '92', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(113, 'A2-MK-98', 'Construction of Modern Market', '', '', 'Poso District', '72', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(114, 'A2-WS-99a', 'Development of Water Supply Management Installation and Piping Lamongan District', '', '', 'Lamongan', '15', 10, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(115, 'A2-MK-100', 'Construction of Blimbing Market', '', '', 'Lamongan District', '35', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(116, 'A2-AP-104', 'Construction of South Banten Airport', '', '', 'Banten Province', '36', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(117, 'A2-OT-106', 'Crossover bridge (Jembatan Penyeberangan) of  Tanjung Ayun-Tarjun (Pulau Laut-Pulau Kalimantan)', '', '', 'South Kalimantan Province', '63', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(118, 'A2-SP-107', 'Construction of ocean port at Datu Island, Tn.Laut', '', '', 'South Kalimantan Province', '63', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(119, 'A2-AP-108', 'Construction of Maluka Baulin Airport at Tanah Laut District', '', '', 'South Kalimantan Province', '63', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(120, 'A2-WM-109', 'Waste Management (TPS) at Rawa Kucing', '', '', 'Tangerang City', '36', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(121, 'A2-OT-110', 'Construction of rent-based apartment', '', '', 'Tangerang City', '36', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(122, 'A2-WM-111', 'Management of IPAL at Perumnas Karawaci', '', '', 'Tangerang City', '36', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(123, 'A2-OT-112', 'Development of new city center area at Tangerang', '', '', 'Tangerang City', '36', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(124, 'A2-WM-113', 'Construction of Regional waste management (TPA) at Bukitinggi City and Agam District', '', '', 'West Sumatra Province', '13', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(125, 'A2-OT-114', 'Revitalization and Development of Sports Hall Area', '', '', 'Bekasi City', '32', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(126, 'A2-BT-115', 'construction of integrated terminal atJati Mekar', '', '', 'Bekasi City', '32', 2, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(127, 'A2-WM-121', 'Waste management technology facility', '', '', 'Mimika District', '', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(128, 'A2-MK-127', 'Construction of central market', '', '', 'Balikpapan City', '64', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(129, 'A2-MK-128', 'Construction of Blambangan Market', '', '', 'Banyuwangi District', '35', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(130, 'A2-MK-129', 'Construction of Tabuhan Island Port', '', '', 'Banyuwangi District', '35', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(131, 'A2-WM-130', 'Construction of integrated wastewater disposal instalation (IPAL) for Fisheries industry Phase I', '', '', 'Banyuwangi District', '35', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(132, 'A2-WS-131a', 'Development of Drinking Water Provision System, Kota Serang', '', '', 'Serang', '11', 10, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(133, 'A2-WS-132', 'Construction and development of water supply', '', '', 'Pontianak District', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(134, 'A2-SP-133', 'Construction of Kuala Menpawah Port', '', '', 'Pontianak District', '', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(135, 'A2-OT-135', 'Construction and development of Road', '', '', 'Sorong District', '', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(136, 'A2-MK-136', 'Renovation of Central Market', '', '', 'Takalar District', '', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(137, 'A2-OT-137', 'Construction of South Coastline road at Bangka Island', '', '', 'Bangka Belitung Island Province', '', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(138, 'A2-OT-138', 'Procurement of Trans Jakarta Bas Provider for coridor 8, 9, and 10', '', '', 'DKI Jakarta Province', '31', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(139, 'A2-OT-140a', 'Consolidated Urban Re-Development Project', '', '', 'Banda Aceh', '1', 8, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(140, 'A2-WS-141', 'Construction of Water Treatment Plan (WTP) and water supply network installation.', '', '', 'Banten Province', '36', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(141, 'A2-WM-142', 'Procurement of facility and infrastructure for waste management.', '', '', 'Gianjar District', '', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(142, 'A2-WS-144', 'Development of Water supply after the landslide at Bawakaraeng', '', '', 'Makassar City', '', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(143, 'A2-OT-146', 'Construction of Graha Panca Karya', '', '', 'Maluku Province', '81', 7, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(144, 'A2-TR-147', 'Toll Road for Cilegon-Bojonegara-Merak', '', '', 'Banten Province', '36', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(145, 'A2-TR-148', 'Toll road for Serpong-Balaraja-Tangerang district', '', '', 'Banten Province', '36', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(146, 'A1-TR-44', 'Pekanbaru - Kandis - Dumai Toll Road', 'P-033-14-0', '', 'Riau Province', '14', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(147, 'A1-TR-45', 'Palembang - Indralaya Toll Road', 'P-033-14-0', '', 'South Sumatera Province', '16', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(148, 'A1-TR-46', 'Tegineneng - Babatan Toll Road', 'P-033-14-0', '', 'Lampung - South Sumatera Province', '16', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(149, 'A1-TR-47', 'Sukabumi - Ciranjang Toll Road', 'P-033-14-0', '', 'West Java Province', '32', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(150, 'A1-TR-48', 'Pasir Koja - Soreang Toll Road', 'P-033-14-0', '', 'South Bandung, West Java Province', '32', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(151, 'A1-TR-49', 'Pandan - Malang Toll Road', 'P-033-14-0', '', 'East Java Province', '35', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(152, 'A1-TR-50', 'Serangan - Tanjung Benoa Toll Road', 'P-033-14-0', '', 'Bali Province', '51', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(153, 'A1-TR-51', 'Manado - Bitung Toll Road', 'P-033-14-0', '', 'North Sulawesi Province', '71', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(154, 'A2-WS-169', 'Medan Municipal Water Supply', 'P-033-15-0', '', 'North Sumatera', '12', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(155, 'A2-WS-170', 'Bandar Lampung Municipal Water Supply', 'P-033-15-0', '', 'Bandar Lampung', '18', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(156, 'A1-WS-52', 'DKI Jakarta - Bekasi - Karawang Water Supply', 'P-033-15-0', '', 'DKI Jakarta - West Java Province', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(157, 'A2-WS-171', 'West Cikarang & Cibitung Bekasi Regency Water Supply', 'P-033-15-0', '', 'Bekasi', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(158, 'A2-WS-172', 'Bandung Regency Water Supply', 'P-033-15-0', '', 'Bandung', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(159, 'A2-WS-173', 'Sumedang Regency Water Supply', 'P-033-15-0', '', 'Sumedang', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(160, 'A2-WS-174', 'Indramayu Regency Water Supply', 'P-033-15-0', '', 'Indramayu', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(161, 'A2-WS-175', 'Cirebon Water Supply', 'P-033-15-0', '', 'Cirebon, West Java', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(162, 'A2-WM-143a', 'Integrated Solid Waste Final Disposal and Treatment  Facility for Greater Bandung Area and Bogor ', '', '', 'Bandung Area and Bogor and Depok Area  ', '12', 6, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(163, 'A1-TR-04', 'Kisaran - Tebing Tinggi Toll Road', 'P-033-14-0', '', 'Kisaran and Tebing Tinggi in North Sumatera P', '12', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(164, 'A1-TR-05', 'Bukit Tinggi - PYesng Panjang - Lubuk Alung - PYesng Toll Road', 'P-033-14-0', '', 'West Sumatera Province', '13', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(165, 'A1-TR-06', 'Batu Ampar - Muka Kuning - Bandara Hang Nadim Toll Road', 'P-033-14-0', '', 'Riau Archipelago Province', '14', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(166, 'A1-TR-07', 'Terbanggi Besar - Menggala - Pematang Panggang Toll Road', 'P-033-14-0', '', 'Lampung Province', '18', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(167, 'A1-TR-08', 'Bakauheni - Terbanggi Besar Toll Road', 'P-033-14-0', '', 'Lampung Province', '18', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(168, 'A1-TR-09', 'Cilegon - Bojonegara Toll Road', 'P-033-14-0', '', 'West Java and Central Java Province', '36', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(169, 'A1-TR-10', 'Kamal - Teluk Naga - Batu Ceper Toll Road', 'P-033-14-0', '', 'Banten Province', '36', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(170, 'A1-TR-11', 'Kemayoran - Kampung Melayu Toll Road', 'P-033-14-0', '', 'DKI Jakarta Province', '31', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(171, 'A1-TR-12', 'Sunter - Rawa Buaya - Batu Ceper Toll Road', 'P-033-14-0', '', 'DKI Jakarta Province', '31', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(172, 'A1-TR-13', 'Ulujami - Tanah Abang Toll Road', 'P-033-14-0', '', 'DKI Jakarta Province', '31', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(173, 'A1-TR-14', 'Pasar Minggu - Casablanca Toll Road', 'P-033-14-0', '', 'DKI Jakarta Province', '31', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(174, 'A1-TR-15', 'Sunter - Pulo Gebang - Tembelang Toll Road', 'P-033-14-0', '', 'DKI Jakarta Province', '31', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(175, 'A1-TR-16', 'Duri Pulo - Kampung Melayu Toll Road', 'P-033-14-0', '', 'DKI Jakarta Province', '31', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(176, 'A1-TR-17', 'Tanjung Priuk Access', 'P-033-14-0', '', 'DKI Jakarta Province', '31', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(177, 'A1-TR-18', 'Terusan Pasteur - Ujung Berung - Cileunyi Toll Road', 'P-033-14-0', '', 'Bandung, West Java Province', '32', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(178, 'A1-TR-19', 'Ujung Berung - Gedebage - Majalaya Toll Road', 'P-033-14-0', '', 'West Java Province', '32', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(179, 'A1-TR-20', 'Semarang - Demak Toll Road', 'P-033-14-0', '', 'Semarang - Demak in Central Java Province', '33', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(180, 'A1-TR-21', 'Yogyakarta - Bawen Toll Road', 'P-033-14-0', '', 'Yogyakarta Province', '34', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(181, 'A1-TR-22', 'Yogyakarta - Solo Toll Road', 'P-033-14-0', '', 'Yogyakarta and Solo in Centre Java', '34', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(182, 'A1-TR-23', 'Bandara Juanda - Tanjung Perak Toll Road', 'P-033-14-0', '', 'Surabaya Municipality, East Java Province', '35', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(183, 'A1-TR-24', 'Probolinggo - Banyuwangi Toll Road', 'P-033-14-0', '', 'East Java Province', '35', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(184, 'A1-AP-26', 'Sentani Airport', 'D-022-05-0', '', 'Jayapura, Papua Province', '92', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(185, 'A1-AP-27', 'Juwata Tarakan Airport', 'D-022-05-0', '', 'Tarakan Municipal, East Kalimantan Province', '64', 3, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(186, 'A1-SP-28', 'Bojonegara - Ketapang (Jawa - Sumatera ) Ferry Terminal', 'P-022-03-0', '', 'Serang Regancy in Banten Province and South L', '36', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(187, 'A1-SP-29', 'Bojonegara Port', 'P-022-04-0', '', 'Banten Province', '36', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(188, 'A2-SP-149', 'Expansion of Kumai Port, Kotawaringin Barat Regency', 'D-022-04-0', '', 'Central Kalimantan Province', '62', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(189, 'A2-SP-150', 'Development Lupak Dalam Port', 'D-022-04-0', '', 'Central Kalimantan Province', '62', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(190, 'A2-SP-151', 'Expansion of Teluk Sigintung Port', 'D-022-04-0', '', 'Seruyan Regency, Central Kalimantan Province', '62', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(191, 'A2-SP-152', 'Expansion of Anjir Kelampan and Anjir Serampan Canal', 'D-022-08-0', '', 'Central Kalimantan Province', '62', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(192, 'A1-RW-30', 'Kualanamu Airport Railway Development', 'D-022-08-0', '', 'North Sumatera Province', '12', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(193, 'A1-RW-31', 'West Sumatera Railway', 'D-022-08-0', '', 'West Sumatera Province', '13', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(194, 'A1-RW-32', 'Simpang - Tanjung Api-Api Railway', 'D-022-08-0', '', 'South Sumatera Province', '16', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(195, 'A1-RW-33', 'Tanjung Enim - Batu Raja Railway', 'D-022-08-0', '', 'South Sumatera Province', '16', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(196, 'A1-RW-34', 'Lahat - Kertapati Railway', 'D-022-08-0', '', 'South Sumatera Province', '16', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(197, 'A1-RW-35', 'Railway Facility - Blue and Green Line (Jakarta Monorail)', 'P-022-08-0', '', 'DKI Jakarta Province', '31', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(198, 'A2-RW-153', 'Gedebage, Bandung Munacipal, Integrated Terminal Railway', 'D-022-08-0', '', 'Gedebage, Bandung Munacipal', '32', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(199, 'A2-RW-154', 'Bangkuang - Lupak Dalam Railway', 'D-022-08-0', '', 'Central Kalimantan Province', '62', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(200, 'A2-RW-155', 'Kudangan - Kumai Railway', 'D-022-08-0', '', 'Central Kalimantan Province', '62', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(201, 'A2-RW-156', 'Puruk Cahu - Kuala Pembuang Railway', 'D-022-08-0', '', 'Central Kalimantan Province', '62', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(202, 'A2-RW-157', 'Tumbang Samba - Nanga Bulk Railway', 'D-022-08-0', '', 'Central Kalimantan Province', '62', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(203, 'A2-RW-158', 'Kuala Kurun - Palangkaraya - Pulang Pisau - Kuala Kapuas Railway', 'D-022-08-0', '', 'Central Kalimantan Province', '62', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(204, 'A1-RW-36', 'East Kalimantan Railway (Puruk Cahu - Balikpapan)', 'D-022-08-0', '', 'East Kalimantan Province', '64', 4, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(205, 'A2-WS-159', 'Pondok Gede, Bekasi Municipal, Water Supply', 'P-033-15-0', '', 'Pondok Gede, Jati Asih, Bekasi', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(206, 'A2-WS-160', 'Surakarta - Sukoharjo, Central Java Province Water Supply', 'P-033-15-0', '', 'Surakarta Municipal', '33', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(207, 'A2-WS-161', 'Klungkung Regency (Tukad Unda) Water Supply', 'P-033-15-0', '', 'Klungkung Regency, Bali Province', '51', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(208, 'A2-WS-13a', 'Potable Water Project Kab. Maros, South Sulawesi ', '', '', 'Maros', '25', 10, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(209, 'A2-WS-162', 'West Bandung (Alternative I) Water Conveyance', 'P-033-15-0', '', 'West Java, West Bandung District', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(210, 'A2-WS-163', 'West Bandung (Alternative II) Water Conveyance', 'P-033-15-0', '', 'West Java, West Bandung District', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(211, 'A2-WS-164', 'East Bandung (Alternative I) Water Conveyance', 'P-033-15-0', '', 'West Java, East Bandung District', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(212, 'A2-WS-165', 'East Bandung (Alternative II) Water Conveyance', 'P-033-15-0', '', 'West Java, East Bandung District', '32', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(213, 'A2-WS-166', 'Semarang (Alternative I) Water Conveyance', 'P-033-15-0', '', 'Central Java Province, Semarang District', '33', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(214, 'A2-WS-167', 'Semarang (Alternative II) Water Conveyance', 'P-033-15-0', '', 'Central Java Province, Semarang District', '33', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(215, 'A2-WS-168', 'Semarang (Alternative III) Water Conveyance', 'P-033-15-0', '', 'Central Java Province, Semarang District', '33', 10, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(216, 'A1-EN-37', 'New North Sumatera Coal Fired Steam Power Plant (2x200MW)', 'B-020-05-0', '', 'North Sumatera Province', '12', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(217, 'A1-EN-38', 'South Sulawesi New Coal Fired Steam Power Plant (200MW)', 'B-020-05-0', '', 'South Sulawesi Province', '73', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(218, 'A1-EN-39', 'North Sulawesi Coal Fired Steam Power Plant (2x55MW)', 'B-020-14-0', '', 'North Sulawesi Province', '71', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(219, 'A1-EN-40', 'North Sulawesi Coal Fired Steam Power Plant (55MW)', 'B-020-05-0', '', 'North Sulawesi Province', '71', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(220, 'A1-EN-41', 'North Sumatera (Infrastructure) 2X100 MW', 'B-020-05-0', '', 'North Sumatera Province', '12', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(221, 'A1-EN-42', 'Sumatera Mine Mouth HVDC Coal Fired Steam Power Plant (2x200MW)', 'B-020-05-0', '', 'South Sumatera Province', '16', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(222, 'A1-EN-43', 'East Kalimantan (Infrastructure)Coal Fired Steam Power Plant (2x65MW)', 'B-020-05-0', '', 'East Kalimantan Province', '64', 9, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(223, 'A1-TR-53', 'Medan - Binjai Toll Road', 'P-033-14-0', '', 'North Sumatra Province', '12', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(224, 'A1-TR-54', 'Medan - Kualanamu - Tebing Tinggi Toll Road', 'P-033-14-0', '', 'North Sumatra Province', '12', NULL, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(225, 'A1-TR-55', 'Cileunyi - Sumedang - Dawuan Toll Road', 'P-033-14-0', '', 'West  Java  Province', '32', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(226, 'A1-EN-56a', 'PLTU Central Java', '', '', 'Central Java', '14', 9, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(227, 'A2-SP-177a', 'Construction and development of Lupak Dalam Sea Port', '', '', 'Kapuas Regency', '22', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(228, 'A2-SP-178', 'Development of Kumai Sea Port, Kobar Regency.', '', '', 'Kobar Regency.', '62', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(229, 'A2-SP-179a', 'Development of Teluk Sigintung Sea Port Seruyan ', '', '', 'Seruyan Regency', '22', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(230, 'A2-SP-180', 'Development/dreging of Anjir Kelampan at Pulang Pisau 14 km, Kapuas Regency 28 km.', '', '', 'Kapuas Regency', '62', 1, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(231, 'A2-TR-181', 'Construction of Batam-Bintan Toll Bridge, 6,7 km.', '', '', 'Batam-Bintan', '21', 5, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(232, 'A2-MK-182', 'Construction of Modern Grocery Market.', '', '', 'Lubuklinggau City South Sumatera', '16', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(233, 'A2-SP-183a', 'Logistic, Port, Industrial Park, Power Plant at Sorong Papua', '', '', 'Sorong', '32', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(234, 'A2-RW-184a', 'Jakarta Monorail Project', '', '', 'Jakarta ', '1', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0),
(235, 'A2-OT-185a', 'Integrated Transportation Connection', '', '', 'Bojonegara', '11', 2, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(236, 'A2-SP-186a', 'Kendal Regency Port', '', '', 'kendal', '14', 1, NULL, 0, 0, 0, 0, NULL, '2010-12-10', '2010-12-10', 1, 0, 0),
(237, 'A2-BT-187', 'TerminalInduk desa Mpanau kec. Sigi Biromaru', '', '', 'Kabupaten Sigi', '72', 2, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(238, 'A2-MK-188', 'Pasar Induk Biromaru desa Mpanau kec. Sigi Biromaru', '', '', 'Kabupaten Sigi', '72', 8, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(239, 'A2-WM-66', 'Pengelolaan Sampah', '', '', 'Sidooarjo Regency', '35', 6, NULL, 0, 0, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(240, 'C1-AS-01', 'Procurement and Administrative Service (PAS)', '', '', NULL, '31', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(241, 'B1-AT-01', 'Technical Advisory Service (TAS)', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(242, 'B2-PD-03', 'PDF Policy Study', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(243, 'B3-SC-04', 'PPP Training at Washington DC', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(244, 'B3-SC-05', 'Self Managed Contract on Training International<br> Housing Finance  (Budi Hidayat and Kuswardono)', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(245, 'B3-EO-06', 'Event Organization for Sponsored Seminar ADB''s Annual Meeting 2009', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(246, 'B4-IC-08', 'Junior Legal Advisor 1 (Boy Aditya)', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(247, 'B4-IC-07', 'Executive Secretary (Kawik Sugiana)', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(248, 'B4-IC-09', 'Junior Legal Advisor 2 (Delano Dalo)', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(249, 'B4-IC-10', 'IT Specialist (Reko Kurniawan)', '', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, NULL, '2011-01-03', '2011-01-03', 1, 0, 1),
(250, 'A2-WM-176a', 'Waste to Energy', '', '', 'Gedebage', '12', 9, NULL, 0, 0, 0, 0, NULL, '2010-12-10', NULL, 1, 0, 0);


