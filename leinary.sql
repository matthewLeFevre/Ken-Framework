-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema leinary
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema leinary
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `leinary` DEFAULT CHARACTER SET utf8 ;
USE `leinary` ;

-- -----------------------------------------------------
-- Table `leinary`.`account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `leinary`.`account` (
  `account_id` INT NOT NULL AUTO_INCREMENT,
  `account_name` VARCHAR(45) NULL,
  `account_status` ENUM('active', 'inactive') NOT NULL DEFAULT 'inactive',
  `account_role` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  `account_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`account_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `leinary`.`email`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `leinary`.`email` (
  `email_id` INT NOT NULL AUTO_INCREMENT,
  `email_address` VARCHAR(45) NOT NULL,
  `email_status` ENUM('valid', 'invalid') NOT NULL DEFAULT 'invalid',
  `email_code` CHAR(4) NOT NULL,
  `account_id` INT NOT NULL,
  PRIMARY KEY (`email_id`),
  INDEX `fk_email_account_idx` (`account_id` ASC),
  CONSTRAINT `fk_email_account`
    FOREIGN KEY (`account_id`)
    REFERENCES `leinary`.`account` (`account_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `leinary`.`pass`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `leinary`.`pass` (
  `pass_id` INT NOT NULL AUTO_INCREMENT,
  `pass_hash` VARCHAR(255) NOT NULL,
  `account_id` INT NOT NULL,
  PRIMARY KEY (`pass_id`),
  INDEX `fk_pass_account1_idx` (`account_id` ASC),
  CONSTRAINT `fk_pass_account1`
    FOREIGN KEY (`account_id`)
    REFERENCES `leinary`.`account` (`account_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
