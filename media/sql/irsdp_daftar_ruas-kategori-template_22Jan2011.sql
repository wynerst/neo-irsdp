-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 22, 2011 at 07:39 PM
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
-- Table structure for table `daftar_ruas`
--

CREATE TABLE IF NOT EXISTS `daftar_ruas` (
  `iddaftar_ruas` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(6) NOT NULL,
  `label` varchar(45) NOT NULL,
  PRIMARY KEY (`iddaftar_ruas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `daftar_ruas`
--

INSERT INTO `daftar_ruas` (`iddaftar_ruas`, `tag`, `label`) VALUES
(1, '110', 'Panjang Jalan'),
(2, '120', 'Lebar Jalan'),
(7, '0001', 'Project Description'),
(8, '0002', 'PPP Modality'),
(9, '0003', 'Project Preparation Period (incld. Land acq.)'),
(92, '0099', 'Others'),
(29, '0101', 'Estimated Proj. Value (USD million)'),
(30, '0102', 'Land acquisition (USD million)'),
(31, '0103', 'Construction (USD million)'),
(32, '0104', 'Economic Feasibility (EIRR %)'),
(33, '0105', 'Economic Feasibility (ENPV USD million)'),
(34, '0106', 'Financial Feasibility (FIRR %)'),
(35, '0107', 'Financial Feasibility (FNPV USD million)'),
(36, '0108', 'Payback Period'),
(37, '0109', 'Intial Tariff (USD)'),
(38, '0110', 'Intial Tariff (IDR)'),
(39, '0111', 'Equity - Government Support (USD million)'),
(40, '0112', 'Equity - Government Support (%)'),
(41, '0113', 'Equity - Private (USD million)'),
(42, '0114', 'Equity - Private (%)'),
(43, '0115', 'Equity - Private Loan (USD million)'),
(44, '0116', 'Equity - Private Loan (%)'),
(45, '0199', 'Others'),
(46, '0201', 'Project scope'),
(48, '0301', 'Length (KM)'),
(49, '0302', 'Design Speed (km/h)'),
(50, '0303', 'Number of Lane'),
(51, '0304', 'Lane Width'),
(52, '0305', 'Outer shoulder width (m)'),
(53, '0306', 'Inner shoulder width (m)'),
(54, '0307', 'Median width (m)'),
(55, '0308', 'Right of way (m)'),
(56, '0309', 'Others'),
(60, '0202', 'Forecast/Projection demand'),
(62, '0401', 'Development of intake (lps)'),
(63, '0402', 'Development of water supply pipeline (ND – mm'),
(64, '0403', 'Development of Water Treatment Plant (units, '),
(65, '0404', 'Reservoir Development'),
(66, '0405', 'The development of distribution network (conn'),
(67, '0406', 'Inhabitants served (people)'),
(68, '0407', 'Land acquisition (m2)'),
(69, '0408', 'Land acquisition (ha)'),
(70, '0205', 'Current supply'),
(71, '0204', 'Current demand'),
(75, '0501', 'Waste disposal loading (ton/day)'),
(76, '0502', 'Annual increase estimated (%)'),
(77, '0503', 'Sanitary landfill specification'),
(78, '0504', 'Leachate capture and treatment'),
(79, '0505', 'Insect vector and odor control'),
(80, '0506', 'Daily operation (hours/day)'),
(81, '0507', 'Operations time (days/week)'),
(84, '0203', 'Forcast/Projection supply'),
(87, '0601', 'Project Specifications (Airport in detail)'),
(88, '0602', 'Project Background'),
(89, '0603', 'Project Urgency'),
(90, '0604', 'Project Benefit');

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
  `catatan` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idkontraktor`),
  KEY `idproject_profile` (`idproject_profile`,`idperusahaan`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabel kontraktor proyek - temp struktur' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `kontraktor`
--

INSERT INTO `kontraktor` (`idkontraktor`, `idproject_profile`, `idperusahaan`, `tgl_mulai`, `tgl_selesai`, `tahapan`, `catatan`) VALUES
(1, 13, 17, '2011-01-06', '2011-01-29', 'Investor', ''),
(2, 1, 5, '0000-00-00', '0000-00-00', 'Transaction', ''),
(3, 1, 1, '2011-01-03', '2011-01-05', 'Transaction', 'test'),
(4, 8, 15, '2011-01-08', '2011-01-16', 'Investor', 'hehe'),
(5, 7, 8, '2011-01-04', '2011-01-31', 'Transaction', 'boom'),
(6, 25, 12, '2011-01-01', '2011-06-24', 'PraFS', 'fffhhh');

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

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`idtemplate`, `tag`, `idcategory`) VALUES
(1, '110', 1),
(2, '120', 1),
(5, '0001', 13),
(6, '0002', 13),
(7, '0003', 13),
(8, '0099', 13),
(9, '0101', 14),
(11, '0102', 14),
(12, '0103', 14),
(17, '0108', 14),
(14, '0105', 14),
(15, '0104', 14),
(16, '0106', 14),
(18, '0107', 14),
(19, '0109', 14),
(20, '0110', 14),
(21, '0111', 14),
(22, '0112', 14),
(23, '0113', 14),
(24, '0114', 14),
(25, '0115', 13),
(26, '0116', 14),
(27, '0199', 14),
(36, '0303', 5),
(29, '0202', 5),
(35, '0302', 5),
(34, '0301', 5),
(32, '0201', 5),
(37, '0304', 5),
(38, '0305', 5),
(39, '0306', 5),
(40, '0307', 5),
(41, '0108', 5),
(42, '0308', 5),
(43, '0309', 5),
(44, '0201', 10),
(45, '0202', 10),
(46, '0203', 10),
(47, '0204', 10),
(48, '0205', 10),
(49, '0401', 10),
(50, '0402', 10),
(51, '0403', 10),
(52, '0404', 10),
(53, '0405', 10),
(54, '0406', 10),
(55, '0407', 10),
(56, '0408', 10),
(57, '0201', 15),
(58, '0202', 15),
(59, '0203', 15),
(60, '0204', 15),
(61, '0205', 15),
(62, '0501', 15),
(63, '0502', 15),
(64, '0503', 15),
(65, '0505', 15),
(66, '0505', 15),
(67, '0506', 15),
(68, '0507', 15),
(69, '0201', 3),
(70, '0202', 3),
(71, '0203', 3),
(72, '0204', 3),
(73, '0205', 3),
(74, '0601', 3),
(75, '0602', 3),
(76, '0603', 3),
(77, '0604', 3);

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
-- Dumping data for table `isian_ruas`
--

INSERT INTO `isian_ruas` (`idisian_ruas`, `tag`, `value`, `proyek_id`) VALUES
(1, '110', '500 m3', 1),
(2, '120', '100 m3', 1);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
