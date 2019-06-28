/*
 Navicat Premium Data Transfer

 Source Server         : kylebing.cn
 Source Server Type    : MySQL
 Source Server Version : 50560
 Source Host           : kylebing.cn:3306
 Source Schema         : diary

 Target Server Type    : MySQL
 Target Server Version : 50560
 File Encoding         : 65001

 Date: 28/06/2019 17:43:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for diaries
-- ----------------------------
DROP TABLE IF EXISTS `diaries`;
CREATE TABLE `diaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL COMMENT '日记日期',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` varchar(3000) DEFAULT NULL COMMENT '内容',
  `temperature` int(3) DEFAULT '-273' COMMENT '温度',
  `weather` enum('sunny','cloudy','overcast','sprinkle','rain','thunderstorm','fog','snow') DEFAULT 'sunny' COMMENT '天气',
  `category` enum('life','study','film','game','work','sport','bigevent','other') NOT NULL DEFAULT 'life' COMMENT '类别',
  `create_date` datetime NOT NULL COMMENT '创建日期',
  `modify_date` datetime DEFAULT NULL COMMENT '编辑日期',
  `uid` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for login_log
-- ----------------------------
DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `last_visit_time` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `register_time` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
