-- MySQL Workbench Synchronization
-- Generated: 2017-03-02 16:21
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Unknown

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `mydb`.`sessions_has_oeuvres` 
DROP FOREIGN KEY `fk_sessions_has_oeuvres_oeuvres1`;

ALTER TABLE `mydb`.`oeuvres` 
DROP COLUMN `auteur`,
CHANGE COLUMN `id` `id_oeuvre` INT(11) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `date` `date` VARCHAR(60) NULL DEFAULT NULL COMMENT 'c\'est un var char pour mettre n\'importe quel format (si oeuvre ancienne on peut se retrouver avec du 500AC)' ,
ADD COLUMN `url_image` VARCHAR(1000) NULL DEFAULT NULL AFTER `description`,
ADD COLUMN `auteurs_id_auteurs` INT(11) NOT NULL AFTER `url_image`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id_oeuvre`, `auteurs_id_auteurs`),
ADD INDEX `fk_oeuvres_auteurs1_idx` (`auteurs_id_auteurs` ASC);

ALTER TABLE `mydb`.`sessions` 
CHANGE COLUMN `id` `id_session` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `mydb`.`sessions_has_oeuvres` 
CHANGE COLUMN `sessions_id` `id_sessions` INT(11) NOT NULL ,
CHANGE COLUMN `oeuvres_id` `id_oeuvres` INT(11) NOT NULL ;

CREATE TABLE IF NOT EXISTS `mydb`.`auteurs` (
  `id_auteurs` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_auteurs`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `mydb`.`oeuvres` 
ADD CONSTRAINT `fk_oeuvres_auteurs1`
  FOREIGN KEY (`auteurs_id_auteurs`)
  REFERENCES `mydb`.`auteurs` (`id_auteurs`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mydb`.`sessions_has_oeuvres` 
DROP FOREIGN KEY `fk_sessions_has_oeuvres_sessions`;

ALTER TABLE `mydb`.`sessions_has_oeuvres` ADD CONSTRAINT `fk_sessions_has_oeuvres_sessions`
  FOREIGN KEY (`id_sessions`)
  REFERENCES `mydb`.`sessions` (`id_session`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_sessions_has_oeuvres_oeuvres1`
  FOREIGN KEY (`id_oeuvres`)
  REFERENCES `mydb`.`oeuvres` (`id_oeuvre`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
