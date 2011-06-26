SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`kategori`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`kategori` (
  `idkategori` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`idkategori`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`loan`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`loan` (
  `idloan` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`idloan`) ,
  UNIQUE INDEX `idloan_UNIQUE` (`idloan` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`group` (
  `idgroup` INT NOT NULL AUTO_INCREMENT ,
  `group` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idgroup`) ,
  UNIQUE INDEX `group_UNIQUE` (`group` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`pic`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`pic` (
  `idpic` INT NOT NULL AUTO_INCREMENT ,
  `nama` VARCHAR(45) NOT NULL ,
  `group` INT NULL ,
  `password` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `phone` VARCHAR(45) NULL ,
  `hp` VARCHAR(45) NULL ,
  `fax` VARCHAR(45) NULL ,
  PRIMARY KEY (`idpic`) ,
  INDEX `fk_pic_group1` (`group` ASC) ,
  CONSTRAINT `fk_pic_group1`
    FOREIGN KEY (`group` )
    REFERENCES `mydb`.`group` (`idgroup` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`project_profile`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`project_profile` (
  `idproject_profile` INT NOT NULL AUTO_INCREMENT ,
  `pin` VARCHAR(10) NOT NULL ,
  `nama` VARCHAR(100) NOT NULL ,
  `ppp_book_code` VARCHAR(45) NOT NULL ,
  `usulan_lpd` VARCHAR(45) NOT NULL ,
  `lokasi` VARCHAR(45) NULL ,
  `bpsid_propinsi` VARCHAR(10) NOT NULL ,
  `id_kategori` INT NULL ,
  `id_loan` INT NULL ,
  `surat_lpd` VARCHAR(45) NULL ,
  `appr_dprd` VARCHAR(45) NULL ,
  `ppp_form` VARCHAR(45) NULL ,
  `doc_fs` VARCHAR(45) NULL ,
  `tgl_usulan` DATE NULL ,
  `tgl_diisi` DATE NULL ,
  `tgl_revisi` DATE NULL ,
  `idoperator` INT NULL ,
  PRIMARY KEY (`idproject_profile`) ,
  UNIQUE INDEX `pin_UNIQUE` (`pin` ASC) ,
  INDEX `fk_project_profile_kategori` (`id_kategori` ASC) ,
  INDEX `fk_project_profile_loan1` (`id_loan` ASC) ,
  INDEX `fk_project_profile_pic1` (`idoperator` ASC) ,
  CONSTRAINT `fk_project_profile_kategori`
    FOREIGN KEY (`id_kategori` )
    REFERENCES `mydb`.`kategori` (`idkategori` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_profile_loan1`
    FOREIGN KEY (`id_loan` )
    REFERENCES `mydb`.`loan` (`idloan` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_profile_pic1`
    FOREIGN KEY (`idoperator` )
    REFERENCES `mydb`.`pic` (`idpic` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`perusahaan`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`perusahaan` (
  `idperusahaan` INT NOT NULL AUTO_INCREMENT ,
  `nama` VARCHAR(100) NULL ,
  `jenis` VARCHAR(45) NULL ,
  `alamat` VARCHAR(45) NULL ,
  `telpon` VARCHAR(45) NULL ,
  `hp` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `website` VARCHAR(45) NULL ,
  PRIMARY KEY (`idperusahaan`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`dokumen`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`dokumen` (
  `iddokumen` INT NOT NULL AUTO_INCREMENT ,
  `judul_dokumen` VARCHAR(200) NULL ,
  `nama_berkas` VARCHAR(200) NULL ,
  `idoperator` VARCHAR(45) NULL ,
  `tgl_diisi` DATE NULL ,
  `tgl_revisi` DATE NULL ,
  PRIMARY KEY (`iddokumen`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`ref_status`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`ref_status` (
  `idref_status` INT NOT NULL AUTO_INCREMENT ,
  `tahap` VARCHAR(5) NOT NULL ,
  `status` VARCHAR(45) NOT NULL ,
  `id_detil` INT NOT NULL ,
  `detil_status` VARCHAR(250) NOT NULL ,
  `kode_status` VARCHAR(15) NOT NULL ,
  `formulir` VARCHAR(45) NULL ,
  `idpic` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idref_status`) ,
  UNIQUE INDEX `kode_status_UNIQUE` (`kode_status` ASC) ,
  INDEX `status` (`detil_status` ASC, `status` ASC) ,
  INDEX `fk_ref_status_pic1` (`idpic` ASC) ,
  CONSTRAINT `fk_ref_status_pic10`
    FOREIGN KEY (`idpic` )
    REFERENCES `mydb`.`pic` (`idpic` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mydb`.`proj_flow`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`proj_flow` (
  `idproj_flow` INT NOT NULL ,
  `kegiatan` VARCHAR(100) NOT NULL ,
  `tgl_rencana` DATE NOT NULL ,
  `pic` INT NOT NULL ,
  `status` VARCHAR(45) NOT NULL DEFAULT 'on going' ,
  `idproject_profile` INT NOT NULL ,
  `idref_status` INT NOT NULL ,
  PRIMARY KEY (`idproj_flow`) ,
  INDEX `fk_proj_flow_project_profile1` (`idproject_profile` ASC) ,
  INDEX `fk_proj_flow_ref_status1` (`idref_status` ASC) ,
  CONSTRAINT `fk_proj_flow_project_profile1`
    FOREIGN KEY (`idproject_profile` )
    REFERENCES `mydb`.`project_profile` (`idproject_profile` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proj_flow_ref_status1`
    FOREIGN KEY (`idref_status` )
    REFERENCES `mydb`.`ref_status` (`idref_status` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`ref_status_project_profile`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`ref_status_project_profile` (
  `idstatusproject` INT NOT NULL AUTO_INCREMENT ,
  `idref_status` INT NOT NULL ,
  `idproject_profile` INT NOT NULL ,
  `tgl_mulai` DATE NULL ,
  `tgl_akhir` DATE NULL ,
  `status_akhir` VARCHAR(45) NULL ,
  `tgl_diisi` DATE NULL ,
  `tgl_revisi` DATE NULL ,
  `idoperator` INT NULL ,
  PRIMARY KEY (`idstatusproject`, `idref_status`, `idproject_profile`) ,
  INDEX `fk_ref_status_has_project_profile_project_profile1` (`idproject_profile` ASC) ,
  CONSTRAINT `fk_ref_status_has_project_profile_project_profile1`
    FOREIGN KEY (`idproject_profile` )
    REFERENCES `mydb`.`project_profile` (`idproject_profile` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ref_status_project_profile_proj_flow1`
    FOREIGN KEY (`idproject_profile` )
    REFERENCES `mydb`.`proj_flow` (`idproj_flow` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mydb`.`ref_kegiatan`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`ref_kegiatan` (
  `idref_kegiatan` INT NOT NULL ,
  `kegiatan` VARCHAR(45) NOT NULL ,
  `deskripsi` TEXT NOT NULL ,
  PRIMARY KEY (`idref_kegiatan`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`ref_required`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`ref_required` (
  `idref_required` INT NOT NULL AUTO_INCREMENT ,
  `id_kegiatan` INT NOT NULL ,
  `pic` INT NOT NULL ,
  `kode_status` INT NOT NULL ,
  PRIMARY KEY (`idref_required`) ,
  INDEX `fk_ref_required_ref_kegiatan1` (`id_kegiatan` ASC) ,
  INDEX `fk_ref_required_ref_status1` (`kode_status` ASC) ,
  CONSTRAINT `fk_ref_required_ref_kegiatan1`
    FOREIGN KEY (`id_kegiatan` )
    REFERENCES `mydb`.`ref_kegiatan` (`idref_kegiatan` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ref_required_ref_status1`
    FOREIGN KEY (`kode_status` )
    REFERENCES `mydb`.`ref_status` (`kode_status` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`cerita`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`cerita` (
  `idcerita` INT NOT NULL AUTO_INCREMENT ,
  `idproj_flow` INT NOT NULL ,
  `tgl_cerita` DATE NOT NULL ,
  `deskripsi` TEXT NOT NULL ,
  `follow_up` TEXT NULL ,
  `idpic` INT NOT NULL ,
  PRIMARY KEY (`idcerita`) ,
  INDEX `fk_cerita_proj_flow1` (`idproj_flow` ASC) ,
  CONSTRAINT `fk_cerita_proj_flow1`
    FOREIGN KEY (`idproj_flow` )
    REFERENCES `mydb`.`proj_flow` (`idproj_flow` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`perusahaan`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`perusahaan` (
  `idperusahaan` INT NOT NULL AUTO_INCREMENT ,
  `nama` VARCHAR(100) NULL ,
  `jenis` VARCHAR(45) NULL ,
  `alamat` VARCHAR(45) NULL ,
  `telpon` VARCHAR(45) NULL ,
  `hp` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `website` VARCHAR(45) NULL ,
  PRIMARY KEY (`idperusahaan`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`peserta_tender`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`peserta_tender` (
  `idpeserta_tender` INT NOT NULL AUTO_INCREMENT ,
  `idproj_flow` INT NOT NULL ,
  `idperusahaan` INT NOT NULL ,
  `tgl_daftar` DATE NULL ,
  `status` VARCHAR(45) NULL ,
  PRIMARY KEY (`idpeserta_tender`, `idproj_flow`, `idperusahaan`) ,
  INDEX `fk_proj_flow_has_perusahaan_perusahaan1` (`idperusahaan` ASC) ,
  CONSTRAINT `fk_proj_flow_has_perusahaan_proj_flow1`
    FOREIGN KEY (`idproj_flow` )
    REFERENCES `mydb`.`proj_flow` (`idproj_flow` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proj_flow_has_perusahaan_perusahaan1`
    FOREIGN KEY (`idperusahaan` )
    REFERENCES `mydb`.`perusahaan` (`idperusahaan` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `mydb`.`jenis_dok`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`jenis_dok` (
  `idjenis_dok` INT NOT NULL AUTO_INCREMENT ,
  `jenis_dok` VARCHAR(45) NULL ,
  `idpeserta_tender` INT NULL ,
  `idproject_profile` INT NULL ,
  `idkeuangan` INT NULL ,
  `idstatus_project` INT NULL ,
  `iddokumen` INT NULL ,
  `tgl_upload` DATE NULL ,
  `idoperator` INT NULL ,
  `nama_berkas` VARCHAR(100) NULL ,
  PRIMARY KEY (`idjenis_dok`) ,
  INDEX `fk_jenis_dok_dokumen1` (`iddokumen` ASC) ,
  INDEX `fk_jenis_dok_peserta_tender1` (`idpeserta_tender` ASC) ,
  INDEX `fk_jenis_dok_proj_flow1` (`idstatus_project` ASC) ,
  INDEX `fk_jenis_dok_project_profile1` (`idproject_profile` ASC) ,
  CONSTRAINT `fk_jenis_dok_dokumen1`
    FOREIGN KEY (`iddokumen` )
    REFERENCES `mydb`.`dokumen` (`iddokumen` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_jenis_dok_peserta_tender1`
    FOREIGN KEY (`idpeserta_tender` )
    REFERENCES `mydb`.`peserta_tender` (`idpeserta_tender` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_jenis_dok_proj_flow1`
    FOREIGN KEY (`idstatus_project` )
    REFERENCES `mydb`.`proj_flow` (`idproj_flow` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_jenis_dok_project_profile1`
    FOREIGN KEY (`idproject_profile` )
    REFERENCES `mydb`.`project_profile` (`idproject_profile` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
