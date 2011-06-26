-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2011 at 09:46 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `irsdp_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cerita`
--

CREATE TABLE IF NOT EXISTS `cerita` (
  `idcerita` int(11) NOT NULL auto_increment,
  `idproj_flow` int(11) NOT NULL,
  `tgl_cerita` date NOT NULL,
  `deskripsi` text NOT NULL,
  `follow_up` text,
  `idpic` int(11) NOT NULL,
  `idstatuskontrak` int(11) NOT NULL,
  PRIMARY KEY  (`idcerita`),
  KEY `fk_cerita_proj_flow1` (`idproj_flow`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_ruas`
--

CREATE TABLE IF NOT EXISTS `daftar_ruas` (
  `iddaftar_ruas` int(11) NOT NULL auto_increment,
  `tag` varchar(6) NOT NULL,
  `label` varchar(45) NOT NULL,
  PRIMARY KEY  (`iddaftar_ruas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE IF NOT EXISTS `dokumen` (
  `iddokumen` int(11) NOT NULL auto_increment,
  `judul_dokumen` varchar(200) default NULL,
  `nama_berkas` varchar(200) default NULL,
  `idoperator` varchar(45) default NULL,
  `tgl_diisi` date default NULL,
  `tgl_revisi` date default NULL,
  PRIMARY KEY  (`iddokumen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `idgroup` int(11) NOT NULL auto_increment,
  `group` varchar(45) NOT NULL,
  PRIMARY KEY  (`idgroup`),
  UNIQUE KEY `group_UNIQUE` (`group`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `isian_ruas`
--

CREATE TABLE IF NOT EXISTS `isian_ruas` (
  `idisian_ruas` int(11) NOT NULL auto_increment,
  `tag` varchar(6) NOT NULL,
  `value` text NOT NULL,
  `proyek_id` int(11) NOT NULL,
  PRIMARY KEY  (`idisian_ruas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_dok`
--

CREATE TABLE IF NOT EXISTS `jenis_dok` (
  `idjenis_dok` int(11) NOT NULL auto_increment,
  `jenis_dok` varchar(45) default NULL,
  `idpeserta_tender` int(11) default NULL,
  `idproject_profile` int(11) default NULL,
  `idkeuangan` int(11) default NULL,
  `idstatus_project` int(11) default NULL,
  `iddokumen` int(11) default NULL,
  `tgl_upload` date default NULL,
  `idoperator` int(11) default NULL,
  `nama_berkas` varchar(100) default NULL,
  `idkontrak_flow` int(11) NOT NULL,
  `idanggaran` int(11) NOT NULL,
  PRIMARY KEY  (`idjenis_dok`),
  KEY `fk_jenis_dok_dokumen1` (`iddokumen`),
  KEY `fk_jenis_dok_peserta_tender1` (`idpeserta_tender`),
  KEY `fk_jenis_dok_proj_flow1` (`idstatus_project`),
  KEY `fk_jenis_dok_project_profile1` (`idproject_profile`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `idkategori` int(11) NOT NULL auto_increment,
  `sectorCode` varchar(4) default NULL,
  `sectorName` varchar(30) default NULL,
  `subsectorname` varchar(30) default NULL,
  PRIMARY KEY  (`idkategori`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `kontraktor`
--

CREATE TABLE IF NOT EXISTS `kontraktor` (
  `idkontraktor` int(11) NOT NULL auto_increment,
  `idproject_profile` int(11) NOT NULL,
  `idperusahaan` int(11) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `tahapan` enum('PraFS','Transaction','Investor') collate utf8_unicode_ci NOT NULL,
  `catatan` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`idkontraktor`),
  KEY `idproject_profile` (`idproject_profile`,`idperusahaan`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabel kontraktor proyek - temp struktur' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `kontrak_flow`
--

CREATE TABLE IF NOT EXISTS `kontrak_flow` (
  `idkontrak_flow` int(11) NOT NULL auto_increment,
  `idproj_flow` int(11) NOT NULL,
  `kegiatan` varchar(45) NOT NULL,
  `tgl_rencana` date NOT NULL,
  `pic` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `idref_kontrak` int(11) NOT NULL,
  PRIMARY KEY  (`idkontrak_flow`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `kontrak_flow_status`
--

CREATE TABLE IF NOT EXISTS `kontrak_flow_status` (
  `idkontrak_flow_status` int(11) NOT NULL auto_increment,
  `idpic` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `idkontrak_flow` int(11) NOT NULL,
  PRIMARY KEY  (`idkontrak_flow_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `idloan` int(11) NOT NULL auto_increment,
  `kategori` varchar(2) NOT NULL,
  `catatan` varchar(160) default NULL,
  `loan_grand` decimal(16,2) default NULL,
  `loan` varchar(10) default NULL,
  `grand` varchar(10) default NULL,
  `category1` varchar(3) NOT NULL,
  PRIMARY KEY  (`idloan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `master_kabupaten`
--

CREATE TABLE IF NOT EXISTS `master_kabupaten` (
  `id_kabupaten` int(3) NOT NULL,
  `nama_kabupaten` varchar(50) NOT NULL,
  `id_propinsi` int(2) NOT NULL,
  PRIMARY KEY  (`id_kabupaten`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_propinsi`
--

CREATE TABLE IF NOT EXISTS `master_propinsi` (
  `id_propinsi` int(2) NOT NULL,
  `nama_propinsi` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_propinsi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan`
--

CREATE TABLE IF NOT EXISTS `permohonan` (
  `idpermohonan` int(11) NOT NULL auto_increment,
  `idtermin_bayar` int(11) NOT NULL,
  `tgl_permohonan` date NOT NULL,
  `nilai_permintaan_rupiah` decimal(14,2) NOT NULL default '0.00',
  `nilai_permintaan_dollar` decimal(14,2) NOT NULL default '0.00',
  `nilai_disetujui_rupiah` decimal(14,2) NOT NULL default '0.00',
  `nilai_disetujui_dollar` decimal(14,2) NOT NULL default '0.00',
  `eq_idr_usd` decimal(14,2) NOT NULL,
  `disetujui` tinyint(1) NOT NULL,
  `total_disetujui_dollar` decimal(14,2) NOT NULL,
  `loan_adb_usd` decimal(14,2) NOT NULL,
  `grant_gov_usd` decimal(14,2) NOT NULL,
  `tgl_dikirim` date NOT NULL,
  `tgl_disetujui` date NOT NULL,
  `dibayarkan` date NOT NULL,
  PRIMARY KEY  (`idpermohonan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE IF NOT EXISTS `perusahaan` (
  `idperusahaan` int(11) NOT NULL auto_increment,
  `nama` varchar(100) default NULL,
  `jenis` varchar(45) default NULL,
  `alamat` varchar(45) default NULL,
  `telpon` varchar(45) default NULL,
  `hp` varchar(45) default NULL,
  `fax` varchar(50) NOT NULL,
  `email` varchar(45) default NULL,
  `website` varchar(45) default NULL,
  PRIMARY KEY  (`idperusahaan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `peserta_tender`
--

CREATE TABLE IF NOT EXISTS `peserta_tender` (
  `idpeserta_tender` int(11) NOT NULL auto_increment,
  `idproj_flow` int(11) NOT NULL,
  `idperusahaan` int(11) NOT NULL,
  `tgl_daftar` date default NULL,
  `status` varchar(45) default NULL,
  PRIMARY KEY  (`idpeserta_tender`,`idproj_flow`,`idperusahaan`),
  KEY `fk_proj_flow_has_perusahaan_perusahaan1` (`idperusahaan`),
  KEY `fk_proj_flow_has_perusahaan_proj_flow1` (`idproj_flow`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pic`
--

CREATE TABLE IF NOT EXISTS `pic` (
  `idpic` int(11) NOT NULL auto_increment,
  `nama` varchar(45) NOT NULL,
  `group` int(11) default NULL,
  `password` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `phone` varchar(45) default NULL,
  `hp` varchar(45) default NULL,
  `fax` varchar(45) default NULL,
  PRIMARY KEY  (`idpic`),
  KEY `fk_pic_group1` (`group`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_profile`
--

CREATE TABLE IF NOT EXISTS `project_profile` (
  `idproject_profile` int(11) NOT NULL auto_increment,
  `pin` varchar(10) default NULL,
  `nama` varchar(100) NOT NULL,
  `ppp_book_code` varchar(45) NOT NULL,
  `usulan_lpd` varchar(45) NOT NULL,
  `lokasi` varchar(45) default NULL,
  `bpsid_propinsi` varchar(10) NOT NULL,
  `id_kategori` int(11) default NULL,
  `id_loan` int(11) default NULL,
  `surat_lpd` tinyint(4) default '0',
  `appr_dprd` tinyint(4) default '0',
  `ppp_form` tinyint(4) default '0',
  `doc_fs` tinyint(4) default '0',
  `tgl_usulan` date default NULL,
  `tgl_diisi` date default NULL,
  `tgl_revisi` date default NULL,
  `idoperator` int(11) default NULL,
  `last_idref_status` int(11) NOT NULL,
  `tipe_proyek` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`idproject_profile`),
  UNIQUE KEY `pin_UNIQUE` (`pin`),
  KEY `fk_project_profile_kategori` (`id_kategori`),
  KEY `fk_project_profile_loan1` (`id_loan`),
  KEY `fk_project_profile_pic1` (`idoperator`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `proj_flow`
--

CREATE TABLE IF NOT EXISTS `proj_flow` (
  `idproj_flow` int(11) NOT NULL auto_increment,
  `kegiatan` varchar(100) NOT NULL,
  `tgl_rencana` date NOT NULL,
  `pic` int(11) NOT NULL,
  `status` varchar(45) NOT NULL default 'on going',
  `idproject_profile` int(11) NOT NULL,
  `idref_status` int(11) NOT NULL,
  PRIMARY KEY  (`idproj_flow`),
  KEY `fk_proj_flow_project_profile1` (`idproject_profile`),
  KEY `fk_proj_flow_ref_status1` (`idref_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `proj_flow_status`
--

CREATE TABLE IF NOT EXISTS `proj_flow_status` (
  `idproj_flow_status` int(11) NOT NULL auto_increment,
  `idproj_flow` int(11) NOT NULL,
  `idpic` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY  (`idproj_flow_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_kegiatan`
--

CREATE TABLE IF NOT EXISTS `ref_kegiatan` (
  `idref_kegiatan` int(11) NOT NULL,
  `kegiatan` varchar(45) NOT NULL,
  `deskripsi` text NOT NULL,
  PRIMARY KEY  (`idref_kegiatan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_kontrak`
--

CREATE TABLE IF NOT EXISTS `ref_kontrak` (
  `idref_kontrak` int(11) NOT NULL auto_increment,
  `detil_status` varchar(250) NOT NULL,
  `next_step` int(11) NOT NULL,
  PRIMARY KEY  (`idref_kontrak`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_required`
--

CREATE TABLE IF NOT EXISTS `ref_required` (
  `idref_required` int(11) NOT NULL auto_increment,
  `id_kegiatan` int(11) NOT NULL,
  `pic` int(11) NOT NULL,
  `kode_status` int(11) NOT NULL,
  PRIMARY KEY  (`idref_required`),
  KEY `fk_ref_required_ref_kegiatan1` (`id_kegiatan`),
  KEY `fk_ref_required_ref_status1` (`kode_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status`
--

CREATE TABLE IF NOT EXISTS `ref_status` (
  `idref_status` int(11) NOT NULL auto_increment,
  `tahap` varchar(5) collate utf8_unicode_ci NOT NULL,
  `status` varchar(45) collate utf8_unicode_ci NOT NULL,
  `id_detil` int(11) NOT NULL,
  `detil_status` varchar(250) collate utf8_unicode_ci NOT NULL,
  `kode_status` varchar(15) collate utf8_unicode_ci NOT NULL,
  `formulir` varchar(45) collate utf8_unicode_ci default NULL,
  `idpic` varchar(45) collate utf8_unicode_ci NOT NULL,
  `next_step` int(11) NOT NULL,
  `kontrak_step` tinyint(1) NOT NULL default '0',
  `laporan_flag` int(5) NOT NULL default '0',
  PRIMARY KEY  (`idref_status`),
  UNIQUE KEY `kode_status_UNIQUE` (`kode_status`),
  KEY `status` (`detil_status`,`status`),
  KEY `fk_ref_status_pic1` (`idpic`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=182 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_kontrak`
--

CREATE TABLE IF NOT EXISTS `ref_status_kontrak` (
  `idstatuskontrak` int(11) NOT NULL auto_increment,
  `idkontrak_flow` int(11) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `status_akhir` varchar(45) NOT NULL,
  `tgl_diisi` date NOT NULL,
  `tgl_revisi` date NOT NULL,
  `idoperator` int(11) NOT NULL,
  PRIMARY KEY  (`idstatuskontrak`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_project_profile`
--

CREATE TABLE IF NOT EXISTS `ref_status_project_profile` (
  `idstatusproject` int(11) NOT NULL auto_increment,
  `idref_status` int(11) NOT NULL,
  `idproject_profile` int(11) NOT NULL,
  `tgl_mulai` date default NULL,
  `tgl_akhir` date default NULL,
  `status_akhir` varchar(45) collate utf8_unicode_ci default NULL,
  `tgl_diisi` date default NULL,
  `tgl_revisi` date default NULL,
  `idoperator` int(11) default NULL,
  PRIMARY KEY  (`idstatusproject`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_proyek`
--

CREATE TABLE IF NOT EXISTS `ref_status_proyek` (
  `id_status` int(5) NOT NULL,
  `nama_status` varchar(100) NOT NULL,
  PRIMARY KEY  (`id_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_tahapan`
--

CREATE TABLE IF NOT EXISTS `ref_status_tahapan` (
  `id_tahapan` int(5) NOT NULL auto_increment,
  `nama_tahapan` varchar(30) NOT NULL,
  PRIMARY KEY  (`id_tahapan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `idtemplate` int(11) NOT NULL auto_increment,
  `tag` varchar(6) NOT NULL,
  `idcategory` int(11) NOT NULL,
  PRIMARY KEY  (`idtemplate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tender_data`
--

CREATE TABLE IF NOT EXISTS `tender_data` (
  `idtender_data` int(11) NOT NULL auto_increment,
  `idproj` int(11) default NULL,
  `deskripsi` varchar(45) collate utf8_unicode_ci default NULL,
  `tgl_mulai` varchar(45) collate utf8_unicode_ci default NULL,
  `tgl_selesai` varchar(45) collate utf8_unicode_ci default NULL,
  `tipe_tender` varchar(45) collate utf8_unicode_ci default NULL COMMENT 'Jenis ada ditabel ttp hrs ditanyakan detilnya - ',
  `penanggung_jawab` varchar(45) collate utf8_unicode_ci default NULL,
  `idproj_flow` int(11) default NULL,
  `idpemenang` int(11) NOT NULL COMMENT 'link ke tabel perusahaan',
  PRIMARY KEY  (`idtender_data`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `termin_bayar`
--

CREATE TABLE IF NOT EXISTS `termin_bayar` (
  `idtermin_bayar` int(11) NOT NULL auto_increment,
  `kontrakflow_id` int(11) NOT NULL,
  `nilai_rupiah` decimal(12,2) NOT NULL,
  `nilai_dollar` decimal(12,2) NOT NULL,
  `nilai_total_dollar` decimal(12,2) NOT NULL,
  `sumber` enum('Loan','Grant') NOT NULL,
  PRIMARY KEY  (`idtermin_bayar`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;



--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `sectorCode`, `sectorName`, `subsectorname`) VALUES
(1, 'SP', 'Transportation', 'Sea Port'),
(2, 'BT', 'Transportation', 'Land Transport/Bus Terminal'),
(3, 'AP', 'Transportation', 'Air Transport '),
(4, 'RW', 'Transportation', 'Rail Transport '),
(5, 'TR', 'Transportation', 'Toll Road'),
(6, 'WM', 'Environmental / Sanitation', 'Solid Waste Treatment'),
(7, 'OT', 'Other Infrastructure', 'Urban Infrastructure'),
(8, 'MK', 'Other Infrastructure', 'Market'),
(9, 'EN', 'Energy', 'Power Plant'),
(10, 'WS', 'Water', 'Water Supply');

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`idloan`, `kategori`, `catatan`, `loan_grand`, `loan`, `grand`, `category1`) VALUES
(1, 'A1', 'NPDF', 9954444.00, '', NULL, '1A'),
(2, 'A2', 'RPDF', 11475000.00, '', NULL, '1B'),
(3, 'B1', 'Technical Advisory Service and Capacity Building', 8638571.00, '', NULL, '1C'),
(4, 'B2', 'PPP Study', 374286.00, '', NULL, '1D'),
(5, 'B3', 'PPP Strategic Campaign', 375000.00, '', NULL, '1E'),
(6, 'B4', 'PPP - Coordination Unit Support', 1026867.00, '', NULL, '1F'),
(7, 'C1', 'Procurement and Administrative Services', 2930000.00, NULL, NULL, '1G');

--
-- Dumping data for table `master_kabupaten`
--

INSERT INTO `master_kabupaten` (`id_kabupaten`, `nama_kabupaten`, `id_propinsi`) VALUES
(1, 'Kabupaten Aceh Barat', 1),
(2, 'Kabupaten Aceh Barat Daya', 1),
(3, 'Kabupaten Aceh Besar', 1),
(4, 'Kabupaten Aceh Jaya', 1),
(5, 'Kabupaten Aceh Selatan', 1),
(6, 'Kabupaten Aceh Singkil', 1),
(7, 'Kabupaten Aceh Tamiang', 1),
(8, 'Kabupaten Aceh Tengah', 1),
(9, 'Kabupaten Aceh Tenggara', 1),
(10, 'Kabupaten Aceh Timur', 1),
(11, 'Kabupaten Aceh Utara', 1),
(12, 'Kabupaten Bener Meriah', 1),
(13, 'Kabupaten Bireuen', 1),
(14, 'Kabupaten Gayo Lues', 1),
(15, 'Kabupaten Nagan Raya', 1),
(16, 'Kabupaten Pidie', 1),
(17, 'Kabupaten Pidie Jaya', 1),
(18, 'Kabupaten Simeulue', 1),
(19, 'Kota Banda Aceh', 1),
(20, 'Kota Langsa', 1),
(21, 'Kota Lhokseumawe', 1),
(22, 'Kota Sabang', 1),
(23, 'Kota Subulussalam', 1),
(24, 'Kabupaten Asahan', 2),
(25, 'Kabupaten Batu Bara', 2),
(26, 'Kabupaten Dairi', 2),
(27, 'Kabupaten Deli Serdang', 2),
(28, 'Kabupaten Humbang Hasundutan', 2),
(29, 'Kabupaten Karo', 2),
(30, 'Kabupaten Labuhanbatu', 2),
(31, 'Kabupaten Labuhanbatu Selatan', 2),
(32, 'Kabupaten Labuhanbatu Utara', 2),
(33, 'Kabupaten Langkat', 2),
(34, 'Kabupaten Mandailing Natal', 2),
(35, 'Kabupaten Nias', 2),
(36, 'Kabupaten Nias Barat', 2),
(37, 'Kabupaten Nias Selatan', 2),
(38, 'Kabupaten Nias Utara', 2),
(39, 'Kabupaten Padang Lawas', 2),
(40, 'Kabupaten Padang Lawas Utara', 2),
(41, 'Kabupaten Pakpak Bharat', 2),
(42, 'Kabupaten Samosir', 2),
(43, 'Kabupaten Serdang Bedagai', 2),
(44, 'Kabupaten Simalungun', 2),
(45, 'Kabupaten Tapanuli Selatan', 2),
(46, 'Kabupaten Tapanuli Tengah', 2),
(47, 'Kabupaten Tapanuli Utara', 2),
(48, 'Kabupaten Toba Samosir', 2),
(49, 'Kota Binjai', 2),
(50, 'Kota Gunung Sitoli', 2),
(51, 'Kota Medan', 2),
(52, 'Kota Padang Sidempuan', 2),
(53, 'Kota Pematangsiantar', 2),
(54, 'Kota Sibolga', 2),
(55, 'Kota Tanjung Balai', 2),
(56, 'Kota Tebing Tinggi', 2),
(57, 'Kabupaten Bengkulu Selatan', 3),
(58, 'Kabupaten Bengkulu Tengah', 3),
(59, 'Kabupaten Bengkulu Utara', 3),
(60, 'Kabupaten Benteng', 3),
(61, 'Kabupaten Kaur', 3),
(62, 'Kabupaten Kepahiang', 3),
(63, 'Kabupaten Lebong', 3),
(64, 'Kabupaten Mukomuko', 3),
(65, 'Kabupaten Rejang Lebong', 3),
(66, 'Kabupaten Seluma', 3),
(67, 'Kota Bengkulu', 3),
(68, 'Kabupaten Batang Hari', 4),
(69, 'Kabupaten Bungo', 4),
(70, 'Kabupaten Kerinci', 4),
(71, 'Kabupaten Merangin', 4),
(72, 'Kabupaten Muaro Jambi', 4),
(73, 'Kabupaten Sarolangun', 4),
(74, 'Kabupaten Tanjung Jabung Barat', 4),
(75, 'Kabupaten Tanjung Jabung Timur', 4),
(76, 'Kabupaten Tebo', 4),
(77, 'Kota Jambi', 4),
(78, 'Kota Sungai Penuh', 4),
(79, 'Kabupaten Bengkalis', 5),
(80, 'Kabupaten Indragiri Hilir', 5),
(81, 'Kabupaten Indragiri Hulu', 5),
(82, 'Kabupaten Kampar', 5),
(83, 'Kabupaten Kuantan Singingi', 5),
(84, 'Kabupaten Pelalawan', 5),
(85, 'Kabupaten Rokan Hilir', 5),
(86, 'Kabupaten Rokan Hulu', 5),
(87, 'Kabupaten Siak', 5),
(88, 'Kota Pekanbaru', 5),
(89, 'Kota Dumai', 5),
(90, 'Kabupaten Kepulauan Meranti', 5),
(91, 'Kabupaten Agam', 6),
(92, 'Kabupaten Dharmasraya', 6),
(93, 'Kabupaten Kepulauan Mentawai', 6),
(94, 'Kabupaten Lima Puluh Kota', 6),
(95, 'Kabupaten Padang Pariaman', 6),
(96, 'Kabupaten Pasaman', 6),
(97, 'Kabupaten Pasaman Barat', 6),
(98, 'Kabupaten Pesisir Selatan', 6),
(99, 'Kabupaten Sijunjung', 6),
(100, 'Kabupaten Solok', 6),
(101, 'Kabupaten Solok Selatan', 6),
(102, 'Kabupaten Tanah Datar', 6),
(103, 'Kota Bukittinggi', 6),
(104, 'Kota Padang', 6),
(105, 'Kota Padangpanjang', 6),
(106, 'Kota Pariaman', 6),
(107, 'Kota Payakumbuh', 6),
(108, 'Kota Sawahlunto', 6),
(109, 'Kota Solok', 6),
(110, 'Kabupaten Banyuasin', 7),
(111, 'Kabupaten Empat Lawang', 7),
(112, 'Kabupaten Lahat', 7),
(113, 'Kabupaten Muara Enim', 7),
(114, 'Kabupaten Musi Banyuasin', 7),
(115, 'Kabupaten Musi Rawas', 7),
(116, 'Kabupaten Ogan Ilir', 7),
(117, 'Kabupaten Ogan Komering Ilir', 7),
(118, 'Kabupaten Ogan Komering Ulu', 7),
(119, 'Kabupaten Ogan Komering Ulu Selatan', 7),
(120, 'Kabupaten Ogan Komering Ulu Timur', 7),
(121, 'Kota Lubuklinggau', 7),
(122, 'Kota Pagar Alam', 7),
(123, 'Kota Palembang', 7),
(124, 'Kota Prabumulih', 7),
(125, 'Kabupaten Lampung Barat', 8),
(126, 'Kabupaten Lampung Selatan', 8),
(127, 'Kabupaten Lampung Tengah', 8),
(128, 'Kabupaten Lampung Timur', 8),
(129, 'Kabupaten Lampung Utara', 8),
(130, 'Kabupaten Mesuji', 8),
(131, 'Kabupaten Pesawaran', 8),
(132, 'Kabupaten Pringsewu', 8),
(133, 'Kabupaten Tanggamus', 8),
(134, 'Kabupaten Tulang Bawang', 8),
(135, 'Kabupaten Tulang Bawang Barat', 8),
(136, 'Kabupaten Way Kanan', 8),
(137, 'Kota Bandar Lampung', 8),
(138, 'Kota Metro', 8),
(139, 'Kabupaten Bangka', 9),
(140, 'Kabupaten Bangka Barat', 9),
(141, 'Kabupaten Bangka Selatan', 9),
(142, 'Kabupaten Bangka Tengah', 9),
(143, 'Kabupaten Belitung', 9),
(144, 'Kabupaten Belitung Timur', 9),
(145, 'Kota Pangkal Pinang', 9),
(146, 'Kabupaten Bintan', 10),
(147, 'Kabupaten Karimun', 10),
(148, 'Kabupaten Kepulauan Anambas', 10),
(149, 'Kabupaten Lingga', 10),
(150, 'Kabupaten Natuna', 10),
(151, 'Kota Batam', 10),
(152, 'Kota Tanjung Pinang', 10),
(153, 'Kabupaten Lebak', 11),
(154, 'Kabupaten Pandeglang', 11),
(155, 'Kabupaten Serang', 11),
(156, 'Kabupaten Tangerang', 11),
(157, 'Kota Cilegon', 11),
(158, 'Kota Serang', 11),
(159, 'Kota Tangerang', 11),
(160, 'Kota Tangerang Selatan', 11),
(161, 'Kabupaten Bandung', 12),
(162, 'Kabupaten Bandung Barat', 12),
(163, 'Kabupaten Bekasi', 12),
(164, 'Kabupaten Bogor', 12),
(165, 'Kabupaten Ciamis', 12),
(166, 'Kabupaten Cianjur', 12),
(167, 'Kabupaten Cirebon', 12),
(168, 'Kabupaten Garut', 12),
(169, 'Kabupaten Indramayu', 12),
(170, 'Kabupaten Karawang', 12),
(171, 'Kabupaten Kuningan', 12),
(172, 'Kabupaten Majalengka', 12),
(173, 'Kabupaten Purwakarta', 12),
(174, 'Kabupaten Subang', 12),
(175, 'Kabupaten Sukabumi', 12),
(176, 'Kabupaten Sumedang', 12),
(177, 'Kabupaten Tasikmalaya', 12),
(178, 'Kota Bandung', 12),
(179, 'Kota Banjar', 12),
(180, 'Kota Bekasi', 12),
(181, 'Kota Bogor', 12),
(182, 'Kota Cimahi', 12),
(183, 'Kota Cirebon', 12),
(184, 'Kota Depok', 12),
(185, 'Kota Sukabumi', 12),
(186, 'Kota Tasikmalaya', 12),
(187, 'Kabupaten Administrasi Kepulauan Seribu', 13),
(188, 'Kota Administrasi Jakarta Barat', 13),
(189, 'Kota Administrasi Jakarta Pusat', 13),
(190, 'Kota Administrasi Jakarta Selatan', 13),
(191, 'Kota Administrasi Jakarta Timur', 13),
(192, 'Kota Administrasi Jakarta Utara', 13),
(193, 'Kabupaten Banjarnegara', 14),
(194, 'Kabupaten Banyumas', 14),
(195, 'Kabupaten Batang', 14),
(196, 'Kabupaten Blora', 14),
(197, 'Kabupaten Boyolali', 14),
(198, 'Kabupaten Brebes', 14),
(199, 'Kabupaten Cilacap', 14),
(200, 'Kabupaten Demak', 14),
(201, 'Kabupaten Grobogan', 14),
(202, 'Kabupaten Jepara', 14),
(203, 'Kabupaten Karanganyar', 14),
(204, 'Kabupaten Kebumen', 14),
(205, 'Kabupaten Kendal', 14),
(206, 'Kabupaten Klaten', 14),
(207, 'Kabupaten Kudus', 14),
(208, 'Kabupaten Magelang', 14),
(209, 'Kabupaten Pati', 14),
(210, 'Kabupaten Pekalongan', 14),
(211, 'Kabupaten Pemalang', 14),
(212, 'Kabupaten Purbalingga', 14),
(213, 'Kabupaten Purworejo', 14),
(214, 'Kabupaten Rembang', 14),
(215, 'Kabupaten Semarang', 14),
(216, 'Kabupaten Sragen', 14),
(217, 'Kabupaten Sukoharjo', 14),
(218, 'Kabupaten Tegal', 14),
(219, 'Kabupaten Temanggung', 14),
(220, 'Kabupaten Wonogiri', 14),
(221, 'Kabupaten Wonosobo', 14),
(222, 'Kota Magelang', 14),
(223, 'Kota Pekalongan', 14),
(224, 'Kota Salatiga', 14),
(225, 'Kota Semarang', 14),
(226, 'Kota Surakarta', 14),
(227, 'Kota Tegal', 14),
(228, 'Kabupaten Bangkalan', 15),
(229, 'Kabupaten Banyuwangi', 15),
(230, 'Kabupaten Blitar', 15),
(231, 'Kabupaten Bojonegoro', 15),
(232, 'Kabupaten Bondowoso', 15),
(233, 'Kabupaten Gresik', 15),
(234, 'Kabupaten Jember', 15),
(235, 'Kabupaten Jombang', 15),
(236, 'Kabupaten Kediri', 15),
(237, 'Kabupaten Lamongan', 15),
(238, 'Kabupaten Lumajang', 15),
(239, 'Kabupaten Madiun', 15),
(240, 'Kabupaten Magetan', 15),
(241, 'Kabupaten Malang', 15),
(242, 'Kabupaten Mojokerto', 15),
(243, 'Kabupaten Nganjuk', 15),
(244, 'Kabupaten Ngawi', 15),
(245, 'Kabupaten Pacitan', 15),
(246, 'Kabupaten Pamekasan', 15),
(247, 'Kabupaten Pasuruan', 15),
(248, 'Kabupaten Ponorogo', 15),
(249, 'Kabupaten Probolinggo', 15),
(250, 'Kabupaten Sampang', 15),
(251, 'Kabupaten Sidoarjo', 15),
(252, 'Kabupaten Situbondo', 15),
(253, 'Kabupaten Sumenep', 15),
(254, 'Kabupaten Trenggalek', 15),
(255, 'Kabupaten Tuban', 15),
(256, 'Kabupaten Tulungagung', 15),
(257, 'Kota Batu', 15),
(258, 'Kota Blitar', 15),
(259, 'Kota Kediri', 15),
(260, 'Kota Madiun', 15),
(261, 'Kota Malang', 15),
(262, 'Kota Mojokerto', 15),
(263, 'Kota Pasuruan', 15),
(264, 'Kota Probolinggo', 15),
(265, 'Kota Surabaya', 15),
(266, 'Kabupaten Bantul', 16),
(267, 'Kabupaten Gunung Kidul', 16),
(268, 'Kabupaten Kulon Progo', 16),
(269, 'Kabupaten Sleman', 16),
(270, 'Kota Yogyakarta', 16),
(271, 'Kabupaten Badung', 17),
(272, 'Kabupaten Bangli', 17),
(273, 'Kabupaten Buleleng', 17),
(274, 'Kabupaten Gianyar', 17),
(275, 'Kabupaten Jembrana', 17),
(276, 'Kabupaten Karangasem', 17),
(277, 'Kabupaten Klungkung', 17),
(278, 'Kabupaten Tabanan', 17),
(279, 'Kota Denpasar', 17),
(280, 'Kabupaten Bima', 18),
(281, 'Kabupaten Dompu', 18),
(282, 'Kabupaten Lombok Barat', 18),
(283, 'Kabupaten Lombok Tengah', 18),
(284, 'Kabupaten Lombok Timur', 18),
(285, 'Kabupaten Lombok Utara', 18),
(286, 'Kabupaten Sumbawa', 18),
(287, 'Kabupaten Sumbawa Barat', 18),
(288, 'Kota Bima', 18),
(289, 'Kota Mataram', 18),
(290, 'Kabupaten Kupang', 19),
(291, 'Kabupaten Timor Tengah Selatan', 19),
(292, 'Kabupaten Timor Tengah Utara', 19),
(293, 'Kabupaten Belu', 19),
(294, 'Kabupaten Alor', 19),
(295, 'Kabupaten Flores Timur', 19),
(296, 'Kabupaten Sikka', 19),
(297, 'Kabupaten Ende', 19),
(298, 'Kabupaten Ngada', 19),
(299, 'Kabupaten Manggarai', 19),
(300, 'Kabupaten Sumba Timur', 19),
(301, 'Kabupaten Sumba Barat', 19),
(302, 'Kabupaten Lembata', 19),
(303, 'Kabupaten Rote Ndao', 19),
(304, 'Kabupaten Manggarai Barat', 19),
(305, 'Kabupaten Nagekeo', 19),
(306, 'Kabupaten Sumba Tengah', 19),
(307, 'Kabupaten Sumba Barat Daya', 19),
(308, 'Kabupaten Manggarai Timur', 19),
(309, 'Kabupaten Sabu Raijua', 19),
(310, 'Kota Kupang', 19),
(311, 'Kabupaten Bengkayang', 20),
(312, 'Kabupaten Kapuas Hulu', 20),
(313, 'Kabupaten Kayong Utara', 20),
(314, 'Kabupaten Ketapang', 20),
(315, 'Kabupaten Kubu Raya', 20),
(316, 'Kabupaten Landak', 20),
(317, 'Kabupaten Melawi', 20),
(318, 'Kabupaten Pontianak', 20),
(319, 'Kabupaten Sambas', 20),
(320, 'Kabupaten Sanggau', 20),
(321, 'Kabupaten Sekadau', 20),
(322, 'Kabupaten Sintang', 20),
(323, 'Kota Pontianak', 20),
(324, 'Kota Singkawang', 20),
(325, 'Kabupaten Balangan', 21),
(326, 'Kabupaten Banjar', 21),
(327, 'Kabupaten Barito Kuala', 21),
(328, 'Kabupaten Hulu Sungai Selatan', 21),
(329, 'Kabupaten Hulu Sungai Tengah', 21),
(330, 'Kabupaten Hulu Sungai Utara', 21),
(331, 'Kabupaten Kotabaru', 21),
(332, 'Kabupaten Tabalong', 21),
(333, 'Kabupaten Tanah Bumbu', 21),
(334, 'Kabupaten Tanah Laut', 21),
(335, 'Kabupaten Tapin', 21),
(336, 'Kota Banjarbaru', 21),
(337, 'Kota Banjarmasin', 21),
(338, 'Kabupaten Barito Selatan', 22),
(339, 'Kabupaten Barito Timur', 22),
(340, 'Kabupaten Barito Utara', 22),
(341, 'Kabupaten Gunung Mas', 22),
(342, 'Kabupaten Kapuas', 22),
(343, 'Kabupaten Katingan', 22),
(344, 'Kabupaten Kotawaringin Barat', 22),
(345, 'Kabupaten Kotawaringin Timur', 22),
(346, 'Kabupaten Lamandau', 22),
(347, 'Kabupaten Murung Raya', 22),
(348, 'Kabupaten Pulang Pisau', 22),
(349, 'Kabupaten Sukamara', 22),
(350, 'Kabupaten Seruyan', 22),
(351, 'Kota Palangka Raya', 22),
(352, 'Kabupaten Berau', 23),
(353, 'Kabupaten Bulungan', 23),
(354, 'Kabupaten Kutai Barat', 23),
(355, 'Kabupaten Kutai Kartanegara', 23),
(356, 'Kabupaten Kutai Timur', 23),
(357, 'Kabupaten Malinau', 23),
(358, 'Kabupaten Nunukan', 23),
(359, 'Kabupaten Paser', 23),
(360, 'Kabupaten Penajam Paser Utara', 23),
(361, 'Kabupaten Tana Tidung', 23),
(362, 'Kota Balikpapan', 23),
(363, 'Kota Bontang', 23),
(364, 'Kota Samarinda', 23),
(365, 'Kota Tarakan', 23),
(366, 'Kabupaten Boalemo', 24),
(367, 'Kabupaten Bone Bolango', 24),
(368, 'Kabupaten Gorontalo', 24),
(369, 'Kabupaten Gorontalo Utara', 24),
(370, 'Kabupaten Pohuwato', 24),
(371, 'Kota Gorontalo', 24),
(372, 'Kabupaten Bantaeng', 25),
(373, 'Kabupaten Barru', 25),
(374, 'Kabupaten Bone', 25),
(375, 'Kabupaten Bulukumba', 25),
(376, 'Kabupaten Enrekang', 25),
(377, 'Kabupaten Gowa', 25),
(378, 'Kabupaten Jeneponto', 25),
(379, 'Kabupaten Kepulauan Selayar', 25),
(380, 'Kabupaten Luwu', 25),
(381, 'Kabupaten Luwu Timur', 25),
(382, 'Kabupaten Luwu Utara', 25),
(383, 'Kabupaten Maros', 25),
(384, 'Kabupaten Pangkajene dan Kepulauan', 25),
(385, 'Kabupaten Pinrang', 25),
(386, 'Kabupaten Sidenreng Rappang', 25),
(387, 'Kabupaten Sinjai', 25),
(388, 'Kabupaten Soppeng', 25),
(389, 'Kabupaten Takalar', 25),
(390, 'Kabupaten Tana Toraja', 25),
(391, 'Kabupaten Toraja Utara', 25),
(392, 'Kabupaten Wajo', 25),
(393, 'Kota Makassar', 25),
(394, 'Kota Palopo', 25),
(395, 'Kota Parepare', 25),
(396, 'Kabupaten Bombana', 26),
(397, 'Kabupaten Buton', 26),
(398, 'Kabupaten Buton Utara', 26),
(399, 'Kabupaten Kolaka', 26),
(400, 'Kabupaten Kolaka Utara', 26),
(401, 'Kabupaten Konawe', 26),
(402, 'Kabupaten Konawe Selatan', 26),
(403, 'Kabupaten Konawe Utara', 26),
(404, 'Kabupaten Muna', 26),
(405, 'Kabupaten Wakatobi', 26),
(406, 'Kota Bau-Bau', 26),
(407, 'Kota Kendari', 26),
(408, 'Kabupaten Banggai', 27),
(409, 'Kabupaten Banggai Kepulauan', 27),
(410, 'Kabupaten Buol', 27),
(411, 'Kabupaten Donggala', 27),
(412, 'Kabupaten Morowali', 27),
(413, 'Kabupaten Parigi Moutong', 27),
(414, 'Kabupaten Poso', 27),
(415, 'Kabupaten Tojo Una-Una', 27),
(416, 'Kabupaten Toli-Toli', 27),
(417, 'Kabupaten Sigi', 27),
(418, 'Kota Palu', 27),
(419, 'Kabupaten Bolaang Mongondow', 28),
(420, 'Kabupaten Bolaang Mongondow Selatan', 28),
(421, 'Kabupaten Bolaang Mongondow Timur', 28),
(422, 'Kabupaten Bolaang Mongondow Utara', 28),
(423, 'Kabupaten Kepulauan Sangihe', 28),
(424, 'Kabupaten Kepulauan Siau Tagulandang Biaro', 28),
(425, 'Kabupaten Kepulauan Talaud', 28),
(426, 'Kabupaten Minahasa', 28),
(427, 'Kabupaten Minahasa Selatan', 28),
(428, 'Kabupaten Minahasa Tenggara', 28),
(429, 'Kabupaten Minahasa Utara', 28),
(430, 'Kota Bitung', 28),
(431, 'Kota Kotamobagu', 28),
(432, 'Kota Manado', 28),
(433, 'Kota Tomohon', 28),
(434, 'Kabupaten Majene', 29),
(435, 'Kabupaten Mamasa', 29),
(436, 'Kabupaten Mamuju', 29),
(437, 'Kabupaten Mamuju Utara', 29),
(438, 'Kabupaten Polewali Mandar', 29),
(439, 'Kabupaten Buru', 30),
(440, 'Kabupaten Buru Selatan', 30),
(441, 'Kabupaten Kepulauan Aru', 30),
(442, 'Kabupaten Maluku Barat Daya', 30),
(443, 'Kabupaten Maluku Tengah', 30),
(444, 'Kabupaten Maluku Tenggara', 30),
(445, 'Kabupaten Maluku Tenggara Barat', 30),
(446, 'Kabupaten Seram Bagian Barat', 30),
(447, 'Kabupaten Seram Bagian Timur', 30),
(448, 'Kota Ambon', 30),
(449, 'Kota Tual', 30),
(450, 'Kabupaten Halmahera Barat', 31),
(451, 'Kabupaten Halmahera Tengah', 31),
(452, 'Kabupaten Halmahera Utara', 31),
(453, 'Kabupaten Halmahera Selatan', 31),
(454, 'Kabupaten Kepulauan Sula', 31),
(455, 'Kabupaten Halmahera Timur', 31),
(456, 'Kabupaten Pulau Morotai', 31),
(457, 'Kota Ternate', 31),
(458, 'Kota Tidore Kepulauan', 31),
(459, 'Kabupaten Asmat', 32),
(460, 'Kabupaten Biak Numfor', 32),
(461, 'Kabupaten Boven Digoel', 32),
(462, 'Kabupaten Deiyai', 32),
(463, 'Kabupaten Dogiyai', 32),
(464, 'Kabupaten Intan Jaya', 32),
(465, 'Kabupaten Jayapura', 32),
(466, 'Kabupaten Jayawijaya', 32),
(467, 'Kabupaten Keerom', 32),
(468, 'Kabupaten Kepulauan Yapen', 32),
(469, 'Kabupaten Lanny Jaya', 32),
(470, 'Kabupaten Mamberamo Raya', 32),
(471, 'Kabupaten Mamberamo Tengah', 32),
(472, 'Kabupaten Mappi', 32),
(473, 'Kabupaten Merauke', 32),
(474, 'Kabupaten Mimika', 32),
(475, 'Kabupaten Nabire', 32),
(476, 'Kabupaten Nduga', 32),
(477, 'Kabupaten Paniai', 32),
(478, 'Kabupaten Pegunungan Bintang', 32),
(479, 'Kabupaten Puncak', 32),
(480, 'Kabupaten Puncak Jaya', 32),
(481, 'Kabupaten Sarmi', 32),
(482, 'Kabupaten Supiori', 32),
(483, 'Kabupaten Tolikara', 32),
(484, 'Kabupaten Waropen', 32),
(485, 'Kabupaten Yahukimo', 32),
(486, 'Kabupaten Yalimo', 32),
(487, 'Kota Jayapura', 32),
(488, 'Kabupaten Fakfak', 33),
(489, 'Kabupaten Kaimana', 33),
(490, 'Kabupaten Manokwari', 33),
(491, 'Kabupaten Maybrat', 33),
(492, 'Kabupaten Raja Ampat', 33),
(493, 'Kabupaten Sorong', 33),
(494, 'Kabupaten Sorong Selatan', 33),
(495, 'Kabupaten Tambrauw', 33),
(496, 'Kabupaten Teluk Bintuni', 33),
(497, 'Kabupaten Teluk Wondama', 33),
(498, 'Kota Sorong', 33);

--
-- Dumping data for table `master_propinsi`
--

INSERT INTO `master_propinsi` (`id_propinsi`, `nama_propinsi`) VALUES
(1, 'Aceh'),
(2, 'Sumatera Utara'),
(3, 'Bengkulu'),
(4, 'Jambi'),
(5, 'Riau'),
(6, 'Sumatera Barat'),
(7, 'Sumatera Selatan'),
(8, 'Lampung'),
(9, 'Kepulauan Bangka Belitung'),
(10, 'Kepulauan Riau'),
(11, 'Banten'),
(12, 'Jawa Barat'),
(13, 'DKI Jakarta'),
(14, 'Jawa Tengah'),
(15, 'Jawa Timur'),
(16, 'Daerah Istimewa Yogyakarta'),
(17, 'Bali'),
(18, 'Nusa Tenggara Barat'),
(19, 'Nusa Tenggara Timur'),
(20, 'Kalimantan Barat'),
(21, 'Kalimantan Selatan'),
(22, 'Kalimantan Tengah'),
(23, 'Kalimantan Timur'),
(24, 'Gorontalo'),
(25, 'Sulawesi Selatan'),
(26, 'Sulawesi Tenggara'),
(27, 'Sulawesi Tengah'),
(28, 'Sulawesi Utara'),
(29, 'Sulawesi Barat'),
(30, 'Maluku'),
(31, 'Maluku Utara'),
(32, 'Papua'),
(33, 'Papua Barat');

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`idperusahaan`, `nama`, `jenis`, `alamat`, `telpon`, `hp`, `fax`, `email`, `website`) VALUES
(1, 'Poyry Environment, Gmbh, pt', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(2, 'SMEC International, Pty, Ltd', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(3, 'Catur Bina Guna Persada, pt', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(4, 'Black and Veat pt, IRM Asia, Reka, MTeknik, Saka, Osana', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(5, 'Inacon Luhur Pertiwi, pt', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(6, 'Royalinda Expoduta, pt', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(7, 'Pillar Pusaka Inti, pt in Assoc Phibetha, pt', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(8, 'Individual Consultant', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(9, 'PMU IRSDP', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(10, 'PAS Consultant', NULL, NULL, NULL, NULL, '0', NULL, NULL),
(11, 'TAS Consultant', NULL, NULL, NULL, NULL, '0', NULL, NULL);

--
-- Dumping data for table `pic`
--

INSERT INTO `pic` (`idpic`, `nama`, `group`, `password`, `email`, `phone`, `hp`, `fax`) VALUES
(1, 'petugas_pas', 1, 'petugas_pas', 'petugas_pas@example.com', '123456', '0121', '123123'),
(2, 'admin', 2, 'admin', 'admin@example.com', NULL, NULL, NULL),
(3, 'petugas_tas', 3, 'petugas_tas', 'petugas_tas@example.com', NULL, NULL, NULL),
(4, 'konsultan', 4, 'konsultan', NULL, NULL, NULL, NULL);

--
-- Dumping data for table `ref_status`
--

INSERT INTO `ref_status` (`idref_status`, `tahap`, `status`, `id_detil`, `detil_status`, `kode_status`, `formulir`, `idpic`, `next_step`, `kontrak_step`, `laporan_flag`) VALUES
(1, '1', '1', 1, 'Identifikasi  Proyek Kerjasama', 'REN001', NULL, '1', 2, 0, 0),
(2, '1', '1', 2, 'Pemilihan Proyek Kerjasama', 'REN002', NULL, '1', 3, 0, 0),
(3, '1', '1', 3, 'Penetapan Prioritas Proyek Kerjasama', 'REN003', NULL, '1', 4, 0, 0),
(4, '1', '1', 4, 'Capacity Building & Training for PPP Team of LG', 'REN004', NULL, '1', 0, 0, 0),
(5, '2', '1', 1, 'PMU informs TAS/PAS to prepare draft TOR Tender PraFS', 'QTFS001', NULL, '1', 6, 0, 0),
(6, '2', '1', 2, 'TAS /PAS Submits Draft TOR Tender PraFS to PMU for Approval', 'QTFS002', NULL, '1', 7, 0, 0),
(7, '2', '1', 3, 'PMU requests approval of draft TOR Tender PraFS from LG  ', 'QTFS003', NULL, '1', 8, 0, 0),
(8, '2', '1', 4, 'PMU receives approval of draft TOR Tender PraFS from LG', 'QTFS004', NULL, '1', 9, 0, 0),
(9, '2', '1', 5, 'PMU Memberitahukan kepada konsultan PAS untuk mempersiapkan dokumen Tender PraFS yaitu draft iklan, draft REOI, draft RFP (FTP/STP) dan draft kriteria evaluasi', 'QTFS005', NULL, '1', 10, 0, 0),
(10, '2', '1', 6, 'Persiapan draft iklan, REOI, RFP (FTP/STP) dan Kriteria Evaluasi (Copy TOR dari PMU)', 'QTFS006', NULL, '1', 11, 0, 0),
(11, '2', '1', 7, 'PMU mengirimkan draft iklan, REOI, RFP (FTP/STP) dan Kriteria Evaluasi (Copy TOR dari PMU) ke ADB', 'QTFS007', NULL, '1', 12, 0, 1),
(12, '2', '1', 8, 'Persetujuan (NOL) ADB terhadap Dokumen Tender', 'QTFS008', NULL, '1', 13, 0, 2),
(13, '2', '1', 9, 'Perbaikan Draft dokumen tersebut diatas (bila diminta ADB)', 'QTFS009', NULL, '1', 14, 0, 0),
(14, '2', '1', 10, 'PMU meminta Panitia untuk Memulai Proses REOI', 'QTFS010', NULL, '1', 15, 0, 0),
(15, '2', '1', 11, 'Pemasangan Iklan REOI', 'QTFS011', NULL, '1', 16, 0, 3),
(16, '2', '1', 12, 'Penerimaan dokumen EOI dari konsultan yang berminat', 'QTFS012', NULL, '1', 17, 0, 4),
(17, '2', '1', 13, 'Pembukaan dokumen EOI', 'QTFS013', NULL, '1', 18, 0, 0),
(18, '2', '1', 14, 'Evaluasi dokumen EOI', 'QTFS014', NULL, '1', 19, 0, 5),
(19, '2', '1', 15, 'Panitia membuat Laporan Hasil Evaluasi Dokumen EOI & disampaikan ke PMU ', 'QTFS015', NULL, '1', 20, 0, 0),
(20, '2', '1', 16, 'Pengiriman Laporan Hasil Evaluasi (disertai Draft RFP jika ada Revisi) ke ADB', 'QTFS016', NULL, '1', 21, 0, 0),
(21, '2', '1', 17, 'Persetujuan (NOL) ADB atas Hasil Evaluasi  EOI', 'QTFS017', NULL, '1', 22, 0, 6),
(22, '2', '1', 18, 'Perbaikan RFP (jika diminta ADB)', 'QTFS018', NULL, '1', 23, 0, 0),
(23, '2', '1', 19, 'PMU meminta Panitia untuk Memulai Proses Pengadaan selanjutnya', 'QTFS019', NULL, '1', 24, 0, 0),
(24, '2', '1', 20, 'Penerbitan RFP (FTP/STP) kepada konsultan shortlist', 'QTFS020', NULL, '1', 25, 0, 7),
(25, '2', '1', 21, 'Aanwijzing', 'QTFS021', NULL, '1', 26, 0, 8),
(26, '2', '1', 22, 'Klarifikasi pertanyaan dari konsultan (Bila ada)', 'QTFS022', NULL, '1', 27, 0, 0),
(27, '2', '1', 23, 'Penerimaan Sampul proposal Teknis dan Biaya', 'QTFS023', NULL, '1', 28, 0, 9),
(28, '2', '1', 24, 'Pembukaan Secara Umum  Sampul proposal Teknis', 'QTFS024', NULL, '1', 29, 0, 0),
(29, '2', '1', 25, 'Evaluasi proposal teknis', 'QTFS025', NULL, '1', 30, 0, 10),
(30, '2', '1', 26, 'Panitia membuat Laporan Hasil Evaluasi proposal teknis kepada PMU ', 'QTFS026', NULL, '1', 31, 0, 0),
(31, '2', '1', 27, 'PMU mengirimkan Laporan Hasil Evaluasi proposal teknis ke ADB', 'QTFS027', NULL, '1', 32, 0, 0),
(32, '2', '1', 28, 'Persetujuan (NOL) ADB atas Hasil Evaluasi Teknis', 'QTFS028', NULL, '1', 33, 0, 11),
(33, '2', '1', 29, 'PMU Meminta Panitia untuk Memulai Proses Selanjutnya', 'QTFS029', NULL, '1', 34, 0, 0),
(34, '2', '1', 30, 'Pembukaan Secara Umum  Sampul proposal Biaya', 'QTFS030', NULL, '1', 35, 0, 12),
(35, '2', '1', 31, 'Evaluasi proposal Biaya dan Menghitung Jumlah Skor TP dan FP', 'QTFS031', NULL, '1', 36, 0, 0),
(36, '2', '1', 32, 'Panitia Menyampaikan Laporan Hasil Evaluasi Proposal dan menyampaikan peringkat konsultan kepada PMU', 'QTFS032', NULL, '1', 37, 0, 0),
(37, '2', '1', 33, 'Pengiriman Laporan Hasil Evaluasi Proposal dan menyampaikan peringkat konsultan kepada ADB', 'QTFS033', NULL, '1', 38, 0, 0),
(38, '2', '1', 34, 'Persetujuan (NOL) ADB atas Peringkat Konsultan', 'QTFS034', NULL, '1', 39, 0, 13),
(39, '2', '1', 35, 'Pemberitahuan kepada Panitia untuk Memulai Proses Selanjutnya', 'QTFS035', NULL, '1', 40, 0, 0),
(40, '2', '1', 36, 'Pengumuman pemenang', 'QTFS036', NULL, '1', 41, 0, 0),
(41, '2', '1', 37, 'Membuat Surat Tanggapan terhadap Sanggahan (jika ada)', 'QTFS037', NULL, '1', 42, 0, 0),
(42, '2', '1', 38, 'Klarifikasi dan negosiasi draft kontrak dengan konsultan pemenang', 'QTFS038', NULL, '1', 43, 0, 14),
(43, '2', '1', 39, 'Panitia membuat Laporan Hasil Negosiasi & Draft Kontrak berdasarkan hasil negosiasi', 'QTFS039', NULL, '1', 44, 0, 0),
(44, '2', '1', 40, 'PMU mengirimkan draft Kontrak ke ADB', 'QTFS040', NULL, '1', 45, 0, 0),
(45, '2', '1', 41, 'Persetujuan (NOL) ADB terhadap Draft Kontrak', 'QTFS041', NULL, '1', 79, 0, 15),
(46, '2', '2', 1, 'PMU informs TAS/PAS to prepare draft TOR Tender PraFS', 'CTFS001', NULL, '1', 47, 0, 0),
(47, '2', '2', 2, 'TAS/PAS Submits Draft TOR Tender PraFS to PMU for Approval', 'CTFS002', NULL, '1', 48, 1, 0),
(48, '2', '2', 3, 'PMU requests approval of draft TOR from LG  ', 'CTFS003', NULL, '1', 49, 0, 0),
(49, '2', '2', 4, 'PMU receives approval of draft TOR from LG', 'CTFS004', NULL, '1', 50, 0, 0),
(50, '2', '2', 5, 'PMU Memberitahukan kepada konsultan PAS untuk mempersiapkan dokumen tender yaitu draft iklan, draft REOI, draft RFP (STP) dan draft kriteria evaluasi', 'CTFS005', NULL, '1', 51, 0, 0),
(51, '2', '2', 6, 'Persiapan draft iklan, REOI, RFP (STP) dan Kriteria Evaluasi (Copy TOR dari PMU)', 'CTFS006', NULL, '1', 52, 0, 0),
(52, '2', '2', 7, 'PMU mengirimkan draft iklan, REOI, RFP (STP) dan Kriteria Evaluasi (Copy TOR dari PMU) ke ADB', 'CTFS007', NULL, '1', 53, 0, 0),
(53, '2', '2', 8, 'Persetujuan (NOL) ADB', 'CTFS008', NULL, '1', 54, 0, 0),
(54, '2', '2', 9, 'Perbaikan Draft dokumen tersebut diatas (bila diminta ADB)', 'CTFS009', NULL, '1', 55, 0, 0),
(55, '2', '2', 10, 'PMU meminta Panitia untuk Memulai Proses REOI', 'CTFS010', NULL, '1', 56, 0, 0),
(56, '2', '2', 11, 'Pemasangan Iklan REOI', 'CTFS011', NULL, '1', 57, 0, 0),
(57, '2', '2', 12, 'Penerimaan dokumen EOI dari konsultan yang berminat', 'CTFS012', NULL, '1', 58, 0, 0),
(58, '2', '2', 13, 'Pembukaan dokumen EOI', 'CTFS013', NULL, '1', 59, 0, 0),
(59, '2', '2', 14, 'Evaluasi dokumen EOI', 'CTFS014', NULL, '1', 60, 0, 0),
(60, '2', '2', 15, 'Panitia membuat Laporan Hasil Evaluasi Dokumen EOI & disampaikan ke PMU ', 'CTFS015', NULL, '1', 61, 0, 0),
(61, '2', '2', 16, 'Pengiriman Laporan Hasil Evaluasi (disertai Draft RFP jika ada Revisi) ke ADB', 'CTFS016', NULL, '1', 62, 0, 0),
(62, '2', '2', 17, 'Persetujuan (NOL) ADB atas Hasil Evaluasi  EOI', 'CTFS017', NULL, '1', 63, 0, 0),
(63, '2', '2', 18, 'Perbaikan RFP (jika diminta ADB)', 'CTFS018', NULL, '1', 64, 0, 0),
(64, '2', '2', 19, 'PMU meminta Panitia untuk Memulai Proses Pengadaan selanjutnya', 'CTFS019', NULL, '1', 65, 0, 0),
(65, '2', '2', 20, 'Penerbitan RFP (STP) kepada konsultan  PeringkatSatu', 'CTFS020', NULL, '1', 66, 0, 0),
(66, '2', '2', 21, 'Klarifikasi pertanyaan dari konsultan Peringkat Satu (bila ada)', 'CTFS021', NULL, '1', 67, 0, 0),
(67, '2', '2', 22, 'Penerimaan Sampul proposal Teknis dan Biaya', 'CTFS022', NULL, '1', 68, 0, 0),
(68, '2', '2', 23, 'Evaluasi proposal teknis dan Biaya', 'CTFS023', NULL, '1', 69, 0, 0),
(69, '2', '2', 24, 'Pemberitahuan kepada Konsultan Peringkat Satu untuk memulai Klarifikasi dan negosiasi draft kontrak', 'CTFS024', NULL, '1', 70, 0, 0),
(70, '2', '2', 25, 'Klarifikasi dan negosiasi draft kontrak dengan konsultan Peringkat Satu', 'CTFS025', NULL, '1', 71, 0, 0),
(71, '2', '2', 26, 'Panitia membuat Laporan Hasil Negosiasi & Draft Kontrak berdasarkan hasil negosiasi', 'CTFS026', NULL, '1', 72, 0, 0),
(72, '2', '2', 27, 'PMU mengirimkan draft Kontrak ke ADB', 'CTFS027', NULL, '1', 73, 0, 0),
(73, '2', '2', 28, 'Persetujuan (NOL) ADB terhadap Draft Kontrak', 'CTFS028', NULL, '1', 74, 0, 0),
(74, '2', '2', 29, 'Pengumuman Pemenang', 'CTFS029', NULL, '1', 75, 0, 0),
(75, '2', '2', 30, 'Membuat Surat Tanggapan terhadap Sanggahan (jika ada)', 'CTFS030', NULL, '1', 76, 0, 0),
(76, '2', '2', 31, 'Tanda Tangan Kontrak', 'CTFS031', NULL, '1', 77, 0, 0),
(77, '2', '2', 32, 'Pengiriman Kontrak Tertanda Tangan ke ADB', 'CTFS032', NULL, '1', 78, 0, 0),
(78, '2', '2', 33, 'Persetujuan (NOL) ADB  dengan penerbitan Nomor PCSS', 'CTFS033', NULL, '1', 82, 0, 0),
(79, '2', '3', 1, 'Tanda Tangan Kontrak', 'QTFS042', NULL, '1', 80, 0, 0),
(80, '2', '3', 2, 'Pengiriman Kontrak Tertanda Tangan ke ADB', 'QTFS043', NULL, '1', 81, 0, 0),
(81, '2', '3', 3, 'Persetujuan (NOL) ADB  dengan penerbitan Nomor PCSS', 'QTFS044', NULL, '1', 82, 0, 16),
(82, '2', '4', 1, 'Penyiapan Kajian Awal pra FS', 'OBC001', NULL, '1', 178, 0, 0),
(83, '2', '5', 1, 'Prepare Project Readyness Report', 'PRR001', NULL, '1', 0, 0, 0),
(84, '3', '1', 1, 'PMU conducts pre-market Sounding ', 'QPTR001', NULL, '1', 85, 0, 0),
(85, '3', '1', 2, 'PMU informs TAS/PAS to prepare draft TOR Tender Transaction', 'QPTR002', NULL, '1', 86, 0, 0),
(86, '3', '1', 3, 'TAS /PAS Submits Draft TOR Tender Transaction to PMU for Approval', 'QPTR003', NULL, '1', 87, 0, 0),
(87, '3', '1', 4, 'PMU requests approval of draft TOR Tender Transactionfrom LG  ', 'QPTR004', NULL, '1', 88, 0, 0),
(88, '3', '1', 5, 'PMU receives approval of draft TOR Tender Transaction from LG', 'QPTR005', NULL, '1', 89, 0, 0),
(89, '3', '1', 6, 'PMU Memberitahukan kepada konsultan PAS untuk mempersiapkan dokumen Tender Transaction yaitu draft iklan, draft REOI, draft RFP (FTP/STP) dan draft kriteria evaluasi', 'QPTR006', NULL, '1', 90, 0, 0),
(90, '3', '1', 7, 'Persiapan draft iklan, REOI, RFP (FTP/STP) dan Kriteria Evaluasi (Copy TOR dari PMU)', 'QPTR007', NULL, '1', 91, 0, 0),
(91, '3', '1', 8, 'PMU mengirimkan draft iklan, REOI, RFP (FTP/STP) dan Kriteria Evaluasi (Copy TOR dari PMU) ke ADB', 'QPTR008', NULL, '1', 92, 0, 0),
(92, '3', '1', 9, 'Persetujuan (NOL) ADB terhadap Dokumen Tender Transaction', 'QPTR009', NULL, '1', 93, 0, 0),
(93, '3', '1', 10, 'Perbaikan Draft dokumen tersebut diatas (bila diminta ADB)', 'QPTR010', NULL, '1', 94, 0, 0),
(94, '3', '1', 11, 'PMU meminta Panitia untuk Memulai Proses REOI', 'QPTR011', NULL, '1', 95, 0, 0),
(95, '3', '1', 12, 'Pemasangan Iklan REOI', 'QPTR012', NULL, '1', 96, 0, 0),
(96, '3', '1', 13, 'Penerimaan dokumen EOI dari konsultan yang berminat', 'QPTR013', NULL, '1', 97, 0, 0),
(97, '3', '1', 14, 'Pembukaan dokumen EOI', 'QPTR014', NULL, '1', 98, 0, 0),
(98, '3', '1', 15, 'Evaluasi dokumen EOI', 'QPTR015', NULL, '1', 99, 0, 0),
(99, '3', '1', 16, 'Panitia membuat Laporan Hasil Evaluasi Dokumen EOI & disampaikan ke PMU ', 'QPTR016', NULL, '1', 100, 0, 0),
(100, '3', '1', 17, 'Pengiriman Laporan Hasil Evaluasi (disertai Draft RFP jika ada Revisi) ke ADB', 'QPTR017', NULL, '1', 101, 0, 0),
(101, '3', '1', 18, 'Persetujuan (NOL) ADB atas Hasil Evaluasi  EOI', 'QPTR018', NULL, '1', 102, 0, 0),
(102, '3', '1', 19, 'Perbaikan RFP (jika diminta ADB)', 'QPTR019', NULL, '1', 103, 0, 0),
(103, '3', '1', 20, 'PMU meminta Panitia untuk Memulai Proses Pengadaan selanjutnya', 'QPTR020', NULL, '1', 104, 0, 0),
(104, '3', '1', 21, 'Penerbitan RFP (FTP/STP) kepada konsultan shortlist', 'QPTR021', NULL, '1', 105, 0, 0),
(105, '3', '1', 22, 'Aanwijzing', 'QPTR022', NULL, '1', 106, 0, 0),
(106, '3', '1', 23, 'Klarifikasi pertanyaan dari konsultan (Bila ada)', 'QPTR023', NULL, '1', 107, 0, 0),
(107, '3', '1', 24, 'Penerimaan Sampul proposal Teknis dan Biaya', 'QPTR024', NULL, '1', 108, 0, 0),
(108, '3', '1', 25, 'Pembukaan Secara Umum  Sampul proposal Teknis', 'QPTR025', NULL, '1', 109, 0, 0),
(109, '3', '1', 26, 'Evaluasi proposal teknis', 'QPTR026', NULL, '1', 110, 0, 0),
(110, '3', '1', 27, 'Panitia membuat Laporan Hasil Evaluasi proposal teknis kepada PMU ', 'QPTR027', NULL, '1', 111, 0, 0),
(111, '3', '1', 28, 'PMU mengirimkan Laporan Hasil Evaluasi proposal teknis ke ADB', 'QPTR028', NULL, '1', 112, 0, 0),
(112, '3', '1', 29, 'Persetujuan (NOL) ADB atas Hasil Evaluasi Teknis', 'QPTR029', NULL, '1', 113, 0, 0),
(113, '3', '1', 30, 'PMU Meminta Panitia untuk Memulai Proses Selanjutnya', 'QPTR030', NULL, '1', 114, 0, 0),
(114, '3', '1', 31, 'Pembukaan Secara Umum  Sampul proposal Biaya', 'QPTR031', NULL, '1', 115, 0, 0),
(115, '3', '1', 32, 'Evaluasi proposal Biaya dan Menghitung Jumlah Skor TP dan FP', 'QPTR032', NULL, '1', 116, 0, 0),
(116, '3', '1', 33, 'Panitia Menyampaikan Laporan Hasil Evaluasi Proposal dan menyampaikan peringkat konsultan kepada PMU', 'QPTR033', NULL, '1', 117, 0, 0),
(117, '3', '1', 34, 'Pengiriman Laporan Hasil Evaluasi Proposal dan menyampaikan peringkat konsultan kepada ADB', 'QPTR034', NULL, '1', 118, 0, 0),
(118, '3', '1', 35, 'Persetujuan (NOL) ADB atas Peringkat Konsultan', 'QPTR035', NULL, '1', 119, 0, 0),
(119, '3', '1', 36, 'Pemberitahuan kepada Panitia untuk Memulai Proses Selanjutnya', 'QPTR036', NULL, '1', 120, 0, 0),
(120, '3', '1', 37, 'Pengumuman pemenang', 'QPTR037', NULL, '1', 121, 0, 0),
(121, '3', '1', 38, 'Membuat Surat Tanggapan terhadap Sanggahan (jika ada)', 'QPTR038', NULL, '1', 122, 0, 0),
(122, '3', '1', 39, 'Klarifikasi dan negosiasi draft kontrak dengan konsultan pemenang', 'QPTR039', NULL, '1', 123, 0, 0),
(123, '3', '1', 40, 'Panitia membuat Laporan Hasil Negosiasi & Draft Kontrak berdasarkan hasil negosiasi', 'QPTR040', NULL, '1', 124, 0, 0),
(124, '3', '1', 41, 'PMU mengirimkan draft Kontrak ke ADB', 'QPTR041', NULL, '1', 125, 0, 0),
(125, '3', '1', 42, 'Persetujuan (NOL) ADB terhadap Draft Kontrak', 'QPTR042', NULL, '1', 126, 0, 0),
(126, '3', '1', 43, 'Tanda Tangan Kontrak', 'QPTR043', NULL, '1', 127, 0, 0),
(127, '3', '1', 44, 'Pengiriman Kontrak Tertanda Tangan ke ADB', 'QPTR044', NULL, '1', 128, 0, 0),
(128, '3', '1', 45, 'Persetujuan (NOL) ADB  dengan penerbitan Nomor PCSS', 'QPTR045', NULL, '1', 163, 0, 0),
(129, '3', '2', 1, 'PMU conducts pre-market sounding', 'CPTR001', NULL, '1', 130, 0, 0),
(130, '3', '2', 2, 'PMU informs TAS/PAS to prepare draft TOR Tender Transaction', 'CPTR002', NULL, '1', 131, 0, 0),
(131, '3', '2', 3, 'TAS /PAS Submits Draft TOR Tender Transaction to PMU for Approval', 'CPTR003', NULL, '1', 132, 0, 0),
(132, '3', '2', 4, 'PMU requests approval of draft TOR Tender Transactionfrom LG  ', 'CPTR004', NULL, '1', 133, 0, 0),
(133, '3', '2', 5, 'PMU receives approval of draft TOR Tender Transaction from LG', 'CPTR005', NULL, '1', 134, 0, 0),
(134, '3', '2', 6, 'PMU Memberitahukan kepada konsultan PAS untuk mempersiapkan dokumen Tender Transaction yaitu draft iklan, draft REOI, draft RFP (STP) dan draft kriteria evaluasi', 'CPTR006', NULL, '1', 135, 0, 0),
(135, '3', '2', 7, 'Persiapan draft iklan, REOI, RFP (STP) dan Kriteria Evaluasi (Copy TOR dari PMU)', 'CPTR007', NULL, '1', 136, 0, 0),
(136, '3', '2', 8, 'PMU mengirimkan draft iklan, REOI, RFP (STP) dan Kriteria Evaluasi (Copy TOR dari PMU) ke ADB', 'CPTR008', NULL, '1', 137, 0, 0),
(137, '3', '2', 9, 'Persetujuan (NOL) ADB terhadap Dokumen Tender Transaction', 'CPTR009', NULL, '1', 138, 0, 0),
(138, '3', '2', 10, 'Perbaikan Draft dokumen tersebut diatas (bila diminta ADB)', 'CPTR010', NULL, '1', 139, 0, 0),
(139, '3', '2', 11, 'PMU meminta Panitia untuk Memulai Proses REOI', 'CPTR011', NULL, '1', 140, 0, 0),
(140, '3', '2', 12, 'Pemasangan Iklan REOI', 'CPTR012', NULL, '1', 141, 0, 0),
(141, '3', '2', 13, 'Penerimaan dokumen EOI dari konsultan yang berminat', 'CPTR013', NULL, '1', 142, 0, 0),
(142, '3', '2', 14, 'Pembukaan dokumen EOI', 'CPTR014', NULL, '1', 143, 0, 0),
(143, '3', '2', 15, 'Evaluasi dokumen EOI', 'CPTR015', NULL, '1', 144, 0, 0),
(144, '3', '2', 16, 'Panitia membuat Laporan Hasil Evaluasi Dokumen EOI & disampaikan ke PMU ', 'CPTR016', NULL, '1', 145, 0, 0),
(145, '3', '2', 17, 'Pengiriman Laporan Hasil Evaluasi (disertai Draft RFP jika ada Revisi) ke ADB', 'CPTR017', NULL, '1', 146, 0, 0),
(146, '3', '2', 18, 'Persetujuan (NOL) ADB atas Hasil Evaluasi  EOI', 'CPTR018', NULL, '1', 147, 0, 0),
(147, '3', '2', 19, 'Perbaikan RFP (jika diminta ADB)', 'CPTR019', NULL, '1', 148, 0, 0),
(148, '3', '2', 20, 'PMU meminta Panitia untuk Memulai Proses Pengadaan selanjutnya', 'CPTR020', NULL, '1', 149, 0, 0),
(149, '3', '2', 21, 'Penerbitan RFP (STP) kepada konsultan  PeringkatSatu', 'CPTR021', NULL, '1', 150, 0, 0),
(150, '3', '2', 22, 'Klarifikasi pertanyaan dari konsultan Peringkat Satu (bila ada)', 'CPTR022', NULL, '1', 151, 0, 0),
(151, '3', '2', 23, 'Penerimaan Sampul proposal Teknis dan Biaya', 'CPTR023', NULL, '1', 152, 0, 0),
(152, '3', '2', 24, 'Evaluasi proposal teknis dan Biaya', 'CPTR024', NULL, '1', 153, 0, 0),
(153, '3', '2', 25, 'Pemberitahuan kepada Konsultan Peringkat Satu untuk memulai Klarifikasi dan negosiasi draft kontrak', 'CPTR025', NULL, '1', 154, 0, 0),
(154, '3', '2', 26, 'Klarifikasi dan negosiasi draft kontrak dengan konsultan Peringkat Satu', 'CPTR026', NULL, '1', 155, 0, 0),
(155, '3', '2', 27, 'Panitia membuat Laporan Hasil Negosiasi & Draft Kontrak berdasarkan hasil negosiasi', 'CPTR027', NULL, '1', 156, 0, 0),
(156, '3', '2', 28, 'PMU mengirimkan draft Kontrak ke ADB', 'CPTR028', NULL, '1', 157, 0, 0),
(157, '3', '2', 29, 'Persetujuan (NOL) ADB terhadap Draft Kontrak', 'CPTR029', NULL, '1', 158, 0, 0),
(158, '3', '2', 30, 'Pengumuman Pemenang', 'CPTR030', NULL, '1', 159, 0, 0),
(159, '3', '2', 31, 'Membuat Surat Tanggapan terhadap Sanggahan (jika ada)', 'CPTR031', NULL, '1', 160, 0, 0),
(160, '3', '2', 32, 'Tanda Tangan Kontrak', 'CPTR032', NULL, '1', 161, 0, 0),
(161, '3', '2', 33, 'Pengiriman Kontrak Tertanda Tangan ke ADB', 'CPTR033', NULL, '1', 162, 0, 0),
(162, '3', '2', 34, 'Persetujuan (NOL) ADB  dengan penerbitan Nomor PCSS', 'CPTR034', NULL, '1', 163, 0, 0),
(163, '3', '3', 1, 'Prepare FBC Report', 'FBC001', NULL, '1', 164, 0, 0),
(164, '3', '4', 1, 'Rencana Pengadaan Badan Usaha', 'RBU001', NULL, '1', 180, 0, 0),
(165, '3', '5', 1, 'Advertisement of request for EOI/PQ in mass media', 'TIN001', NULL, '1', 166, 0, 0),
(166, '3', '5', 2, 'Close of submission of request for EOI/PQ documents', 'TIN002', NULL, '1', 167, 0, 0),
(167, '3', '5', 3, 'Evaluation of EOI/PQ documents & shortlist', 'TIN003', NULL, '1', 168, 0, 0),
(168, '3', '5', 4, 'Issuance of LOI & RFP', 'TIN004', NULL, '1', 169, 0, 0),
(169, '3', '5', 5, 'Aanwijzing', 'TIN005', NULL, '1', 170, 0, 0),
(170, '3', '5', 6, 'Close of investment proposal submission', 'TIN006', NULL, '1', 171, 0, 0),
(171, '3', '5', 7, 'Evaluation of investment proposals for all aspects ', 'TIN007', NULL, '1', 172, 0, 0),
(172, '3', '6', 1, 'Commencement of concession contract negotiation', 'TIN008 ', NULL, '1', 173, 0, 0),
(173, '3', '6', 2, 'Signing of concession contract', 'TIN009', NULL, '1', 174, 0, 0),
(174, '3', '6', 3, 'Financial Close', 'TIN010', NULL, '1', 175, 0, 0),
(175, '3', '6', 4, 'Draft Transaction Advisory Services Final Report submitted to & accepted by PMU & ADB, respectively', 'TIN011', NULL, '1', 176, 0, 0),
(176, '4', '1', 1, 'Perencanaan Manajemen Pelaksanaan PK', 'MP001', NULL, '1', 177, 0, 0),
(177, '4', '1', 2, 'Manajemen Pelaksanaan PK', 'MP002', NULL, '1', 0, 0, 0),
(178, '2', '4', 2, 'Penyiapan Kajian Kesiapan Proyek Kerjasama', 'OBC002', NULL, '1', 179, 0, 0),
(180, '3', '4', 2, 'Pelaksanaan Pengadaan Badan Usaha', 'RBU002', NULL, '1', 181, 0, 0),
(179, '2', '4', 3, 'Penyelesaian Kajian Akhir pra FS ', 'OBC003', NULL, '1', 83, 0, 0),
(181, '3', '4', 3, 'Penandatanganan Kontrak Kerjasama', 'RBU003', NULL, '1', 165, 0, 0);

