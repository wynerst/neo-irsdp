-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2011 at 12:19 PM
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
  `anggaran_total_usd` decimal(14,2) DEFAULT NULL,
  `anggaran_usd` decimal(14,2) DEFAULT NULL,
  `anggaran_idr` decimal(14,2) DEFAULT NULL,
  `catatan` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idkontraktor`),
  KEY `idproject_profile` (`idproject_profile`,`idperusahaan`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabel kontraktor proyek - temp struktur' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `kontraktor`
--

INSERT INTO `kontraktor` (`idkontraktor`, `idproject_profile`, `idperusahaan`, `tgl_mulai`, `tgl_selesai`, `tahapan`, `pcss_no`, `pcss_date`, `no_kontrak`, `tgl_disetujui`, `anggaran_total_usd`, `anggaran_usd`, `anggaran_idr`, `catatan`) VALUES
(1, 13, 17, '2011-01-06', '2011-01-29', 'Investor', '', '0000-00-00', '', '0000-00-00', NULL, NULL, NULL, ''),
(2, 1, 5, '0000-00-00', '0000-00-00', 'Transaction', '', '0000-00-00', '', '0000-00-00', NULL, NULL, NULL, ''),
(3, 1, 1, '2011-01-03', '2011-01-05', 'Transaction', '', '0000-00-00', '', '0000-00-00', NULL, NULL, NULL, 'test'),
(4, 8, 15, '2011-01-08', '2011-01-16', 'Investor', '', '0000-00-00', '', '0000-00-00', NULL, NULL, NULL, 'hehe'),
(5, 7, 8, '2011-01-04', '2011-01-31', 'Transaction', '', '0000-00-00', '', '0000-00-00', NULL, NULL, NULL, 'boom'),
(6, 25, 12, '2011-01-01', '2011-06-24', 'PraFS', '', '0000-00-00', '', '0000-00-00', NULL, NULL, NULL, 'fffhhh'),
(8, 184, 1, '2011-02-01', '2011-02-02', 'Transaction', '', '0000-00-00', '', '0000-00-00', NULL, NULL, NULL, '"><"><''.''.,''.,"<",'';.,''.,"><"<'';,":<":<'';;,''php":<",&lt;?php echo "dodol";?&gt;'),
(9, 185, 50, '2011-02-01', '2011-02-04', 'PraFS', '', '0000-00-00', '', '0000-00-00', NULL, NULL, NULL, 'asdasdqweqwe'),
(10, 185, 50, '2011-02-01', '2011-02-04', 'PraFS', '', '0000-00-00', '', '0000-00-00', '789.00', '123.00', '456.00', 'asdasdqweqwe'),
(11, 193, 38, '2011-02-01', '2011-02-01', 'Transaction', '', '0000-00-00', '', '0000-00-00', '789.00', '123123.00', '456.00', '12123asdasdads'),
(12, 193, 38, '2011-02-01', '2011-02-01', 'Transaction', '3e4r4t', '2011-02-28', '', '0000-00-00', '789.00', '123123.00', '456.00', '12123asdasdads'),
(13, 193, 38, '2011-02-01', '2011-02-01', 'Transaction', '3e4r4t', '2011-02-28', '12312aed', '0000-00-00', '789.00', '123123.00', '456.00', '12123asdasdads'),
(14, 5, 4, '2011-02-01', '2011-02-16', 'Investor', 'asdasd', '2011-02-10', 'dada123asda112adad', '0000-00-00', '123123.00', '12312.00', '12123.00', 'asdqweasdqweasdqweasdqweasdqwe asdqwas qwd qwdqw d');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
