-- Add table for kontrak information
-- This table should be added manually

ALTER TABLE `kontraktor` 
ADD `pcss_no` varchar(25) collate utf8_unicode_ci NOT NULL AFTER `tahapan`,
ADD `pcss_date` date NOT NULL AFTER `pcss_no`,
ADD `no_kontrak` varchar(25) collate utf8_unicode_ci NOT NULL AFTER `pcss_date`,
ADD `tgl_disetujui` date NOT NULL AFTER `no_kontrak` ; 
