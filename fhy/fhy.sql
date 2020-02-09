/*
Navicat MySQL Data Transfer

Source Server         : fhy
Source Server Version : 80018
Source Host           : localhost:3306
Source Database       : fhy

Target Server Type    : MYSQL
Target Server Version : 80018
File Encoding         : 65001

Date: 2019-12-22 00:00:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `accessor`
-- ----------------------------
DROP TABLE IF EXISTS `accessor`;
CREATE TABLE `accessor` (
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of accessor
-- ----------------------------
INSERT INTO `accessor` VALUES ('acc', '123');

-- ----------------------------
-- Table structure for `cargo`
-- ----------------------------
DROP TABLE IF EXISTS `cargo`;
CREATE TABLE `cargo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `goodname` varchar(20) NOT NULL,
  `kind` varchar(20) NOT NULL,
  `pack` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `unit` varchar(20) NOT NULL,
  `length` double(20,0) NOT NULL,
  `width` double(20,0) NOT NULL,
  `height` double(20,0) NOT NULL,
  `weight` double(20,0) NOT NULL,
  `temp` double(20,0) NOT NULL,
  `deadline` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1239 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cargo
-- ----------------------------
INSERT INTO `cargo` VALUES ('1235', 'qwe', 'qwe', 'qwe', 'qwe', '1111', '112', '111', '111', '12', '12');
INSERT INTO `cargo` VALUES ('1236', 'adasd', 'asd', 'asd', 'ads', '11', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for `contact`
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customid` int(10) DEFAULT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fax` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`,`name`),
  KEY `kehu1` (`customid`),
  CONSTRAINT `kehu1` FOREIGN KEY (`customid`) REFERENCES `custom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contact
-- ----------------------------

-- ----------------------------
-- Table structure for `custom`
-- ----------------------------
DROP TABLE IF EXISTS `custom`;
CREATE TABLE `custom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ename` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `area` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `principle` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prinphone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `location` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `postcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bank` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bankaccount` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom
-- ----------------------------
INSERT INTO `custom` VALUES ('12', 'wdq', 'sdfa', 'afsd', 'sdaf', 'adf', 'asdf', 'sdaf', 'sdasdsad', 'sdaf', 'sdf', 'adfs');
INSERT INTO `custom` VALUES ('14', 'adsa', 'asd', 'ads', 'ad', 'asd', 'asdasd', 'ad', 'asd', 'asd', 'asd', 'asd');

-- ----------------------------
-- Table structure for `datamanager`
-- ----------------------------
DROP TABLE IF EXISTS `datamanager`;
CREATE TABLE `datamanager` (
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of datamanager
-- ----------------------------
INSERT INTO `datamanager` VALUES ('fhy', '123');

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customid` int(10) NOT NULL,
  `date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sender` varchar(20) NOT NULL,
  `sphone` varchar(20) NOT NULL,
  `slocation` varchar(20) NOT NULL,
  `sprinciple` varchar(20) NOT NULL,
  `semail` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `rphone` varchar(20) NOT NULL,
  `rlocation` varchar(20) NOT NULL,
  `rprinciple` varchar(20) NOT NULL,
  `remail` varchar(20) NOT NULL,
  `check` varchar(20) NOT NULL,
  `idea` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kehu2` (`customid`),
  CONSTRAINT `kehu2` FOREIGN KEY (`customid`) REFERENCES `custom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for `orderdetail`
-- ----------------------------
DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE `orderdetail` (
  `orderid` int(10) DEFAULT NULL,
  `cargoid` int(10) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  KEY `cargoid` (`cargoid`),
  KEY `orderid` (`orderid`),
  CONSTRAINT `cargoid` FOREIGN KEY (`cargoid`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orderid` FOREIGN KEY (`orderid`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orderdetail
-- ----------------------------

-- ----------------------------
-- Table structure for `service`
-- ----------------------------
DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of service
-- ----------------------------
INSERT INTO `service` VALUES ('kefu', '123');

-- ----------------------------
-- Table structure for `s_admin`
-- ----------------------------
DROP TABLE IF EXISTS `s_admin`;
CREATE TABLE `s_admin` (
  `name` varchar(32) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of s_admin
-- ----------------------------
INSERT INTO `s_admin` VALUES ('admin', '12345');
INSERT INTO `s_admin` VALUES ('qwe', '123');
