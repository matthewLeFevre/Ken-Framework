-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema kenDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema kenDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kenDB` DEFAULT CHARACTER SET utf8 ;
USE `kenDB` ;

-- -----------------------------------------------------
-- Table `kenDB`.`account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kenDB`.`account` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `passHash` VARCHAR(255) NOT NULL,
  `created` DATETIME NOT NULL,
  `verification` ENUM('verified', 'notVerified') NOT NULL DEFAULT 'notVerified',
  `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
