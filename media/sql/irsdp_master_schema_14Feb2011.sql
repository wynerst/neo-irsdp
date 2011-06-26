-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 14, 2011 at 11:24 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `irsdp`
--

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=334 ;

-- --------------------------------------------------------

--
-- Table structure for table `cerita`
--

CREATE TABLE IF NOT EXISTS `cerita` (
  `idcerita` int(11) NOT NULL AUTO_INCREMENT,
  `idproj_flow` int(11) NOT NULL,
  `tgl_cerita` date NOT NULL,
  `deskripsi` text NOT NULL,
  `follow_up` text,
  `idpic` int(11) NOT NULL,
  `idstatuskontrak` int(11) NOT NULL,
  PRIMARY KEY (`idcerita`),
  KEY `fk_cerita_proj_flow1` (`idproj_flow`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_ruas`
--

CREATE TABLE IF NOT EXISTS `daftar_ruas` (
  `iddaftar_ruas` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(6) NOT NULL,
  `label` varchar(45) NOT NULL,
  PRIMARY KEY (`iddaftar_ruas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE IF NOT EXISTS `dokumen` (
  `iddokumen` int(11) NOT NULL AUTO_INCREMENT,
  `judul_dokumen` varchar(200) DEFAULT NULL,
  `nama_berkas` varchar(200) DEFAULT NULL,
  `idoperator` varchar(45) DEFAULT NULL,
  `tgl_diisi` date DEFAULT NULL,
  `tgl_revisi` date DEFAULT NULL,
  PRIMARY KEY (`iddokumen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `idgroup` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(45) NOT NULL,
  PRIMARY KEY (`idgroup`),
  UNIQUE KEY `group_UNIQUE` (`group`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `isian_ruas`
--

CREATE TABLE IF NOT EXISTS `isian_ruas` (
  `idisian_ruas` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(6) NOT NULL,
  `value` text NOT NULL,
  `proyek_id` int(11) NOT NULL,
  PRIMARY KEY (`idisian_ruas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_dok`
--

CREATE TABLE IF NOT EXISTS `jenis_dok` (
  `idjenis_dok` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_dok` varchar(45) DEFAULT NULL,
  `idpeserta_tender` int(11) DEFAULT NULL,
  `idproject_profile` int(11) DEFAULT NULL,
  `idkeuangan` int(11) DEFAULT NULL,
  `idstatus_project` int(11) DEFAULT NULL,
  `iddokumen` int(11) DEFAULT NULL,
  `tgl_upload` date DEFAULT NULL,
  `idoperator` int(11) DEFAULT NULL,
  `nama_berkas` varchar(100) DEFAULT NULL,
  `idkontrak_flow` int(11) NOT NULL,
  `idanggaran` int(11) NOT NULL,
  PRIMARY KEY (`idjenis_dok`),
  KEY `fk_jenis_dok_dokumen1` (`iddokumen`),
  KEY `fk_jenis_dok_peserta_tender1` (`idpeserta_tender`),
  KEY `fk_jenis_dok_proj_flow1` (`idstatus_project`),
  KEY `fk_jenis_dok_project_profile1` (`idproject_profile`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `idkategori` int(11) NOT NULL AUTO_INCREMENT,
  `sectorCode` varchar(4) DEFAULT NULL,
  `sectorName` varchar(30) DEFAULT NULL,
  `subsectorname` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idkategori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `kontraktor`
--

CREATE TABLE IF NOT EXISTS `kontraktor` (
  `idkontraktor` int(11) NOT NULL AUTO_INCREMENT,
  `idproject_profile` int(11) NOT NULL,
  `idperusahaan` int(11) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `tahapan` enum('PraFS','Transaction','Investor') COLLATE utf8_unicode_ci NOT NULL,
  `pcss_no` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `pcss_date` date NOT NULL,
  `no_kontrak` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `tgl_disetujui` date NOT NULL,
  `catatan` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idkontraktor`),
  KEY `idproject_profile` (`idproject_profile`,`idperusahaan`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabel kontraktor proyek - temp struktur' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `kontrak_flow`
--

CREATE TABLE IF NOT EXISTS `kontrak_flow` (
  `idkontrak_flow` int(11) NOT NULL AUTO_INCREMENT,
  `idproj_flow` int(11) NOT NULL,
  `kegiatan` varchar(45) NOT NULL,
  `tgl_rencana` date NOT NULL,
  `pic` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `idref_kontrak` int(11) NOT NULL,
  PRIMARY KEY (`idkontrak_flow`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `kontrak_flow_status`
--

CREATE TABLE IF NOT EXISTS `kontrak_flow_status` (
  `idkontrak_flow_status` int(11) NOT NULL AUTO_INCREMENT,
  `idpic` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `idkontrak_flow` int(11) NOT NULL,
  PRIMARY KEY (`idkontrak_flow_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `idloan` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(2) NOT NULL,
  `catatan` varchar(160) DEFAULT NULL,
  `loan_grand` decimal(16,2) DEFAULT NULL,
  `loan` varchar(10) DEFAULT NULL,
  `grand` varchar(10) DEFAULT NULL,
  `category1` varchar(3) NOT NULL,
  PRIMARY KEY (`idloan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `master_kabupaten`
--

CREATE TABLE IF NOT EXISTS `master_kabupaten` (
  `id_kabupaten` int(3) NOT NULL,
  `nama_kabupaten` varchar(50) NOT NULL,
  `id_propinsi` int(2) NOT NULL,
  PRIMARY KEY (`id_kabupaten`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_propinsi`
--

CREATE TABLE IF NOT EXISTS `master_propinsi` (
  `id_propinsi` int(2) NOT NULL,
  `nama_propinsi` varchar(50) NOT NULL,
  PRIMARY KEY (`id_propinsi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permohonan`
--

CREATE TABLE IF NOT EXISTS `permohonan` (
  `idpermohonan` int(11) NOT NULL AUTO_INCREMENT,
  `idtermin_bayar` int(11) NOT NULL,
  `tgl_permohonan` date NOT NULL,
  `nilai_permintaan_rupiah` decimal(14,2) NOT NULL DEFAULT '0.00',
  `nilai_permintaan_dollar` decimal(14,2) NOT NULL DEFAULT '0.00',
  `nilai_disetujui_rupiah` decimal(14,2) NOT NULL DEFAULT '0.00',
  `nilai_disetujui_dollar` decimal(14,2) NOT NULL DEFAULT '0.00',
  `eq_idr_usd` decimal(14,2) NOT NULL,
  `disetujui` tinyint(1) NOT NULL,
  `total_disetujui_dollar` decimal(14,2) NOT NULL,
  `loan_adb_usd` decimal(14,2) NOT NULL,
  `grant_gov_usd` decimal(14,2) NOT NULL,
  `tgl_dikirim` date NOT NULL,
  `tgl_disetujui` date NOT NULL,
  `dibayarkan` date NOT NULL,
  PRIMARY KEY (`idpermohonan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE IF NOT EXISTS `perusahaan` (
  `idperusahaan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `jenis` varchar(45) DEFAULT NULL,
  `alamat` varchar(45) DEFAULT NULL,
  `telpon` varchar(45) DEFAULT NULL,
  `hp` varchar(45) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `website` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idperusahaan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Table structure for table `peserta_tender`
--

CREATE TABLE IF NOT EXISTS `peserta_tender` (
  `idpeserta_tender` int(11) NOT NULL AUTO_INCREMENT,
  `idproj_flow` int(11) NOT NULL,
  `idperusahaan` int(11) NOT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idpeserta_tender`,`idproj_flow`,`idperusahaan`),
  KEY `fk_proj_flow_has_perusahaan_perusahaan1` (`idperusahaan`),
  KEY `fk_proj_flow_has_perusahaan_proj_flow1` (`idproj_flow`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pic`
--

CREATE TABLE IF NOT EXISTS `pic` (
  `idpic` int(11) NOT NULL AUTO_INCREMENT,
  `idperusahaan` varchar(11) DEFAULT NULL,
  `nama` varchar(45) NOT NULL,
  `group` int(11) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `hp` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idpic`),
  KEY `fk_pic_group1` (`group`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_profile`
--

CREATE TABLE IF NOT EXISTS `project_profile` (
  `idproject_profile` int(11) NOT NULL AUTO_INCREMENT,
  `pin` varchar(10) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `ppp_book_code` varchar(45) NOT NULL,
  `usulan_lpd` varchar(45) NOT NULL,
  `lokasi` varchar(45) DEFAULT NULL,
  `bpsid_propinsi` varchar(10) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_loan` int(11) DEFAULT NULL,
  `surat_lpd` tinyint(4) DEFAULT '0',
  `appr_dprd` tinyint(4) DEFAULT '0',
  `ppp_form` tinyint(4) DEFAULT '0',
  `doc_fs` tinyint(4) DEFAULT '0',
  `tgl_usulan` date DEFAULT NULL,
  `tgl_diisi` date DEFAULT NULL,
  `tgl_revisi` date DEFAULT NULL,
  `idoperator` int(11) DEFAULT NULL,
  `last_idref_status` int(11) NOT NULL,
  `tipe_proyek` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idproject_profile`),
  UNIQUE KEY `pin_UNIQUE` (`pin`),
  KEY `fk_project_profile_kategori` (`id_kategori`),
  KEY `fk_project_profile_loan1` (`id_loan`),
  KEY `fk_project_profile_pic1` (`idoperator`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=225 ;

-- --------------------------------------------------------

--
-- Table structure for table `proj_flow`
--

CREATE TABLE IF NOT EXISTS `proj_flow` (
  `idproj_flow` int(11) NOT NULL AUTO_INCREMENT,
  `kegiatan` varchar(100) NOT NULL,
  `tgl_rencana` date NOT NULL,
  `pic` int(11) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'on going',
  `idproject_profile` int(11) NOT NULL,
  `idref_status` int(11) NOT NULL,
  PRIMARY KEY (`idproj_flow`),
  KEY `fk_proj_flow_project_profile1` (`idproject_profile`),
  KEY `fk_proj_flow_ref_status1` (`idref_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `proj_flow_status`
--

CREATE TABLE IF NOT EXISTS `proj_flow_status` (
  `idproj_flow_status` int(11) NOT NULL AUTO_INCREMENT,
  `idproj_flow` int(11) NOT NULL,
  `idpic` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`idproj_flow_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_kegiatan`
--

CREATE TABLE IF NOT EXISTS `ref_kegiatan` (
  `idref_kegiatan` int(11) NOT NULL,
  `kegiatan` varchar(45) NOT NULL,
  `deskripsi` text NOT NULL,
  PRIMARY KEY (`idref_kegiatan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_kontrak`
--

CREATE TABLE IF NOT EXISTS `ref_kontrak` (
  `idref_kontrak` int(11) NOT NULL AUTO_INCREMENT,
  `detil_status` varchar(250) NOT NULL,
  `next_step` int(11) NOT NULL,
  PRIMARY KEY (`idref_kontrak`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_required`
--

CREATE TABLE IF NOT EXISTS `ref_required` (
  `idref_required` int(11) NOT NULL AUTO_INCREMENT,
  `id_kegiatan` int(11) NOT NULL,
  `pic` int(11) NOT NULL,
  `kode_status` int(11) NOT NULL,
  PRIMARY KEY (`idref_required`),
  KEY `fk_ref_required_ref_kegiatan1` (`id_kegiatan`),
  KEY `fk_ref_required_ref_status1` (`kode_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status`
--

CREATE TABLE IF NOT EXISTS `ref_status` (
  `idref_status` int(11) NOT NULL AUTO_INCREMENT,
  `tahap` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `id_detil` int(11) NOT NULL,
  `detil_status` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `kode_status` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `formulir` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idpic` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `next_step` int(11) NOT NULL,
  `kontrak_step` tinyint(1) NOT NULL DEFAULT '0',
  `laporan_flag` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idref_status`),
  UNIQUE KEY `kode_status_UNIQUE` (`kode_status`),
  KEY `status` (`detil_status`,`status`),
  KEY `fk_ref_status_pic1` (`idpic`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=190 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_kontrak`
--

CREATE TABLE IF NOT EXISTS `ref_status_kontrak` (
  `idstatuskontrak` int(11) NOT NULL AUTO_INCREMENT,
  `idkontrak_flow` int(11) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `status_akhir` varchar(45) NOT NULL,
  `tgl_diisi` date NOT NULL,
  `tgl_revisi` date NOT NULL,
  `idoperator` int(11) NOT NULL,
  PRIMARY KEY (`idstatuskontrak`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_project_profile`
--

CREATE TABLE IF NOT EXISTS `ref_status_project_profile` (
  `idstatusproject` int(11) NOT NULL AUTO_INCREMENT,
  `idref_status` int(11) NOT NULL,
  `idproject_profile` int(11) NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `status_akhir` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tgl_diisi` date DEFAULT NULL,
  `tgl_revisi` date DEFAULT NULL,
  `idoperator` int(11) DEFAULT NULL,
  PRIMARY KEY (`idstatusproject`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_proyek`
--

CREATE TABLE IF NOT EXISTS `ref_status_proyek` (
  `id_status` int(5) NOT NULL,
  `nama_status` varchar(100) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_tahapan`
--

CREATE TABLE IF NOT EXISTS `ref_status_tahapan` (
  `id_tahapan` int(5) NOT NULL AUTO_INCREMENT,
  `nama_tahapan` varchar(30) NOT NULL,
  PRIMARY KEY (`id_tahapan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `idtemplate` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(6) NOT NULL,
  `idcategory` int(11) NOT NULL,
  PRIMARY KEY (`idtemplate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Table structure for table `tender_data`
--

CREATE TABLE IF NOT EXISTS `tender_data` (
  `idtender_data` int(11) NOT NULL AUTO_INCREMENT,
  `idproj` int(11) DEFAULT NULL,
  `deskripsi` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tgl_mulai` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tgl_selesai` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipe_tender` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Jenis ada ditabel ttp hrs ditanyakan detilnya - ',
  `penanggung_jawab` int(11) DEFAULT NULL,
  `idproj_flow` int(11) DEFAULT NULL,
  `idpemenang` int(11) DEFAULT NULL,
  PRIMARY KEY (`idtender_data`),
  KEY `fk_tender_data_proj_flow1` (`idproj_flow`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `termin_bayar`
--

CREATE TABLE IF NOT EXISTS `termin_bayar` (
  `idtermin_bayar` int(11) NOT NULL AUTO_INCREMENT,
  `kontrakflow_id` int(11) NOT NULL,
  `nilai_rupiah` decimal(10,0) NOT NULL,
  `nilai_dollar` decimal(10,0) NOT NULL,
  `nilai_total_dollar` decimal(10,0) NOT NULL,
  `sumber` enum('Loan','Grant') NOT NULL,
  PRIMARY KEY (`idtermin_bayar`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
