-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 08, 2011 at 12:52 AM
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
-- Table structure for table `ref_status_proyek`
--

CREATE TABLE IF NOT EXISTS `ref_status_proyek` (
  `id_status` int(5) NOT NULL,
  `nama_status` varchar(100) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_tahapan`
--

CREATE TABLE IF NOT EXISTS `ref_status_tahapan` (
  `id_tahapan` int(5) NOT NULL AUTO_INCREMENT,
  `nama_tahapan` varchar(30) NOT NULL,
  PRIMARY KEY (`id_tahapan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ref_status_tahapan`
--

INSERT INTO `ref_status_tahapan` (`id_tahapan`, `nama_tahapan`) VALUES
(1, 'Perencanaan Proyek Kerjasama'),
(2, 'Penyiapan FS Proyek Kerjasama'),
(3, 'Transaksi Proyek Kerjasama'),
(4, 'Manajemen Pelaksanaan Proyek');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
