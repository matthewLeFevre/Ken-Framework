-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema literal
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema literal
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `literal` DEFAULT CHARACTER SET utf8 ;
USE `literal` ;

-- -----------------------------------------------------
-- Table `literal`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`user` ;

CREATE TABLE IF NOT EXISTS `literal`.`user` (
  `userId` INT NOT NULL AUTO_INCREMENT,
  `userName` VARCHAR(45) NULL,
  `userEmail` VARCHAR(45) NOT NULL,
  `userPassword` VARCHAR(255) NOT NULL,
  `userIsOnline` ENUM('yes', 'no') NULL,
  `userJoined` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userFirstName` VARCHAR(45) NULL,
  `userLastName` VARCHAR(45) NULL,
  `userStatus` ENUM('user', 'moderator', 'administrator') NOT NULL,
  PRIMARY KEY (`userId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`group` ;

CREATE TABLE IF NOT EXISTS `literal`.`group` (
  `groupId` INT NOT NULL,
  `groupCreated` DATETIME NOT NULL,
  `groupTitle` VARCHAR(45) NULL,
  PRIMARY KEY (`groupId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`message`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`message` ;

CREATE TABLE IF NOT EXISTS `literal`.`message` (
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
    REFERENCES `literal`.`group` (`groupId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_message_user1`
    FOREIGN KEY (`user_userId`)
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`post` ;

CREATE TABLE IF NOT EXISTS `literal`.`post` (
  `postId` INT NOT NULL AUTO_INCREMENT,
  `postCreated` DATETIME NOT NULL,
  `postModified` DATETIME NOT NULL,
  `postBody` TINYTEXT NOT NULL,
  `userId` INT NOT NULL,
  PRIMARY KEY (`postId`),
  INDEX `fk_post_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_post_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`asset`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`asset` ;

CREATE TABLE IF NOT EXISTS `literal`.`asset` (
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
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`user_has_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`user_has_group` ;

CREATE TABLE IF NOT EXISTS `literal`.`user_has_group` (
  `user_has_groupId` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `groupId` INT NOT NULL,
  PRIMARY KEY (`user_has_groupId`),
  INDEX `fk_user_has_group1_group1_idx` (`groupId` ASC),
  INDEX `fk_user_has_group1_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_user_has_group1_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_has_group1_group1`
    FOREIGN KEY (`groupId`)
    REFERENCES `literal`.`group` (`groupId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`user_has_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`user_has_group` ;

CREATE TABLE IF NOT EXISTS `literal`.`user_has_group` (
  `user_has_groupId` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `groupId` INT NOT NULL,
  PRIMARY KEY (`user_has_groupId`),
  INDEX `fk_user_has_group1_group1_idx` (`groupId` ASC),
  INDEX `fk_user_has_group1_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_user_has_group1_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_has_group1_group1`
    FOREIGN KEY (`groupId`)
    REFERENCES `literal`.`group` (`groupId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`article`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`article` ;

CREATE TABLE IF NOT EXISTS `literal`.`article` (
  `articleId` INT NOT NULL AUTO_INCREMENT,
  `articleTitle` VARCHAR(255) NOT NULL,
  `articleSummary` VARCHAR(255) NULL,
  `articleCreated` DATETIME NOT NULL,
  `articleBody` LONGTEXT NULL,
  `articleStatus` ENUM('saved', 'published') NOT NULL,
  `articleModified` DATETIME NULL,
  `articleLink` VARCHAR(255) NOT NULL,
  `articleLikedNumber` VARCHAR(45) NULL,
  `articleSharedNumber` VARCHAR(45) NULL,
  `userId` INT NOT NULL,
  PRIMARY KEY (`articleId`),
  INDEX `fk_article_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_article_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`comment` ;

CREATE TABLE IF NOT EXISTS `literal`.`comment` (
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
    REFERENCES `literal`.`post` (`postId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`user_userId`)
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_comment_article1`
    FOREIGN KEY (`article_articleId`)
    REFERENCES `literal`.`article` (`articleId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`userProfileImage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`userProfileImage` ;

CREATE TABLE IF NOT EXISTS `literal`.`userProfileImage` (
  `userProfileImage` INT NOT NULL AUTO_INCREMENT,
  `asset_assetId` INT NOT NULL,
  PRIMARY KEY (`userProfileImage`),
  INDEX `fk_table1_asset1_idx` (`asset_assetId` ASC),
  CONSTRAINT `fk_table1_asset1`
    FOREIGN KEY (`asset_assetId`)
    REFERENCES `literal`.`asset` (`assetId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`userProfile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`userProfile` ;

CREATE TABLE IF NOT EXISTS `literal`.`userProfile` (
  `userProfileId` INT NOT NULL AUTO_INCREMENT,
  `table1_userProfileImage` INT NOT NULL,
  `user_userId` INT NOT NULL,
  `userProfileBio` VARCHAR(555) NULL,
  PRIMARY KEY (`userProfileId`),
  INDEX `fk_userProfile_table11_idx` (`table1_userProfileImage` ASC),
  INDEX `fk_userProfile_user1_idx` (`user_userId` ASC),
  CONSTRAINT `fk_userProfile_table11`
    FOREIGN KEY (`table1_userProfileImage`)
    REFERENCES `literal`.`userProfileImage` (`userProfileImage`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_userProfile_user1`
    FOREIGN KEY (`user_userId`)
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`asset_assignment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`asset_assignment` ;

CREATE TABLE IF NOT EXISTS `literal`.`asset_assignment` (
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
    REFERENCES `literal`.`asset` (`assetId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_asset_assignment_post1`
    FOREIGN KEY (`post_postId`)
    REFERENCES `literal`.`post` (`postId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_asset_assignment_message1`
    FOREIGN KEY (`messageId`)
    REFERENCES `literal`.`message` (`messageId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_asset_assignment_article1`
    FOREIGN KEY (`articleId`)
    REFERENCES `literal`.`article` (`articleId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`project` ;

CREATE TABLE IF NOT EXISTS `literal`.`project` (
  `projectId` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `projectStatus` VARCHAR(45) NOT NULL,
  `projectTitle` VARCHAR(255) NOT NULL,
  `projectCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `projectDescription` MEDIUMTEXT NULL,
  `projectImage` VARCHAR(255) NULL,
  PRIMARY KEY (`projectId`),
  INDEX `fk_project_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_project_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `literal`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`styleGuide`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`styleGuide` ;

CREATE TABLE IF NOT EXISTS `literal`.`styleGuide` (
  `styleGuideId` INT NOT NULL AUTO_INCREMENT,
  `projectId` INT NOT NULL,
  `styleGuideTitle` VARCHAR(255) NOT NULL,
  `styleGuideStatus` VARCHAR(45) NOT NULL,
  `styleGuideCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `styleGuideDescription` MEDIUMTEXT NULL,
  PRIMARY KEY (`styleGuideId`),
  INDEX `fk_styleguide_project1_idx` (`projectId` ASC),
  CONSTRAINT `fk_styleguide_project1`
    FOREIGN KEY (`projectId`)
    REFERENCES `literal`.`project` (`projectId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`section`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`section` ;

CREATE TABLE IF NOT EXISTS `literal`.`section` (
  `sectionId` INT NOT NULL AUTO_INCREMENT,
  `styleGuideId` INT NOT NULL,
  `sectionTitle` VARCHAR(255) NOT NULL,
  `itemOrder` INT NOT NULL,
  `sectionCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sectionDescription` TINYTEXT NULL,
  PRIMARY KEY (`sectionId`),
  INDEX `fk_section_styleguide1_idx` (`styleGuideId` ASC),
  CONSTRAINT `fk_section_styleguide1`
    FOREIGN KEY (`styleGuideId`)
    REFERENCES `literal`.`styleGuide` (`styleGuideId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`textBox`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`textBox` ;

CREATE TABLE IF NOT EXISTS `literal`.`textBox` (
  `textBoxId` INT NOT NULL AUTO_INCREMENT,
  `sectionId` INT NOT NULL,
  `textBoxText` MEDIUMTEXT NOT NULL,
  `textBoxCreated` DATETIME NOT NULL,
  `itemOrder` INT NOT NULL,
  `itemType` ENUM('textBox') NOT NULL DEFAULT 'textBox',
  PRIMARY KEY (`textBoxId`),
  INDEX `fk_textbox_section1_idx` (`sectionId` ASC),
  CONSTRAINT `fk_textbox_section1`
    FOREIGN KEY (`sectionId`)
    REFERENCES `literal`.`section` (`sectionId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`heading`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`heading` ;

CREATE TABLE IF NOT EXISTS `literal`.`heading` (
  `headingId` INT NOT NULL AUTO_INCREMENT,
  `sectionId` INT NOT NULL,
  `headingText` VARCHAR(255) NOT NULL,
  `headingCreated` DATETIME NOT NULL,
  `itemOrder` VARCHAR(45) NOT NULL,
  `itemType` ENUM('heading') NOT NULL DEFAULT 'heading',
  PRIMARY KEY (`headingId`),
  INDEX `fk_heading_section1_idx` (`sectionId` ASC),
  CONSTRAINT `fk_heading_section1`
    FOREIGN KEY (`sectionId`)
    REFERENCES `literal`.`section` (`sectionId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`colorPallet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`colorPallet` ;

CREATE TABLE IF NOT EXISTS `literal`.`colorPallet` (
  `colorPalletId` INT NOT NULL AUTO_INCREMENT,
  `sectionId` INT NOT NULL,
  `itemOrder` INT NOT NULL,
  `itemType` ENUM('colorPallet') NOT NULL DEFAULT 'colorPallet',
  PRIMARY KEY (`colorPalletId`),
  INDEX `fk_colorpallet_section1_idx` (`sectionId` ASC),
  CONSTRAINT `fk_colorpallet_section1`
    FOREIGN KEY (`sectionId`)
    REFERENCES `literal`.`section` (`sectionId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`font`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`font` ;

CREATE TABLE IF NOT EXISTS `literal`.`font` (
  `fontId` INT NOT NULL AUTO_INCREMENT,
  `sectionId` INT NOT NULL,
  `fontUrl` VARCHAR(255) NOT NULL,
  `itemOrder` INT NOT NULL,
  `fontFamily` VARCHAR(45) NOT NULL,
  `itemType` ENUM('font') NOT NULL DEFAULT 'font',
  PRIMARY KEY (`fontId`),
  INDEX `fk_font_section1_idx` (`sectionId` ASC),
  CONSTRAINT `fk_font_section1`
    FOREIGN KEY (`sectionId`)
    REFERENCES `literal`.`section` (`sectionId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`image` ;

CREATE TABLE IF NOT EXISTS `literal`.`image` (
  `imageId` INT NOT NULL AUTO_INCREMENT,
  `sectionId` INT NOT NULL,
  `asset_assetId` INT NULL,
  `itemOrder` INT NOT NULL,
  `imageUrl` VARCHAR(255) NULL,
  `itemType` ENUM('image') NOT NULL DEFAULT 'image',
  PRIMARY KEY (`imageId`),
  INDEX `fk_image_section1_idx` (`sectionId` ASC),
  INDEX `fk_image_asset1_idx` (`asset_assetId` ASC),
  CONSTRAINT `fk_image_section1`
    FOREIGN KEY (`sectionId`)
    REFERENCES `literal`.`section` (`sectionId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_image_asset1`
    FOREIGN KEY (`asset_assetId`)
    REFERENCES `literal`.`asset` (`assetId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `literal`.`colorSwatch`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `literal`.`colorSwatch` ;

CREATE TABLE IF NOT EXISTS `literal`.`colorSwatch` (
  `colorSwatchId` INT NOT NULL AUTO_INCREMENT,
  `colorSwatchHex` VARCHAR(7) NOT NULL,
  `itemOrder` INT NOT NULL,
  `colorSwatchTitle` VARCHAR(45) NULL,
  `colorSwatchVar` VARCHAR(45) NULL,
  `colorSwatchRGB` VARCHAR(17) NULL,
  `colorPalletId` INT NOT NULL,
  PRIMARY KEY (`colorSwatchId`),
  INDEX `fk_colorSwatch_colorPallet1_idx` (`colorPalletId` ASC),
  CONSTRAINT `fk_colorSwatch_colorPallet1`
    FOREIGN KEY (`colorPalletId`)
    REFERENCES `literal`.`colorPallet` (`colorPalletId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
