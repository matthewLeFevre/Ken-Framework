-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema matthil3_courtneyblog
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema matthil3_courtneyblog
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `matthil3_courtneyblog` DEFAULT CHARACTER SET utf8 ;
USE `matthil3_courtneyblog` ;

-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`user` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`user` (
  `userId` INT NOT NULL AUTO_INCREMENT,
  `userName` VARCHAR(45) NULL,
  `userEmail` VARCHAR(45) NOT NULL,
  `userPassword` VARCHAR(255) NOT NULL,
  `userIsOnline` ENUM('yes', 'no') NULL,
  `userJoined` DATETIME NOT NULL,
  `userFirstName` VARCHAR(45) NULL,
  `userLastName` VARCHAR(45) NULL,
  `userStatus` ENUM('user', 'moderator', 'administrator') NOT NULL,
  PRIMARY KEY (`userId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`group` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`group` (
  `groupId` INT NOT NULL,
  `groupCreated` DATETIME NOT NULL,
  `groupTitle` VARCHAR(45) NULL,
  PRIMARY KEY (`groupId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`message`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`message` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`message` (
  `messageId` INT NOT NULL AUTO_INCREMENT,
  `messageBody` VARCHAR(255) NOT NULL,
  `messageCreated` VARCHAR(45) NOT NULL,
  `group_groupId` INT NOT NULL,
  `user_userId` INT NOT NULL,
  PRIMARY KEY (`messageId`),
  INDEX `fk_message_group1_idx` (`group_groupId` ASC),
  INDEX `fk_message_user1_idx` (`user_userId` ASC),
  CONSTRAINT `fk_message_group1`
    FOREIGN KEY (`group_groupId`)
    REFERENCES `matthil3_courtneyblog`.`group` (`groupId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_message_user1`
    FOREIGN KEY (`user_userId`)
    REFERENCES `matthil3_courtneyblog`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`post` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`post` (
  `postId` INT NOT NULL AUTO_INCREMENT,
  `postCreated` DATETIME NOT NULL,
  `postModified` DATETIME NOT NULL,
  `postBody` TINYTEXT NOT NULL,
  `userId` INT NOT NULL,
  PRIMARY KEY (`postId`),
  INDEX `fk_post_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_post_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `matthil3_courtneyblog`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`asset`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`asset` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`asset` (
  `assetId` INT NOT NULL AUTO_INCREMENT,
  `assetPath` VARCHAR(255) NOT NULL,
  `assetName` VARCHAR(45) NOT NULL,
  `assetType` ENUM('img', 'video', 'document') NOT NULL,
  `assetCreated` DATETIME NOT NULL,
  `assetStatus` ENUM('saved', 'published') NOT NULL,
  `assetModified` DATETIME NULL,
  `userId` INT NOT NULL,
  PRIMARY KEY (`assetId`),
  INDEX `fk_asset_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_asset_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `matthil3_courtneyblog`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`user_has_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`user_has_group` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`user_has_group` (
  `user_has_groupcol` VARCHAR(45) NOT NULL,
  `user_userId` INT NOT NULL,
  `group_groupId` INT NOT NULL,
  PRIMARY KEY (`user_has_groupcol`),
  INDEX `fk_user_has_group_group1_idx` (`group_groupId` ASC),
  INDEX `fk_user_has_group_user1_idx` (`user_userId` ASC),
  UNIQUE INDEX `user_has_groupcol_UNIQUE` (`user_has_groupcol` ASC),
  CONSTRAINT `fk_user_has_group_user1`
    FOREIGN KEY (`user_userId`)
    REFERENCES `matthil3_courtneyblog`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_has_group_group1`
    FOREIGN KEY (`group_groupId`)
    REFERENCES `matthil3_courtneyblog`.`group` (`groupId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`user_has_group1`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`user_has_group1` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`user_has_group1` (
  `user_userId` INT NOT NULL,
  `group_groupId` INT NOT NULL,
  PRIMARY KEY (`user_userId`, `group_groupId`),
  INDEX `fk_user_has_group1_group1_idx` (`group_groupId` ASC),
  INDEX `fk_user_has_group1_user1_idx` (`user_userId` ASC),
  CONSTRAINT `fk_user_has_group1_user1`
    FOREIGN KEY (`user_userId`)
    REFERENCES `matthil3_courtneyblog`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_has_group1_group1`
    FOREIGN KEY (`group_groupId`)
    REFERENCES `matthil3_courtneyblog`.`group` (`groupId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`article`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`article` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`article` (
  `articleId` INT NOT NULL AUTO_INCREMENT,
  `articleTitle` VARCHAR(255) NOT NULL,
  `articleSummary` VARCHAR(255) NULL,
  `articleCreated` DATETIME NOT NULL,
  `articleBody` LONGTEXT NULL,
  `articleStatus` ENUM('saved', 'published') NOT NULL,
  `articleModified` DATETIME NULL,
  `articleLink` VARCHAR(255) NULL,
  `articleLikedNumber` VARCHAR(45) NULL,
  `articleSharedNumber` VARCHAR(45) NULL,
  `userId` INT NOT NULL,
  `articleImagePath` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`articleId`),
  INDEX `fk_article_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_article_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `matthil3_courtneyblog`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`comment` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`comment` (
  `commentId` INT NOT NULL AUTO_INCREMENT,
  `commentCreated` DATETIME NOT NULL,
  `commentBody` VARCHAR(255) NOT NULL,
  `post_postId` INT NULL,
  `user_userId` INT NOT NULL,
  `article_articleId` INT NULL,
  PRIMARY KEY (`commentId`),
  INDEX `fk_comment_post1_idx` (`post_postId` ASC),
  INDEX `fk_comment_user1_idx` (`user_userId` ASC),
  INDEX `fk_comment_article1_idx` (`article_articleId` ASC),
  CONSTRAINT `fk_comment_post1`
    FOREIGN KEY (`post_postId`)
    REFERENCES `matthil3_courtneyblog`.`post` (`postId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`user_userId`)
    REFERENCES `matthil3_courtneyblog`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_comment_article1`
    FOREIGN KEY (`article_articleId`)
    REFERENCES `matthil3_courtneyblog`.`article` (`articleId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`userProfileImage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`userProfileImage` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`userProfileImage` (
  `userProfileImage` INT NOT NULL AUTO_INCREMENT,
  `asset_assetId` INT NOT NULL,
  PRIMARY KEY (`userProfileImage`),
  INDEX `fk_table1_asset1_idx` (`asset_assetId` ASC),
  CONSTRAINT `fk_table1_asset1`
    FOREIGN KEY (`asset_assetId`)
    REFERENCES `matthil3_courtneyblog`.`asset` (`assetId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`userProfile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`userProfile` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`userProfile` (
  `userProfileId` INT NOT NULL AUTO_INCREMENT,
  `table1_userProfileImage` INT NOT NULL,
  `user_userId` INT NOT NULL,
  `userProfileBio` VARCHAR(555) NULL,
  PRIMARY KEY (`userProfileId`),
  INDEX `fk_userProfile_table11_idx` (`table1_userProfileImage` ASC),
  INDEX `fk_userProfile_user1_idx` (`user_userId` ASC),
  CONSTRAINT `fk_userProfile_table11`
    FOREIGN KEY (`table1_userProfileImage`)
    REFERENCES `matthil3_courtneyblog`.`userProfileImage` (`userProfileImage`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_userProfile_user1`
    FOREIGN KEY (`user_userId`)
    REFERENCES `matthil3_courtneyblog`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matthil3_courtneyblog`.`asset_assignment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `matthil3_courtneyblog`.`asset_assignment` ;

CREATE TABLE IF NOT EXISTS `matthil3_courtneyblog`.`asset_assignment` (
  `assignmentId` INT NOT NULL AUTO_INCREMENT,
  `assetId` INT NOT NULL,
  `post_postId` INT NULL,
  `messageId` INT NULL,
  `articleId` INT NULL,
  PRIMARY KEY (`assignmentId`),
  INDEX `fk_asset_assignment_asset1_idx` (`assetId` ASC),
  INDEX `fk_asset_assignment_post1_idx` (`post_postId` ASC),
  INDEX `fk_asset_assignment_message1_idx` (`messageId` ASC),
  INDEX `fk_asset_assignment_article1_idx` (`articleId` ASC),
  CONSTRAINT `fk_asset_assignment_asset1`
    FOREIGN KEY (`assetId`)
    REFERENCES `matthil3_courtneyblog`.`asset` (`assetId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_asset_assignment_post1`
    FOREIGN KEY (`post_postId`)
    REFERENCES `matthil3_courtneyblog`.`post` (`postId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_asset_assignment_message1`
    FOREIGN KEY (`messageId`)
    REFERENCES `matthil3_courtneyblog`.`message` (`messageId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_asset_assignment_article1`
    FOREIGN KEY (`articleId`)
    REFERENCES `matthil3_courtneyblog`.`article` (`articleId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
