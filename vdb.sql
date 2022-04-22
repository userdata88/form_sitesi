/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : vdb

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 11/04/2022 22:09:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Hide` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `Author` int NOT NULL,
  `Topic` int NOT NULL,
  `Content` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Categori` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 77 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for forum_footer
-- ----------------------------
DROP TABLE IF EXISTS `forum_footer`;
CREATE TABLE `forum_footer`  (
  `Footer1` int NOT NULL DEFAULT 1,
  `Footer1_content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `Footer2` int NOT NULL DEFAULT 1,
  `Footer2_content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `Footer3` int NOT NULL DEFAULT 1,
  `Footer3_content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `Footer4` int NOT NULL,
  `Footer4_content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `Footer_copyright` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `verification` int NOT NULL DEFAULT 0
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of forum_footer
-- ----------------------------
INSERT INTO `forum_footer` VALUES (1, 'Footer1', 0, '', 0, '', 0, '', '<p>©  2022 Vihkon | <strong>Vihkon</strong></p>', 0);

-- ----------------------------
-- Table structure for forum_settings
-- ----------------------------
DROP TABLE IF EXISTS `forum_settings`;
CREATE TABLE `forum_settings`  (
  `Forum_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Forum_description` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Forum_tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Forum_lang` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Forum_new_topics` int NOT NULL DEFAULT 1,
  `Forum_sponsor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `verification` int NOT NULL DEFAULT 0 COMMENT 'please do not change'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of forum_settings
-- ----------------------------
INSERT INTO `forum_settings` VALUES ('Vihkon', 'Vihkon Forum', 'forum,vihkon,deneme', 'tr', 1, '<img src=\"https://img-s2.onedio.com/id-61800c3b007d7d3453e36fc1/rev-0/w-620/f-jpg/s-c6636e1506b5240e89421de795cf4e779e3a1615.jpg\">', 0);

-- ----------------------------
-- Table structure for topics
-- ----------------------------
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `Author` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `Content` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `Categori` int NOT NULL DEFAULT 0,
  `Topic_date` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `Hits` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of topics
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `E_mail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `Password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `About` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NULL DEFAULT NULL,
  `Photo` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `Signature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NULL DEFAULT NULL,
  `Registration_date` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `Last_entry` timestamp NULL DEFAULT NULL,
  `Last_ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `Total_topics` int NOT NULL DEFAULT 0,
  `Rank` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_turkish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (69, 'SDAGSEFSE', 'sfsafsa@sfs.co', 'bc0ceba386ef07e6b4302f2d8928af81', NULL, 'https://cdn.pixabay/,com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png', NULL, '2022-04-11 22:02:33', '2022-04-11 22:02:33', '::1', 0, 0);

SET FOREIGN_KEY_CHECKS = 1;
