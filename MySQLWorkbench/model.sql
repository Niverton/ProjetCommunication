-- MySQL Workbench Synchronization
-- Generated: 2017-03-02 16:50
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Unknown

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `mydb`.`oeuvres` 
DROP FOREIGN KEY `fk_oeuvres_auteurs1`;

ALTER TABLE `mydb`.`oeuvres` 
CHANGE COLUMN `url_image` `url_image` VARCHAR(2000) NULL DEFAULT NULL ,
CHANGE COLUMN `auteurs_id_auteurs` `auteur_id_auteurs` INT(11) NOT NULL ;

ALTER TABLE `mydb`.`sessions` 
ADD COLUMN `description` LONGTEXT NULL DEFAULT NULL AFTER `date_fin`;

ALTER TABLE `mydb`.`auteurs` 
CHANGE COLUMN `id_auteurs` `id_auteur` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `mydb`.`oeuvres` 
ADD CONSTRAINT `fk_oeuvres_auteurs1`
  FOREIGN KEY (`auteur_id_auteurs`)
  REFERENCES `mydb`.`auteurs` (`id_auteur`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
