/*
 Navicat Premium Data Transfer

 Source Server         : mysqlsimex
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : simexamerica

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 12/03/2021 10:12:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for actor_simulado
-- ----------------------------
DROP TABLE IF EXISTS `actor_simulado`;
CREATE TABLE `actor_simulado`  (
  `id_actor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_actor` varchar(60) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_actor`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of actor_simulado
-- ----------------------------
INSERT INTO `actor_simulado` VALUES (1, 'Secretario General Presidencia');
INSERT INTO `actor_simulado` VALUES (2, 'Gerente hospìtal');
INSERT INTO `actor_simulado` VALUES (3, 'Presidente');
INSERT INTO `actor_simulado` VALUES (4, 'Director Hospital');

-- ----------------------------
-- Table structure for archivos_doc
-- ----------------------------
DROP TABLE IF EXISTS `archivos_doc`;
CREATE TABLE `archivos_doc`  (
  `id_file` int(11) NOT NULL AUTO_INCREMENT,
  `id_users` int(11) NULL DEFAULT NULL,
  `file_name` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `fecha_created` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_file`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of archivos_doc
-- ----------------------------

-- ----------------------------
-- Table structure for audittrail
-- ----------------------------
DROP TABLE IF EXISTS `audittrail`;
CREATE TABLE `audittrail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime(0) NOT NULL,
  `script` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `user` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `action` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `table` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `field` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `keyvalue` longtext CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL,
  `oldvalue` longtext CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL,
  `newvalue` longtext CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 90 CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of audittrail
-- ----------------------------
INSERT INTO `audittrail` VALUES (1, '2021-02-11 16:05:10', '/simexamerica/login', 'dany@gmail.com', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (2, '2021-02-11 23:31:33', '/simexamerica/login', 'dany@gmail.com', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (3, '2021-02-12 00:45:16', '/simexamerica/logout', 'Administrator', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (4, '2021-02-12 00:45:41', '/simexamerica/login', 'maestro', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (5, '2021-02-13 20:17:27', '/simexamerica/login', 'maestro', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (6, '2021-02-14 21:35:18', '/simexamerica/login', 'dany@gmail.com', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (7, '2021-02-15 14:33:10', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (8, '2021-02-15 15:01:43', '/simexamerica/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (9, '2021-02-15 15:01:48', '/simexamerica/login', 'dany@gmail.com', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (10, '2021-02-15 21:33:45', '/simexamerica/login', 'dany@gmail.com', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (11, '2021-02-15 22:29:29', '/simexamerica/login', 'dany@gmail.com', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (12, '2021-02-17 20:34:42', '/simexamerica/login', 'dany@gmail.com', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (13, '2021-02-17 20:39:17', '/simexamerica/logout', 'dany@gmail.com', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (14, '2021-02-17 20:39:22', '/simexamerica/login', 'maestro', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (15, '2021-02-18 14:44:46', '/simexamerica/login', 'dany@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (16, '2021-02-18 14:47:21', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (17, '2021-02-18 18:13:23', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (18, '2021-02-18 20:29:01', '/simexamerica/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (19, '2021-02-18 20:29:08', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (20, '2021-02-18 21:08:18', '/simexamerica/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (21, '2021-02-18 21:08:33', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (22, '2021-02-18 21:08:42', '/simexamerica/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (23, '2021-02-18 21:09:13', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (24, '2021-02-18 21:23:49', '/simexamerica/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (25, '2021-02-18 21:24:18', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (26, '2021-02-19 02:41:30', '/simexamerica/logout', 'dany@gmail.com', 'salir', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (27, '2021-02-19 02:41:45', '/simexamerica/login', 'maestro', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (28, '2021-02-20 20:56:55', '/simexamerica/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (29, '2021-02-22 12:59:14', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (30, '2021-02-22 12:59:18', '/simexamerica/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (31, '2021-02-22 12:59:24', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (32, '2021-02-22 14:16:18', '/simexamerica/login', 'maestro', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (33, '2021-02-23 15:18:37', '/simexamerica/login', 'dany@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (34, '2021-02-24 13:23:30', '/simexamerica/login', 'dany@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (35, '2021-02-24 13:24:48', '/simexamerica/logout', 'dany@gmail.com', 'salir', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (36, '2021-02-24 13:25:21', '/simexamerica/login', 'maestro', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (37, '2021-02-24 13:28:31', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (38, '2021-02-24 14:26:57', '/simexamerica/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (39, '2021-02-24 14:27:05', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (40, '2021-02-24 14:29:12', '/simexamerica/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (41, '2021-02-24 14:29:48', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (42, '2021-02-24 14:30:10', '/simexamerica/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (43, '2021-02-24 14:30:14', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (44, '2021-02-24 15:00:21', '/simexamerica/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (45, '2021-02-24 15:01:45', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (46, '2021-02-25 20:44:06', '/simexamerica/login', 'prueba@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (47, '2021-02-25 20:47:47', '/simexamerica/logout', 'prueba@gmail.com', 'salir', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (48, '2021-02-25 20:48:29', '/simexamerica/login', 'prueba@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (49, '2021-02-25 20:50:43', '/simexamerica/logout', 'prueba@gmail.com', 'salir', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (50, '2021-02-25 20:51:02', '/simexamerica/login', 'prueba@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (51, '2021-02-26 13:50:28', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (52, '2021-02-26 16:37:30', '/simexamerica/login', 'dany@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (53, '2021-02-26 22:43:24', '/simexamerica/login', 'dany@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (54, '2021-02-27 15:23:05', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (55, '2021-03-01 14:14:16', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (56, '2021-03-04 12:50:02', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (57, '2021-03-04 15:17:44', '/simexamerica/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (58, '2021-03-04 15:17:56', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (59, '2021-03-04 15:19:01', '/simexamerica/login', 'prueba@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (60, '2021-03-04 17:08:35', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (61, '2021-03-04 17:10:46', '/simexamerica/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (62, '2021-03-04 17:10:53', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (63, '2021-03-04 19:49:06', '/simexamerica/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (64, '2021-03-04 19:49:10', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (65, '2021-03-08 15:49:14', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (66, '2021-03-09 20:39:38', '/simexamerica/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (67, '2021-03-09 20:39:54', '/simexamerica/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (68, '2021-03-09 20:40:03', '/simexamerica/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (69, '2021-03-11 13:23:46', '/simexamerica/login', 'dany@gmail.com', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (70, '2021-03-11 13:23:49', '/simexamerica/logout', 'dany@gmail.com', 'salir', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (71, '2021-03-11 13:23:59', '/simexamerica/login', 'maestro', 'conectar', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES (72, '2021-03-12 02:11:47', '/opsoms/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (73, '2021-03-12 02:11:55', '/opsoms/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (74, '2021-03-12 02:12:08', '/opsoms/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (75, '2021-03-12 02:12:36', '/opsoms/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (76, '2021-03-12 02:32:47', '/opsoms/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (77, '2021-03-12 02:32:56', '/opsoms/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (78, '2021-03-12 02:33:15', '/opsoms/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (79, '2021-03-12 02:33:23', '/opsoms/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (80, '2021-03-12 02:34:33', '/opsoms/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (81, '2021-03-12 02:34:40', '/opsoms/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (82, '2021-03-12 12:12:44', '/opsoms/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (83, '2021-03-12 12:12:56', '/opsoms/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (84, '2021-03-12 13:27:35', '/opsoms/logout', 'dany@gmail.com', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (85, '2021-03-12 13:27:41', '/opsoms/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (86, '2021-03-12 13:28:16', '/opsoms/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (87, '2021-03-12 13:28:21', '/opsoms/login', 'maestro', 'conectar', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (88, '2021-03-12 13:29:12', '/opsoms/logout', 'Administrador', 'salir', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES (89, '2021-03-12 13:29:16', '/opsoms/login', 'dany@gmail.com', 'conectar', '127.0.0.1', '', '', '', '');

-- ----------------------------
-- Table structure for email
-- ----------------------------
DROP TABLE IF EXISTS `email`;
CREATE TABLE `email`  (
  `id_email` int(11) NOT NULL AUTO_INCREMENT,
  `sender_userid` varchar(30) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `copy_sender` varchar(30) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `reciever_userid` int(11) NULL DEFAULT NULL,
  `sujeto` varchar(120) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `mensaje` text CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL,
  `tiempo` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `archivo` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id_email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email
-- ----------------------------
INSERT INTO `email` VALUES (6, '1', NULL, 5, 'Envio respuesta sobre programa', '<p>nombre</p>', '2021-02-05 01:16:03', NULL, 5);
INSERT INTO `email` VALUES (8, '5', NULL, 1, 'Mensaje urgenter', '<p>urge</p>', '2021-02-05 20:44:08', NULL, NULL);
INSERT INTO `email` VALUES (9, '2,3', NULL, NULL, 'sujeto', '<p>esto es una prueba</p>', '2021-02-06 15:51:36', NULL, NULL);
INSERT INTO `email` VALUES (10, '6', NULL, NULL, 'nuevo', '<p>estso es nuevo</p>', '2021-02-06 15:53:22', NULL, NULL);
INSERT INTO `email` VALUES (11, '2', NULL, NULL, 'Sujeto final', '<p>esto es una pruab</p>', '2021-02-06 17:13:37', 'Cotizacion Directa con Azure - David Paredes.docx', NULL);
INSERT INTO `email` VALUES (12, '3,4', NULL, NULL, 'Mesnaje de respuesta', '<div class=\"mailbox-read-message\">\r\n<p>Hello John,</p>\r\n\r\n<p>Keffiyeh blog actually fashion axe vegan, irony biodiesel. Cold-pressed hoodie chillwave put a bird on it aesthetic, bitters brunch meggings vegan iPhone. Dreamcatcher vegan scenester mlkshk. Ethical master cleanse Bushwick, occupy Thundercats banjo cliche ennui farm-to-table mlkshk fanny pack gluten-free. Marfa butcher vegan quinoa, bicycle rights disrupt tofu scenester chillwave 3 wolf moon asymmetrical taxidermy pour-over. Quinoa tote bag fashion axe, Godard disrupt migas church-key tofu blog locavore. Thundercats cronut polaroid Neutra tousled, meh food truck selfies narwhal American Apparel.</p>\r\n\r\n<p>Raw denim McSweeney\'s bicycle rights, iPhone trust fund quinoa Neutra VHS kale chips vegan PBR&amp;B literally Thundercats +1. Forage tilde four dollar toast, banjo health goth paleo butcher. Four dollar toast Brooklyn pour-over American Apparel sustainable, lumbersexual listicle gluten-free health goth umami hoodie. Synth Echo Park bicycle rights DIY farm-to-table, retro kogi sriracha dreamcatcher PBR&amp;B flannel hashtag irony Wes Anderson. Lumbersexual Williamsburg Helvetica next level. Cold-pressed slow-carb pop-up normcore Thundercats Portland, cardigan literally meditation lumbersexual crucifix. Wayfarers raw denim paleo Bushwick, keytar Helvetica scenester keffiyeh 8-bit irony mumblecore whatever viral Truffaut.</p>\r\n\r\n<p>Post-ironic shabby chic VHS, Marfa keytar flannel lomo try-hard keffiyeh cray. Actually fap fanny pack yr artisan trust fund. High Life dreamcatcher church-key gentrify. Tumblr stumptown four dollar toast vinyl, cold-pressed try-hard blog authentic keffiyeh Helvetica lo-fi tilde Intelligentsia. Lomo locavore salvia bespoke, twee fixie paleo cliche brunch Schlitz blog McSweeney\'s messenger bag swag slow-carb. Odd Future photo booth pork belly, you probably haven\'t heard of them actually tofu ennui keffiyeh lo-fi Truffaut health goth. Narwhal sustainable retro disrupt.</p>\r\n\r\n<p>Skateboard artisan letterpress before they sold out High Life messenger bag. Bitters chambray leggings listicle, drinking vinegar chillwave synth. Fanny pack hoodie American Apparel twee. American Apparel PBR listicle, salvia aesthetic occupy sustainable Neutra kogi. Organic synth Tumblr viral plaid, shabby chic single-origin coffee Etsy 3 wolf moon slow-carb Schlitz roof party tousled squid vinyl. Readymade next level literally trust fund. Distillery master cleanse migas, Vice sriracha flannel chambray chia cronut.</p>\r\n\r\n<p>Thanks,<br />\r\nJane</p>\r\n</div>', '2021-02-06 18:19:57', 'texto sobre validaciones.docx', NULL);
INSERT INTO `email` VALUES (13, '2,3,4', NULL, NULL, 'Correccion de documentos', '<div class=\"item-page-field-wrapper simple-item-view-description table\" style=\"background-color:#ffffff;color:#333333;font-family:\'Source Sans Pro\', Helvetica, Arial, sans-serif;font-size:14px;font-style:normal;font-weight:400;letter-spacing:normal;margin-bottom:25px;max-width:100%;text-align:justify;text-indent:0px;text-transform:none;white-space:normal;width:555px;word-spacing:0px;\">\r\n<div>The effects of climate change on human health are unequivocal and can already be perceived worldwide. Phenomena such as heat waves, cold waves, floods, droughts, hurricanes, storms, and other extreme weather events can impact health both directly and indirectly, as well as trigger or exacerbate certain conditions and, consequently, put pressure on health services and their infrastructure. These include vector-borne, waterborne, and foodborne diseases—due to changes in the behavior and distribution of vectors and pathogens—and mental health disorders induced by mounting social unrest and forced displacement. Climate change for health professionals is a pocket book based on empirical data that offers essential information for medical personnel and other health professionals to realize the impacts of climate change on their daily practice. With this quick reference guide, providers can easily recognize diseases and side effects related to climate change, implement appropriate management and provide guidance to exposed populations, provide up-to-date information on the relationship between the adverse effects of certain drugs and the worsening of climate-sensitive health conditions, and determine the possible consequences of climate change for health services. This book addresses key meteorological risks, as well as the health conditions which they may influence, grouped by specific clinical areas. With this publication, the Pan American Health Organization aims to help build knowledge on the subject and strengthen the capacity of health systems to predict, prevent, and prepare, with a view to offering continuous high-quality health services in a world where climate is changing rapidly.</div>\r\n</div>\r\n\r\n<div class=\"item-page-field-wrapper simple-item-view-description table\" style=\"background-color:#ffffff;color:#333333;font-family:\'Source Sans Pro\', Helvetica, Arial, sans-serif;font-size:14px;font-style:normal;font-weight:400;letter-spacing:normal;margin-bottom:25px;max-width:100%;text-align:justify;text-indent:0px;text-transform:none;white-space:normal;width:555px;word-spacing:0px;\">\r\n<h5>Tema</h5>\r\n\r\n<div><a href=\"https://iris.paho.org/browse?value=Climate%20Change&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Climate Change</a>; <a href=\"https://iris.paho.org/browse?value=Environment%20and%20Public%20Health&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Environment and Public Health</a>; <a href=\"https://iris.paho.org/browse?value=Cardiovascular%20Diseases&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Cardiovascular Diseases</a>; <a href=\"https://iris.paho.org/browse?value=Respiratory%20Tract%20Diseases&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Respiratory Tract Diseases</a>; <a href=\"https://iris.paho.org/browse?value=Kidney%20Diseases&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Kidney Diseases</a>; <a href=\"https://iris.paho.org/browse?value=Eye%20Diseases&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Eye Diseases</a>; <a href=\"https://iris.paho.org/browse?value=Skin%20Diseases&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Skin Diseases</a>; <a href=\"https://iris.paho.org/browse?value=Gastrointestinal%20Diseases&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Gastrointestinal Diseases</a>; <a href=\"https://iris.paho.org/browse?value=Mental%20Health&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Mental Health</a>; <a href=\"https://iris.paho.org/browse?value=Community%20Health%20Status%20Indicators&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Community Health Status Indicators</a>; <a href=\"https://iris.paho.org/browse?value=Vector%20Borne%20Diseases&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Vector Borne Diseases</a>; <a href=\"https://iris.paho.org/browse?value=Climate%20Effects&amp;type=subject\" style=\"background-color:transparent;color:rgb(96,120,144);text-decoration:none;\">Climate Effects</a></div>\r\n</div>', '2021-02-08 16:44:51', 'Caso N° 3 (2).pdf', NULL);
INSERT INTO `email` VALUES (14, '2', NULL, NULL, 'menajasa', '<p>si sse puedes</p>', '2021-02-11 11:05:46', NULL, NULL);

-- ----------------------------
-- Table structure for escenario
-- ----------------------------
DROP TABLE IF EXISTS `escenario`;
CREATE TABLE `escenario`  (
  `id_escenario` int(11) NOT NULL AUTO_INCREMENT,
  `fechacreacion_escenario` datetime(6) NULL DEFAULT NULL,
  `tipo_evento` int(2) NULL DEFAULT NULL,
  `incidente` int(2) NULL DEFAULT NULL,
  `nombre_escenario` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `pais_escenario` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `zonahora_escenario` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descripcion_escenario` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `fechaini_simulado` datetime(6) NULL DEFAULT NULL,
  `fechafin_simulado` datetime(6) NULL DEFAULT NULL,
  `fechaini_real` datetime(6) NULL DEFAULT NULL,
  `fechafinal_real` datetime(6) NULL DEFAULT NULL,
  `icon_escenario` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `image_escenario` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `estado` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_escenario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of escenario
-- ----------------------------
INSERT INTO `escenario` VALUES (40, '2021-02-12 20:19:29.000000', 4, 15, 'Ejercicio de Simulación de Respuesta a Terremotos', '131', NULL, '<div class=\"WordSection1\">\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\"><u>SIGLAS INTERNACIONALES MÁS UTILIZADAS.</u></span></span></div>\r\n\r\n<ul>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">ASR: Evaluación, Búsqueda y Rescate (Assessment, Search and Rescue)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">BoO: Base de Operaciones (Base of Operations)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">GDACS:    Sistema Mundial de Alerta y Coordinación en Casos de Desastre (Global Disaster Alert and Coordination System)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">EHP: Equipo Humanitario de País.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">EXCON: Grupo de Coordinación y Control del Ejercicio.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">IER: Reclasificación Externa del INSARAG (INSARAG External Reclassification)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">LEMA: Autoridad Nacional de Gestión de Emergencias (Local Emergency Management Agency)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">NDMA: Autoridad Nacional de Manejo de Desastres (National Disaster Management Authority)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">NGOs: Organizaciones No-Gubernamentales (Non-governmental organisations)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OSOCC:    Centro de Coordinación de Operaciones en el sitio (On-Site Operations Coordination Center)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">V-OSOCC: Sitio Virtual en base a página Web del Centro de Coordinación de Operaciones en el sitio.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">RCM: Marcado de Despeje Rápido (Rapid Clearance Marking)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">RDC: Centro de Recepción y Salida (Reception and Departure Center)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">SAR: Búsqueda y Rescate (Search and Rescue).</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">SIMEX: Ejercicio de Simulación de Respuesta a Terremotos.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">SOPs: Procedimientos Operativos Estándar (Standard Operating Procedures)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">UCC: Célula de Coordinación USAR (USAR Coordination Cell)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">UNDAC: Equipo de las Naciones Unidas para Evaluación y Coordinación en Casos de Desastre (United Nations Disaster Assessment and Coordination team)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">USAR: Búsqueda y Rescate Urbano (Urban Search and Rescue)</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">EMT: Equipo Médico de Emergencias (Emergency Medicals Team).</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">TSF: ONG francesa que asegura las comunicaciones (principalmente las satelitales) tanto en ejercicios como en situaciones de desastres reales.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MapAction: ONG inglesa que asegura tanto en ejercicios como en situaciones de desastres reales, la elaboración de mapas de situación a tiempo real.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OCHA: Oficina de Naciones Unidas para la Coordinación de Asuntos Humanitarios.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OCHA-ROLAC: Oficina Regional de Naciones Unidas para la Coordinación de Asuntos Humanitarios para América Latina y el Caribe (OCHA ROLAC).</span></span></span></div>\r\n	</li>\r\n</ul>\r\n</div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div class=\"WordSection2\">\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<ul>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OPS: Organización Panamericana de la Salud.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OMS: Organización Mundial de la Salud.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">UNDAC: Equipo de las Naciones Unidas para la Evaluación y Coordinación en Casos de Desastres.</span></span></span></div>\r\n	</li>\r\n</ul>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\"><u>SIGLAS NACIONALES</u></span></span></div>\r\n\r\n<ul>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OACE: Organismos de la Administración Central del Estado (Ministerios).</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">EMNDC: Estado Mayor Nacional de la Defensa Civil.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINFAR: Ministerio de las Fuerzas Armadas Revolucionarias.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MININT: Ministerio del Interior.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINREX: Ministerio de Relaciones Exteriores.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINCEX: Ministerio de Comercio Exterior y la Inversión Extranjera.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CITMA: Ministerio de Ciencia, Tecnología y Medio Ambiente.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINSAP: Ministerio de Salud Pública.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINCIN: Ministerio de Comercio Interior.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MITRANS: Ministerio de Transporte.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINED: Ministerio de Educación.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINAG: Ministerio de la Agricultura</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">AGR: Aduana General de la República.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">SNCCR: Sociedad Nacional Cubana de la Cruz Roja.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CD: Centro de Dirección.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CDN: Consejo de Defensa Nacional (COE).</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CD-CDN: Centro de Dirección del Consejo de Defensa Nacional para situaciones de desastres.</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CDP: Consejo de Defensa Provincial</span></span></span></div>\r\n	</li>\r\n	<li>\r\n	<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CENAIS: Centro Nacional de Investigaciones Sismológicas.</span></span></span></div>\r\n	</li>\r\n</ul>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\"><u>I.- FUNDAMENTO GENERAL DEL ESCENARIO:</u></span></span></div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\">El Peligro Sísmico de Cuba presenta una particularidad interesante y que al mismo tiempo hace que su estudio sea complejo para algunas áreas. Esto consiste en el hecho de que en el archipiélago cubano se presentan dos formas de génesis: de “entre placas” y de “interior de placa”. Ambos tipos de sismicidad corresponden a la actividad sísmica que se genera en estructuras tectónicas distribuidas en todo nuestro territorio. En la</span></span></div>\r\n</div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div class=\"WordSection3\">\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\"><strong>Figura 1 </strong>se muestran las estructuras activas (Zonas Sismogénicas) que pueden generar sismos de magnitud M <span style=\"font-family:Symbol;\">³</span> 5.</span></span></div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><strong><span style=\"font-size:12pt;\">Figura 1. Mapa de las principales Zonas Sismogénicas de Cuba con sus categorías correspondientes, en función de la Magnitud máxima que pueden alcanzar (Tomado de Chuy y Álvarez, 1995).</span></strong></span></span></div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\">Sin embargo, la Sismicidad de Interior de Placa también se manifiesta en las Zonas Sismogénicas de baja actividad distribuidas en el territorio nacional. A pesar de presentar una menor frecuencia la ocurrencia de terremotos en ellas, su ubicación cercana a las costas en los casos de que se localicen en las acuatorias o bien en el interior del territorio, así como la poca profundidad de los hipocentros de los sismos que se generan en ellas, hacen que en ocasiones los efectos de sismos de menor magnitud reporten afectaciones significativas. Es así que se reportan sismos como el de 1880 (Ms = 6.0) en la zona de San Cristóbal que extendió su área de perceptibilidad hasta Cienfuegos.</span></span></div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\">Un enfoque adecuado del Mapa de Peligro Sísmico con fines de Ingeniería que esta insertado en el Código Sismorresistente cubano NC – 46 – 2013, es considerar los suelos de base como suelos medios S2, de forma que tomando en cuenta un perfil de suelo estándar para todo el país, pueda verse de forma más adecuada el nivel de peligro sísmico a que está sometida cada municipio. De esta transformación resulta la <strong>Figura 2, </strong>en el que se aprecia por territorios un nivel de peligro base, tanto en intensidades a esperar, como en potenciales aceleraciones horizontales máximas a alcanzar.</span></span></div>\r\n</div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><strong><span style=\"font-size:12pt;\">Figura 2. Mapa de zonación sísmica para la nueva norma sismorresistente NC-46:2016</span></strong></span></span></div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\">En el mes de agosto de 2019, se produjo una creciente actividad sísmica en la parte occidental del país, la cual se acentuó con la ocurrencia de 2 eventos perceptible en 48 horas, evaluándose en aquel momento por el CENAIS, que el segmento de la Falla Pinar en el que se ubicaron los epicentros, podría estar experimentando la preparación de un evento significativo superior a 6.0 de magnitud en la Escala de Richter. El análisis se basó en la distancia entre los dos últimos terremotos, los cuales se ubican en los extremos de un mismo segmento de falla de 38,5 km de longitud. Si se asume una ruptura completa de todo el segmento de falla, los cálculos estiman que provocaría un evento aproximadamente de 6.0 de magnitud.</span></span></div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><strong><span style=\"font-size:12pt;\">Figura 3. Mapa de ubicación de las principales Fallas Sísmicas del País.</span></strong></span></span></div>\r\n\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\">La modelación de un posible escenario de un sismo de 6.0 de magnitud con epicentro localizado a 20 km aproximadamente al Suroeste de Artemisa, en la provincia del mismo nombre con una longitud del área de ruptura de 90 km hacia el Este</span></span></div>', '2021-02-09 11:35:00.000000', '2021-02-12 11:35:00.000000', '2021-02-07 11:35:00.000000', '2021-02-12 11:35:00.000000', 'images/icon/terremoto.png', NULL, '2');
INSERT INTO `escenario` VALUES (41, '2021-02-09 20:46:12.000000', 5, 17, 'Huracán de categoría 5', '141', NULL, '<div class=\"item-page-field-wrapper simple-item-view-description table\">\r\n<div>En este trabajo se realizó la simulación de uno de los fenómenos naturales que ocupan el primer lugar en daños catastróficos a nivel mundial, se tomó como referente el huracán JOAN, que alcanzó la categoría cuatro (en Centroamérica), el cual, pasó muy cerca de la costa caribe colombiana en el mes de octubre del año 1988. Se utilizaron dos modelos de simulación, el HURWIN para simular el comportamiento del huracán y el SWAN para simular el oleaje producido, ambos modelos fueron validados, simulando el huracán OPAL (Golfo de México, 1995), debido a que se contaban con datos de su comportamiento, medidos con boyas oceanográficas ubicadas en su radio de influencia, y por que presentaba características similares a JOAN. Después de la validación de los modelos, se procedió a implementar la simulación de JOAN, usando ubicaciones geográficas del huracán para poder correr los modelos y de esta forma predecir el comportamiento del oleaje cercano a la costa caribe colombiana. El presente trabajo de simulación tiene un efecto importante dentro del estudio del impacto en la infraestructura costera en la costa Norte Colombiana ya que establecerá una visión del comportamiento dinámico de este fenómeno natural que pasó muy cerca de la costa Atlántica durante el mes de octubre de 1988. Los resultados obtenidos a través de los modelos HURWIN y SWAN, utilizados en este trabajo, permitirán establecer un estimado de las variables físicas que caracterizan el paso de un evento de esta naturaleza, el campo de vientos, la altura de ola generada, el período pico, el espectro de energía de las olas en función de la frecuencia y dirección serán algunos de los parámetros físicos que se obtendrán.</div>\r\n</div>\r\n\r\n<div class=\"item-page-field-wrapper simple-item-view-subjectkeywords table word-break\">\r\n<h5>Palabras clave</h5>\r\nSimulación por computadores; Ingeniería de sistemas; Computadores; Métodos de simulación; Investigaciones; Análisis</div>', '2021-02-09 15:30:00.000000', '2021-02-13 15:42:00.000000', '2021-02-07 15:42:00.000000', '2021-02-13 15:42:00.000000', 'images/icon/huracan.png', NULL, NULL);
INSERT INTO `escenario` VALUES (42, '2021-02-12 00:53:01.000000', 4, 16, 'Nuevo Escenario de tzunami', '116', NULL, '<p>descripciones</p>', '2021-02-16 21:49:00.000000', '2021-02-20 21:49:00.000000', '2021-02-16 21:49:00.000000', '2021-02-20 21:49:00.000000', 'images/icon/tsunami.png', 'huracansimex.jpg', '1');
INSERT INTO `escenario` VALUES (43, '2021-02-11 14:34:10.000000', 7, 28, 'nuevo escenario', '143', NULL, '<p style=\"text-align:center;\"><span style=\"font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', serif;\"><strong><span style=\"font-size:18pt;\">EJERCICIO DE SIMULACION – CURSO CICOM</span></strong></span></span></p>\r\n\r\n<p> </p>\r\n\r\n<p style=\"text-align:justify;\"><span style=\"font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', serif;\">El ejercicio de simulación del curso CICOM es concebido para poner en práctica los conocimientos de la metodología CICOM en un evento ficticio que permita fortalecer y desarrollar capacidades de coordinación, de gestión de información y operacionales. </span></span></p>\r\n\r\n<p style=\"text-align:justify;\"> </p>\r\n\r\n<p style=\"text-align:justify;\"><span style=\"font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', serif;\">El objetivo primordial es fortalecer las capacidades de los países participantes en la implementación y la operación del CICOM, previo a una respuesta de una emergencia real que requiera la activación del CICOM y una respuesta coordinada y rápida de los EMT nacionales e internacionales para salvar vidas. </span></span></p>\r\n\r\n<p style=\"text-align:justify;\"> </p>\r\n\r\n<p style=\"text-align:justify;\"><span style=\"font-size:12pt;\"><span style=\"font-family:\'Times New Roman\', serif;\">Por medio de un escenario que sobrepasa la capacidad del país (Bahamas para efectos de este ejercicio) por el nivel de impacto y los daños ocurridos en las redes integrales de servicios de salud se ve la necesidad de activar el CICOM, los EMT nacionales y el requerimiento de EMT internacionales. El ejercicio se desarrolla en el marco de un Huracán de categoría 5.</span></span></p>\r\n\r\n<p style=\"text-align:justify;\"> </p>', '2021-02-11 09:50:00.000000', '2021-02-11 09:50:00.000000', '2021-02-11 09:50:00.000000', '2021-02-11 09:50:00.000000', 'images/icon/exporadiactiva.png', NULL, NULL);
INSERT INTO `escenario` VALUES (44, '2021-02-11 16:03:19.000000', 1, 2, 'nuevo', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'images/icon/incendioforstal.png', NULL, NULL);
INSERT INTO `escenario` VALUES (45, '2021-03-02 22:43:44.000000', 4, 15, 'Ejercicio de Simulación de Respuesta a Terremotos', '131', NULL, '<div class=\"WordSection1\">\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\"><u>SIGLAS INTERNACIONALES MÁS UTILIZADAS.</u></span></span></div>\r\n<ul>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">ASR: Evaluación, Búsqueda y Rescate (Assessment, Search and Rescue)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">BoO: Base de Operaciones (Base of Operations)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">GDACS:    Sistema Mundial de Alerta y Coordinación en Casos de Desastre (Global Disaster Alert and Coordination System)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">EHP: Equipo Humanitario de País.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">EXCON: Grupo de Coordinación y Control del Ejercicio.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">IER: Reclasificación Externa del INSARAG (INSARAG External Reclassification)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">LEMA: Autoridad Nacional de Gestión de Emergencias (Local Emergency Management Agency)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">NDMA: Autoridad Nacional de Manejo de Desastres (National Disaster Management Authority)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">NGOs: Organizaciones No-Gubernamentales (Non-governmental organisations)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OSOCC:    Centro de Coordinación de Operaciones en el sitio (On-Site Operations Coordination Center)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">V-OSOCC: Sitio Virtual en base a página Web del Centro de Coordinación de Operaciones en el sitio.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">RCM: Marcado de Despeje Rápido (Rapid Clearance Marking)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">RDC: Centro de Recepción y Salida (Reception and Departure Center)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">SAR: Búsqueda y Rescate (Search and Rescue).</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">SIMEX: Ejercicio de Simulación de Respuesta a Terremotos.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">SOPs: Procedimientos Operativos Estándar (Standard Operating Procedures)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">UCC: Célula de Coordinación USAR (USAR Coordination Cell)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">UNDAC: Equipo de las Naciones Unidas para Evaluación y Coordinación en Casos de Desastre (United Nations Disaster Assessment and Coordination team)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">USAR: Búsqueda y Rescate Urbano (Urban Search and Rescue)</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">EMT: Equipo Médico de Emergencias (Emergency Medicals Team).</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">TSF: ONG francesa que asegura las comunicaciones (principalmente las satelitales) tanto en ejercicios como en situaciones de desastres reales.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MapAction: ONG inglesa que asegura tanto en ejercicios como en situaciones de desastres reales, la elaboración de mapas de situación a tiempo real.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OCHA: Oficina de Naciones Unidas para la Coordinación de Asuntos Humanitarios.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OCHA-ROLAC: Oficina Regional de Naciones Unidas para la Coordinación de Asuntos Humanitarios para América Latina y el Caribe (OCHA ROLAC).</span></span></span></div>\r\n</li>\r\n</ul>\r\n</div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div class=\"WordSection2\">\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<ul>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OPS: Organización Panamericana de la Salud.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OMS: Organización Mundial de la Salud.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">UNDAC: Equipo de las Naciones Unidas para la Evaluación y Coordinación en Casos de Desastres.</span></span></span></div>\r\n</li>\r\n</ul>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\"><u>SIGLAS NACIONALES</u></span></span></div>\r\n<ul>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">OACE: Organismos de la Administración Central del Estado (Ministerios).</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">EMNDC: Estado Mayor Nacional de la Defensa Civil.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINFAR: Ministerio de las Fuerzas Armadas Revolucionarias.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MININT: Ministerio del Interior.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINREX: Ministerio de Relaciones Exteriores.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINCEX: Ministerio de Comercio Exterior y la Inversión Extranjera.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CITMA: Ministerio de Ciencia, Tecnología y Medio Ambiente.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINSAP: Ministerio de Salud Pública.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINCIN: Ministerio de Comercio Interior.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MITRANS: Ministerio de Transporte.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINED: Ministerio de Educación.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">MINAG: Ministerio de la Agricultura</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">AGR: Aduana General de la República.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">SNCCR: Sociedad Nacional Cubana de la Cruz Roja.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CD: Centro de Dirección.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CDN: Consejo de Defensa Nacional (COE).</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CD-CDN: Centro de Dirección del Consejo de Defensa Nacional para situaciones de desastres.</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CDP: Consejo de Defensa Provincial</span></span></span></div>\r\n</li>\r\n<li>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><span style=\"font-size:14pt;\">CENAIS: Centro Nacional de Investigaciones Sismológicas.</span></span></span></div>\r\n</li>\r\n</ul>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\"><u>I.- FUNDAMENTO GENERAL DEL ESCENARIO:</u></span></span></div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\">El Peligro Sísmico de Cuba presenta una particularidad interesante y que al mismo tiempo hace que su estudio sea complejo para algunas áreas. Esto consiste en el hecho de que en el archipiélago cubano se presentan dos formas de génesis: de “entre placas” y de “interior de placa”. Ambos tipos de sismicidad corresponden a la actividad sísmica que se genera en estructuras tectónicas distribuidas en todo nuestro territorio. En la</span></span></div>\r\n</div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div class=\"WordSection3\">\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\"><strong>Figura 1 </strong>se muestran las estructuras activas (Zonas Sismogénicas) que pueden generar sismos de magnitud M <span style=\"font-family:Symbol;\">³</span> 5.</span></span></div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><strong><span style=\"font-size:12pt;\">Figura 1. Mapa de las principales Zonas Sismogénicas de Cuba con sus categorías correspondientes, en función de la Magnitud máxima que pueden alcanzar (Tomado de Chuy y Álvarez, 1995).</span></strong></span></span></div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\">Sin embargo, la Sismicidad de Interior de Placa también se manifiesta en las Zonas Sismogénicas de baja actividad distribuidas en el territorio nacional. A pesar de presentar una menor frecuencia la ocurrencia de terremotos en ellas, su ubicación cercana a las costas en los casos de que se localicen en las acuatorias o bien en el interior del territorio, así como la poca profundidad de los hipocentros de los sismos que se generan en ellas, hacen que en ocasiones los efectos de sismos de menor magnitud reporten afectaciones significativas. Es así que se reportan sismos como el de 1880 (Ms = 6.0) en la zona de San Cristóbal que extendió su área de perceptibilidad hasta Cienfuegos.</span></span></div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\">Un enfoque adecuado del Mapa de Peligro Sísmico con fines de Ingeniería que esta insertado en el Código Sismorresistente cubano NC – 46 – 2013, es considerar los suelos de base como suelos medios S2, de forma que tomando en cuenta un perfil de suelo estándar para todo el país, pueda verse de forma más adecuada el nivel de peligro sísmico a que está sometida cada municipio. De esta transformación resulta la <strong>Figura 2, </strong>en el que se aprecia por territorios un nivel de peligro base, tanto en intensidades a esperar, como en potenciales aceleraciones horizontales máximas a alcanzar.</span></span></div>\r\n</div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><strong><span style=\"font-size:12pt;\">Figura 2. Mapa de zonación sísmica para la nueva norma sismorresistente NC-46:2016</span></strong></span></span></div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:14pt;\"><span style=\"font-family:Calibri, sans-serif;\">En el mes de agosto de 2019, se produjo una creciente actividad sísmica en la parte occidental del país, la cual se acentuó con la ocurrencia de 2 eventos perceptible en 48 horas, evaluándose en aquel momento por el CENAIS, que el segmento de la Falla Pinar en el que se ubicaron los epicentros, podría estar experimentando la preparación de un evento significativo superior a 6.0 de magnitud en la Escala de Richter. El análisis se basó en la distancia entre los dos últimos terremotos, los cuales se ubican en los extremos de un mismo segmento de falla de 38,5 km de longitud. Si se asume una ruptura completa de todo el segmento de falla, los cálculos estiman que provocaría un evento aproximadamente de 6.0 de magnitud.</span></span></div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"> </div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\"><strong><span style=\"font-size:12pt;\">Figura 3. Mapa de ubicación de las principales Fallas Sísmicas del País.</span></strong></span></span></div>\r\n<div style=\"background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;\"><span style=\"font-size:11pt;\"><span style=\"font-family:Calibri, sans-serif;\">La modelación de un posible escenario de un sismo de 6.0 de magnitud con epicentro localizado a 20 km aproximadamente al Suroeste de Artemisa, en la provincia del mismo nombre con una longitud del área de ruptura de 90 km hacia el Este</span></span></div>', '2021-02-09 11:35:00.000000', '2021-02-12 11:35:00.000000', '2021-02-07 11:35:00.000000', '2021-02-12 11:35:00.000000', 'images/icon/terremoto.png', NULL, NULL);

-- ----------------------------
-- Table structure for grupo
-- ----------------------------
DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo`  (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descripcion_grupo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `imgen_grupo` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `color` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `id_escenario` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_grupo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of grupo
-- ----------------------------
INSERT INTO `grupo` VALUES (49, 'Defensa Civil', NULL, NULL, NULL, 40);
INSERT INTO `grupo` VALUES (50, 'USAR', NULL, NULL, NULL, 40);

-- ----------------------------
-- Table structure for incidente
-- ----------------------------
DROP TABLE IF EXISTS `incidente`;
CREATE TABLE `incidente`  (
  `id_incidente` int(2) NOT NULL AUTO_INCREMENT,
  `id_tipo` int(2) NULL DEFAULT NULL,
  `incidente_es` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `incidente_en` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `icono` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_incidente`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of incidente
-- ----------------------------
INSERT INTO `incidente` VALUES (1, 1, 'Acto terrorista ', ' Terrorist Act', NULL);
INSERT INTO `incidente` VALUES (2, 1, 'Incendio forestal ', ' Forest Fire', NULL);
INSERT INTO `incidente` VALUES (3, 1, 'Incendio urbano ', ' Urban Fire', NULL);
INSERT INTO `incidente` VALUES (4, 1, 'Incidente con múltiples victimas', 'Incident with multiple victims', NULL);
INSERT INTO `incidente` VALUES (6, 2, 'Contaminación biológica ', ' Biological contamination', NULL);
INSERT INTO `incidente` VALUES (7, 2, 'Epidemia ', ' Epidemic', NULL);
INSERT INTO `incidente` VALUES (8, 3, 'Desertifìcación', 'Desertification', NULL);
INSERT INTO `incidente` VALUES (9, 3, 'Plaga ', ' Plague', NULL);
INSERT INTO `incidente` VALUES (10, 3, 'Polución de agua ', ' Water pollution', NULL);
INSERT INTO `incidente` VALUES (11, 3, 'Polución de aire ', ' Air poluution', NULL);
INSERT INTO `incidente` VALUES (12, 4, 'Actividad volcánica ', ' Volcanic activity', NULL);
INSERT INTO `incidente` VALUES (13, 4, 'Avalancha', 'Avalanche', NULL);
INSERT INTO `incidente` VALUES (14, 4, 'Deslizamiento de tierra ', ' Landslide', NULL);
INSERT INTO `incidente` VALUES (15, 4, 'Terremoto ', ' Earthquake', NULL);
INSERT INTO `incidente` VALUES (16, 4, 'Tsunami ', ' Tsunami', NULL);
INSERT INTO `incidente` VALUES (17, 5, 'Huracán ', ' Hurricane', NULL);
INSERT INTO `incidente` VALUES (18, 5, 'Inundación ', ' Flood', NULL);
INSERT INTO `incidente` VALUES (19, 5, 'Ola de calor ', ' Heat wave', NULL);
INSERT INTO `incidente` VALUES (20, 5, 'Ola de frio ', ' Cold Wave', NULL);
INSERT INTO `incidente` VALUES (21, 5, 'Sequia ', ' Drought', NULL);
INSERT INTO `incidente` VALUES (22, 5, 'Tormenta ', ' Storm', NULL);
INSERT INTO `incidente` VALUES (23, 5, 'Tornado ', ' Tornado', NULL);
INSERT INTO `incidente` VALUES (24, 6, 'Derrame de petróleo ', ' Oil Spill', NULL);
INSERT INTO `incidente` VALUES (25, 6, 'Derrame químico ', ' Chemical spill', NULL);
INSERT INTO `incidente` VALUES (26, 6, 'Fuego químico ', ' Chemical re', NULL);
INSERT INTO `incidente` VALUES (27, 6, 'Fuga química ', 'Chemical leak', NULL);
INSERT INTO `incidente` VALUES (28, 7, 'Exposición a fuente radioactiva ', ' Exposure to radioactive source', NULL);
INSERT INTO `incidente` VALUES (29, 7, 'Sobreexposición radiológica ', ' Radiological overesposure', NULL);
INSERT INTO `incidente` VALUES (30, 8, 'Conicto armado ', ' Armed conict', NULL);
INSERT INTO `incidente` VALUES (31, 8, 'Conicto social ', ' Social conict', NULL);
INSERT INTO `incidente` VALUES (32, 8, 'Desplazamiento de población ', ' Population displacement', NULL);
INSERT INTO `incidente` VALUES (33, 8, 'Hambruna ', ' Famine', NULL);

-- ----------------------------
-- Table structure for mensagens
-- ----------------------------
DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE `mensagens`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_de` int(11) NOT NULL,
  `id_para` int(11) NOT NULL,
  `mensagem` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `time` int(11) NOT NULL,
  `lido` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mensagens
-- ----------------------------
INSERT INTO `mensagens` VALUES (1, 13, 10, 'Hola pepito', 1612221218, 0);
INSERT INTO `mensagens` VALUES (2, 10, 13, 'Hola Eloisa', 1612221231, 0);
INSERT INTO `mensagens` VALUES (3, 12, 11, 'hola', 1612221890, 0);
INSERT INTO `mensagens` VALUES (4, 12, 11, 'hola', 1612221904, 0);
INSERT INTO `mensagens` VALUES (5, 8, 9, 'prueba', 1612221981, 1);
INSERT INTO `mensagens` VALUES (6, 8, 9, 'prueba', 1612222008, 1);
INSERT INTO `mensagens` VALUES (7, 8, 9, 'hola David', 1612222985, 1);
INSERT INTO `mensagens` VALUES (8, 10, 13, 'Hola pepito', 1612223022, 0);
INSERT INTO `mensagens` VALUES (9, 9, 8, 'Hola Andrés', 1612273123, 1);
INSERT INTO `mensagens` VALUES (10, 9, 8, 'Hola Andrés', 1612273181, 1);
INSERT INTO `mensagens` VALUES (11, 8, 9, 'Prueba notificación', 1612273202, 1);
INSERT INTO `mensagens` VALUES (12, 9, 8, 'www.google.com', 1612273268, 1);
INSERT INTO `mensagens` VALUES (13, 12, 8, 'Hola Andres', 1612273829, 0);
INSERT INTO `mensagens` VALUES (14, 9, 12, 'Hola admin', 1612277502, 0);
INSERT INTO `mensagens` VALUES (15, 9, 12, 'Hola Admin', 1612301349, 0);
INSERT INTO `mensagens` VALUES (16, 9, 8, 'https://www.google.com/', 1612304211, 1);
INSERT INTO `mensagens` VALUES (17, 9, 12, ':)', 1612304270, 0);
INSERT INTO `mensagens` VALUES (18, 9, 12, 'Hola Admin', 1612366414, 0);
INSERT INTO `mensagens` VALUES (19, 12, 9, 'Hola David', 1612366518, 1);
INSERT INTO `mensagens` VALUES (20, 12, 9, 'Hola David', 1612366695, 1);
INSERT INTO `mensagens` VALUES (21, 12, 9, 'Hola david 2 prueba', 1612366738, 1);
INSERT INTO `mensagens` VALUES (22, 12, 9, 'www.google.com', 1612368451, 1);
INSERT INTO `mensagens` VALUES (23, 12, 9, 'google.com', 1612368490, 1);
INSERT INTO `mensagens` VALUES (24, 12, 9, 'google.com', 1612368654, 1);
INSERT INTO `mensagens` VALUES (25, 12, 9, 'facebook.com', 1612368775, 1);
INSERT INTO `mensagens` VALUES (26, 12, 9, 'www.facebook.com', 1612368793, 1);
INSERT INTO `mensagens` VALUES (27, 12, 9, 'www.facebook.com', 1612368935, 1);
INSERT INTO `mensagens` VALUES (28, 12, 9, 'www.google.com', 1612369110, 1);
INSERT INTO `mensagens` VALUES (29, 12, 9, 'www.google.com', 1612370751, 1);
INSERT INTO `mensagens` VALUES (30, 12, 9, 'www,google.com', 1612370832, 1);
INSERT INTO `mensagens` VALUES (31, 12, 9, 'www.google.com', 1612375350, 1);
INSERT INTO `mensagens` VALUES (32, 12, 9, 'https://www.google.com', 1612375381, 1);
INSERT INTO `mensagens` VALUES (33, 12, 9, 'prueba', 1612376236, 0);
INSERT INTO `mensagens` VALUES (34, 12, 9, 'hola david', 1612378094, 0);
INSERT INTO `mensagens` VALUES (35, 12, 9, 'www.google.com', 1612378100, 0);
INSERT INTO `mensagens` VALUES (36, 12, 9, 'www.google.com', 1612378245, 0);
INSERT INTO `mensagens` VALUES (37, 9, 8, 'Hola prueba de envio de mensaje', 1612555162, 1);
INSERT INTO `mensagens` VALUES (38, 9, 8, 'hola soy andres', 1612555183, 1);
INSERT INTO `mensagens` VALUES (39, 5, 6, 'hola prueba', 1614285760, 1);
INSERT INTO `mensagens` VALUES (40, 6, 5, 'Hola Daniel', 1614285878, 0);
INSERT INTO `mensagens` VALUES (41, 5, 6, 'Hola Daniel', 1614286039, 1);
INSERT INTO `mensagens` VALUES (42, 6, 5, 'hola  andres', 1614286124, 0);
INSERT INTO `mensagens` VALUES (43, 6, 5, 'hola andres', 1614286164, 0);
INSERT INTO `mensagens` VALUES (44, 5, 6, 'Hola Prueba 2', 1614286288, 0);
INSERT INTO `mensagens` VALUES (45, 5, 6, 'hola prueba 3', 1614286694, 0);
INSERT INTO `mensagens` VALUES (46, 6, 5, 'holasss', 1614286718, 0);
INSERT INTO `mensagens` VALUES (47, 6, 5, 'ssss', 1614286723, 0);
INSERT INTO `mensagens` VALUES (48, 5, 1, 'hola', 1614871085, 0);
INSERT INTO `mensagens` VALUES (49, 5, 2, 'hola andres', 1614871094, 0);
INSERT INTO `mensagens` VALUES (50, 5, 6, 'hola que mas', 1614871150, 0);
INSERT INTO `mensagens` VALUES (51, 6, 2, 'hola bien y tu como vas', 1614871173, 0);
INSERT INTO `mensagens` VALUES (52, 6, 5, 'holaas', 1614871182, 0);
INSERT INTO `mensagens` VALUES (53, 5, 6, 'hola prueba', 1614871194, 0);
INSERT INTO `mensagens` VALUES (54, 6, 1, 'danilo como estas', 1614871211, 0);
INSERT INTO `mensagens` VALUES (55, 5, 6, 'asdasdasdsdasd', 1614871223, 0);
INSERT INTO `mensagens` VALUES (56, 6, 2, 'dasdasdasd', 1614871230, 0);
INSERT INTO `mensagens` VALUES (57, 5, 6, 'nuevis', 1614871297, 0);
INSERT INTO `mensagens` VALUES (58, 6, 5, 'hhssshhshs', 1614871307, 0);

-- ----------------------------
-- Table structure for mensajes
-- ----------------------------
DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes`  (
  `id_inyect` int(11) NOT NULL AUTO_INCREMENT,
  `id_tareas` int(11) NULL DEFAULT NULL,
  `fechareal_start` datetime(6) NULL DEFAULT NULL,
  `fechasim_start` datetime(6) NULL DEFAULT NULL,
  `titulo` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `mensaje` text CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL,
  `medios` int(2) NULL DEFAULT NULL,
  `para` varchar(60) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `id_actor` int(11) NULL DEFAULT NULL,
  `actividad_esperada` text CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL,
  `enviado` tinyint(255) NULL DEFAULT NULL,
  `adjunto` varchar(60) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_inyect`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mensajes
-- ----------------------------
INSERT INTO `mensajes` VALUES (2, 8, '2021-03-04 15:50:00.000000', '2021-03-04 15:50:00.000000', NULL, '<table style=\"border-collapse:collapse;width:100%;height:44px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height:22px;\">\r\n<td style=\"width:48.4258%;height:22px;\">Respuesta Respuesta Respuesta Respuesta Respuesta</td>\r\n<td style=\"width:48.4258%;height:22px;\">Respuesta Respuesta</td>\r\n</tr>\r\n<tr style=\"height:22px;\">\r\n<td style=\"width:48.4258%;height:22px;\"> </td>\r\n<td style=\"width:48.4258%;height:22px;\"> </td>\r\n</tr>\r\n</tbody>\r\n</table>', 1, 'P-4,P-9', 1, NULL, NULL, NULL);
INSERT INTO `mensajes` VALUES (3, 7, '2021-03-10 16:42:00.000000', '2021-03-10 16:39:00.000000', 'nuevo mensaje', '<p>Informar sobre el terremoto y ubicarse en el contexto de la simulación</p>', 2, 'S-50,S-50,S-50', 3, NULL, NULL, NULL);
INSERT INTO `mensajes` VALUES (4, 7, '2021-04-08 09:09:00.000000', '2021-04-08 09:09:00.000000', 'Presentación del ejercicio', '<p>Presentación del ejercicio</p>', 1, 'S-50', 4, 'ENTREGAR MAPAS VER CON Costa Rica', NULL, 'screen api sismed911.docx');

-- ----------------------------
-- Table structure for mensajes_usuarios
-- ----------------------------
DROP TABLE IF EXISTS `mensajes_usuarios`;
CREATE TABLE `mensajes_usuarios`  (
  `id_mensaje_usuario` int(5) NOT NULL AUTO_INCREMENT,
  `id_user_remitente` int(5) NULL DEFAULT NULL,
  `id_user_destinatario` int(5) NULL DEFAULT NULL,
  `id_mensaje` int(5) NULL DEFAULT NULL,
  PRIMARY KEY (`id_mensaje_usuario`) USING BTREE,
  INDEX `id_user_remitente`(`id_user_remitente`) USING BTREE,
  INDEX `id_user_destinatario`(`id_user_destinatario`) USING BTREE,
  INDEX `id_mensaje`(`id_mensaje`) USING BTREE,
  CONSTRAINT `mensajes_usuarios_ibfk_1` FOREIGN KEY (`id_user_remitente`) REFERENCES `users` (`id_users`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mensajes_usuarios_ibfk_2` FOREIGN KEY (`id_user_destinatario`) REFERENCES `users` (`id_users`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mensajes_usuarios_ibfk_3` FOREIGN KEY (`id_mensaje`) REFERENCES `mensajes` (`id_inyect`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mensajes_usuarios
-- ----------------------------

-- ----------------------------
-- Table structure for paisgmt
-- ----------------------------
DROP TABLE IF EXISTS `paisgmt`;
CREATE TABLE `paisgmt`  (
  `id_zone` int(11) NOT NULL AUTO_INCREMENT,
  `codpais` varchar(3) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `nompais` varchar(60) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `timezone` varchar(40) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `gmt` varchar(20) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `codiso3` varchar(4) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_zone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 425 CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of paisgmt
-- ----------------------------
INSERT INTO `paisgmt` VALUES (1, 'AF', 'Afghanistan', 'Asia/Kabul', 'UTC +04:30', 'AFG');
INSERT INTO `paisgmt` VALUES (2, 'AX', 'Aland Islands', 'Europe/Mariehamn', 'UTC +03:00', 'ALA');
INSERT INTO `paisgmt` VALUES (3, 'AL', 'Albania', 'Europe/Tirane', 'UTC +02:00', 'ALB');
INSERT INTO `paisgmt` VALUES (4, 'DZ', 'Algeria', 'Africa/Algiers', 'UTC +01:00', 'DZA');
INSERT INTO `paisgmt` VALUES (5, 'AS', 'American Samoa', 'Pacific/Pago_Pago', 'UTC -11:00', 'ASM');
INSERT INTO `paisgmt` VALUES (6, 'AD', 'Andorra', 'Europe/Andorra', 'UTC +02:00', 'AND');
INSERT INTO `paisgmt` VALUES (7, 'AO', 'Angola', 'Africa/Luanda', 'UTC +01:00', 'AGO');
INSERT INTO `paisgmt` VALUES (8, 'AI', 'Anguilla', 'America/Anguilla', 'UTC -04:00', 'AIA');
INSERT INTO `paisgmt` VALUES (9, 'AQ', 'Antarctica', 'Antarctica/Casey', 'UTC +08:00', 'ATA');
INSERT INTO `paisgmt` VALUES (10, 'AQ', 'Antarctica', 'Antarctica/Davis', 'UTC +07:00', 'ATA');
INSERT INTO `paisgmt` VALUES (11, 'AQ', 'Antarctica', 'Antarctica/DumontDUrville', 'UTC +10:00', 'ATA');
INSERT INTO `paisgmt` VALUES (12, 'AQ', 'Antarctica', 'Antarctica/Mawson', 'UTC +05:00', 'ATA');
INSERT INTO `paisgmt` VALUES (13, 'AQ', 'Antarctica', 'Antarctica/McMurdo', 'UTC +12:00', 'ATA');
INSERT INTO `paisgmt` VALUES (14, 'AQ', 'Antarctica', 'Antarctica/Palmer', 'UTC -03:00', 'ATA');
INSERT INTO `paisgmt` VALUES (15, 'AQ', 'Antarctica', 'Antarctica/Rothera', 'UTC -03:00', 'ATA');
INSERT INTO `paisgmt` VALUES (16, 'AQ', 'Antarctica', 'Antarctica/Syowa', 'UTC +03:00', 'ATA');
INSERT INTO `paisgmt` VALUES (17, 'AQ', 'Antarctica', 'Antarctica/Troll', 'UTC +02:00', 'ATA');
INSERT INTO `paisgmt` VALUES (18, 'AQ', 'Antarctica', 'Antarctica/Vostok', 'UTC +06:00', 'ATA');
INSERT INTO `paisgmt` VALUES (19, 'AG', 'Antigua and Barbuda', 'America/Antigua', 'UTC -04:00', 'ATG');
INSERT INTO `paisgmt` VALUES (20, 'AR', 'Argentina', 'America/Argentina/Buenos_Aires', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (21, 'AR', 'Argentina', 'America/Argentina/Catamarca', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (22, 'AR', 'Argentina', 'America/Argentina/Cordoba', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (23, 'AR', 'Argentina', 'America/Argentina/Jujuy', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (24, 'AR', 'Argentina', 'America/Argentina/La_Rioja', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (25, 'AR', 'Argentina', 'America/Argentina/Mendoza', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (26, 'AR', 'Argentina', 'America/Argentina/Rio_Gallegos', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (27, 'AR', 'Argentina', 'America/Argentina/Salta', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (28, 'AR', 'Argentina', 'America/Argentina/San_Juan', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (29, 'AR', 'Argentina', 'America/Argentina/San_Luis', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (30, 'AR', 'Argentina', 'America/Argentina/Tucuman', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (31, 'AR', 'Argentina', 'America/Argentina/Ushuaia', 'UTC -03:00', 'ARG');
INSERT INTO `paisgmt` VALUES (32, 'AM', 'Armenia', 'Asia/Yerevan', 'UTC +04:00', 'ARM');
INSERT INTO `paisgmt` VALUES (33, 'AW', 'Aruba', 'America/Aruba', 'UTC -04:00', 'ABW');
INSERT INTO `paisgmt` VALUES (34, 'AU', 'Australia', 'Antarctica/Macquarie', 'UTC +11:00', 'AUS');
INSERT INTO `paisgmt` VALUES (35, 'AU', 'Australia', 'Australia/Adelaide', 'UTC +09:30', 'AUS');
INSERT INTO `paisgmt` VALUES (36, 'AU', 'Australia', 'Australia/Brisbane', 'UTC +10:00', 'AUS');
INSERT INTO `paisgmt` VALUES (37, 'AU', 'Australia', 'Australia/Broken_Hill', 'UTC +09:30', 'AUS');
INSERT INTO `paisgmt` VALUES (38, 'AU', 'Australia', 'Australia/Currie', 'UTC +10:00', 'AUS');
INSERT INTO `paisgmt` VALUES (39, 'AU', 'Australia', 'Australia/Darwin', 'UTC +09:30', 'AUS');
INSERT INTO `paisgmt` VALUES (40, 'AU', 'Australia', 'Australia/Eucla', 'UTC +08:45', 'AUS');
INSERT INTO `paisgmt` VALUES (41, 'AU', 'Australia', 'Australia/Hobart', 'UTC +10:00', 'AUS');
INSERT INTO `paisgmt` VALUES (42, 'AU', 'Australia', 'Australia/Lindeman', 'UTC +10:00', 'AUS');
INSERT INTO `paisgmt` VALUES (43, 'AU', 'Australia', 'Australia/Lord_Howe', 'UTC +10:30', 'AUS');
INSERT INTO `paisgmt` VALUES (44, 'AU', 'Australia', 'Australia/Melbourne', 'UTC +10:00', 'AUS');
INSERT INTO `paisgmt` VALUES (45, 'AU', 'Australia', 'Australia/Perth', 'UTC +08:00', 'AUS');
INSERT INTO `paisgmt` VALUES (46, 'AU', 'Australia', 'Australia/Sydney', 'UTC +10:00', 'AUS');
INSERT INTO `paisgmt` VALUES (47, 'AT', 'Austria', 'Europe/Vienna', 'UTC +02:00', 'AUT');
INSERT INTO `paisgmt` VALUES (48, 'AZ', 'Azerbaijan', 'Asia/Baku', 'UTC +04:00', 'AZE');
INSERT INTO `paisgmt` VALUES (49, 'BS', 'Bahamas', 'America/Nassau', 'UTC -04:00', 'BHS');
INSERT INTO `paisgmt` VALUES (50, 'BH', 'Bahrain', 'Asia/Bahrain', 'UTC +03:00', 'BHR');
INSERT INTO `paisgmt` VALUES (51, 'BD', 'Bangladesh', 'Asia/Dhaka', 'UTC +06:00', 'BGD');
INSERT INTO `paisgmt` VALUES (52, 'BB', 'Barbados', 'America/Barbados', 'UTC -04:00', 'BRB');
INSERT INTO `paisgmt` VALUES (53, 'BY', 'Belarus', 'Europe/Minsk', 'UTC +03:00', 'BLR');
INSERT INTO `paisgmt` VALUES (54, 'BE', 'Belgium', 'Europe/Brussels', 'UTC +02:00', 'BEL');
INSERT INTO `paisgmt` VALUES (55, 'BZ', 'Belize', 'America/Belize', 'UTC -06:00', 'BLZ');
INSERT INTO `paisgmt` VALUES (56, 'BJ', 'Benin', 'Africa/Porto-Novo', 'UTC +01:00', 'BEN');
INSERT INTO `paisgmt` VALUES (57, 'BM', 'Bermuda', 'Atlantic/Bermuda', 'UTC -03:00', 'BMU');
INSERT INTO `paisgmt` VALUES (58, 'BT', 'Bhutan', 'Asia/Thimphu', 'UTC +06:00', 'BTN');
INSERT INTO `paisgmt` VALUES (59, 'BO', 'Bolivia', 'America/La_Paz', 'UTC -04:00', 'BOL');
INSERT INTO `paisgmt` VALUES (60, 'BQ', 'Bonaire, Saint Eustatius and Saba', 'America/Kralendijk', 'UTC -04:00', 'BES');
INSERT INTO `paisgmt` VALUES (61, 'BA', 'Bosnia and Herzegovina', 'Europe/Sarajevo', 'UTC +02:00', 'BIH');
INSERT INTO `paisgmt` VALUES (62, 'BW', 'Botswana', 'Africa/Gaborone', 'UTC +02:00', 'BWA');
INSERT INTO `paisgmt` VALUES (63, 'BR', 'Brazil', 'America/Araguaina', 'UTC -03:00', 'BRA');
INSERT INTO `paisgmt` VALUES (64, 'BR', 'Brazil', 'America/Bahia', 'UTC -03:00', 'BRA');
INSERT INTO `paisgmt` VALUES (65, 'BR', 'Brazil', 'America/Belem', 'UTC -03:00', 'BRA');
INSERT INTO `paisgmt` VALUES (66, 'BR', 'Brazil', 'America/Boa_Vista', 'UTC -04:00', 'BRA');
INSERT INTO `paisgmt` VALUES (67, 'BR', 'Brazil', 'America/Campo_Grande', 'UTC -04:00', 'BRA');
INSERT INTO `paisgmt` VALUES (68, 'BR', 'Brazil', 'America/Cuiaba', 'UTC -04:00', 'BRA');
INSERT INTO `paisgmt` VALUES (69, 'BR', 'Brazil', 'America/Eirunepe', 'UTC -05:00', 'BRA');
INSERT INTO `paisgmt` VALUES (70, 'BR', 'Brazil', 'America/Fortaleza', 'UTC -03:00', 'BRA');
INSERT INTO `paisgmt` VALUES (71, 'BR', 'Brazil', 'America/Maceio', 'UTC -03:00', 'BRA');
INSERT INTO `paisgmt` VALUES (72, 'BR', 'Brazil', 'America/Manaus', 'UTC -04:00', 'BRA');
INSERT INTO `paisgmt` VALUES (73, 'BR', 'Brazil', 'America/Noronha', 'UTC -02:00', 'BRA');
INSERT INTO `paisgmt` VALUES (74, 'BR', 'Brazil', 'America/Porto_Velho', 'UTC -04:00', 'BRA');
INSERT INTO `paisgmt` VALUES (75, 'BR', 'Brazil', 'America/Recife', 'UTC -03:00', 'BRA');
INSERT INTO `paisgmt` VALUES (76, 'BR', 'Brazil', 'America/Rio_Branco', 'UTC -05:00', 'BRA');
INSERT INTO `paisgmt` VALUES (77, 'BR', 'Brazil', 'America/Santarem', 'UTC -03:00', 'BRA');
INSERT INTO `paisgmt` VALUES (78, 'BR', 'Brazil', 'America/Sao_Paulo', 'UTC -03:00', 'BRA');
INSERT INTO `paisgmt` VALUES (79, 'IO', 'British Indian Ocean Territory', 'Indian/Chagos', 'UTC +06:00', 'IOT');
INSERT INTO `paisgmt` VALUES (80, 'VG', 'British Virgin Islands', 'America/Tortola', 'UTC -04:00', 'VGB');
INSERT INTO `paisgmt` VALUES (81, 'BN', 'Brunei', 'Asia/Brunei', 'UTC +08:00', 'BRN');
INSERT INTO `paisgmt` VALUES (82, 'BG', 'Bulgaria', 'Europe/Sofia', 'UTC +03:00', 'BGR');
INSERT INTO `paisgmt` VALUES (83, 'BF', 'Burkina Faso', 'Africa/Ouagadougou', 'UTC', 'BFA');
INSERT INTO `paisgmt` VALUES (84, 'BI', 'Burundi', 'Africa/Bujumbura', 'UTC +02:00', 'BDI');
INSERT INTO `paisgmt` VALUES (85, 'KH', 'Cambodia', 'Asia/Phnom_Penh', 'UTC +07:00', 'KHM');
INSERT INTO `paisgmt` VALUES (86, 'CM', 'Cameroon', 'Africa/Douala', 'UTC +01:00', 'CMR');
INSERT INTO `paisgmt` VALUES (87, 'CA', 'Canada', 'America/Atikokan', 'UTC -05:00', 'CAN');
INSERT INTO `paisgmt` VALUES (88, 'CA', 'Canada', 'America/Blanc-Sablon', 'UTC -04:00', 'CAN');
INSERT INTO `paisgmt` VALUES (89, 'CA', 'Canada', 'America/Cambridge_Bay', 'UTC -06:00', 'CAN');
INSERT INTO `paisgmt` VALUES (90, 'CA', 'Canada', 'America/Creston', 'UTC -07:00', 'CAN');
INSERT INTO `paisgmt` VALUES (91, 'CA', 'Canada', 'America/Dawson', 'UTC -07:00', 'CAN');
INSERT INTO `paisgmt` VALUES (92, 'CA', 'Canada', 'America/Dawson_Creek', 'UTC -07:00', 'CAN');
INSERT INTO `paisgmt` VALUES (93, 'CA', 'Canada', 'America/Edmonton', 'UTC -06:00', 'CAN');
INSERT INTO `paisgmt` VALUES (94, 'CA', 'Canada', 'America/Fort_Nelson', 'UTC -07:00', 'CAN');
INSERT INTO `paisgmt` VALUES (95, 'CA', 'Canada', 'America/Glace_Bay', 'UTC -03:00', 'CAN');
INSERT INTO `paisgmt` VALUES (96, 'CA', 'Canada', 'America/Goose_Bay', 'UTC -03:00', 'CAN');
INSERT INTO `paisgmt` VALUES (97, 'CA', 'Canada', 'America/Halifax', 'UTC -03:00', 'CAN');
INSERT INTO `paisgmt` VALUES (98, 'CA', 'Canada', 'America/Inuvik', 'UTC -06:00', 'CAN');
INSERT INTO `paisgmt` VALUES (99, 'CA', 'Canada', 'America/Iqaluit', 'UTC -04:00', 'CAN');
INSERT INTO `paisgmt` VALUES (100, 'CA', 'Canada', 'America/Moncton', 'UTC -03:00', 'CAN');
INSERT INTO `paisgmt` VALUES (101, 'CA', 'Canada', 'America/Nipigon', 'UTC -04:00', 'CAN');
INSERT INTO `paisgmt` VALUES (102, 'CA', 'Canada', 'America/Pangnirtung', 'UTC -04:00', 'CAN');
INSERT INTO `paisgmt` VALUES (103, 'CA', 'Canada', 'America/Rainy_River', 'UTC -05:00', 'CAN');
INSERT INTO `paisgmt` VALUES (104, 'CA', 'Canada', 'America/Rankin_Inlet', 'UTC -05:00', 'CAN');
INSERT INTO `paisgmt` VALUES (105, 'CA', 'Canada', 'America/Regina', 'UTC -06:00', 'CAN');
INSERT INTO `paisgmt` VALUES (106, 'CA', 'Canada', 'America/Resolute', 'UTC -05:00', 'CAN');
INSERT INTO `paisgmt` VALUES (107, 'CA', 'Canada', 'America/St_Johns', 'UTC -02:30', 'CAN');
INSERT INTO `paisgmt` VALUES (108, 'CA', 'Canada', 'America/Swift_Current', 'UTC -06:00', 'CAN');
INSERT INTO `paisgmt` VALUES (109, 'CA', 'Canada', 'America/Thunder_Bay', 'UTC -04:00', 'CAN');
INSERT INTO `paisgmt` VALUES (110, 'CA', 'Canada', 'America/Toronto', 'UTC -04:00', 'CAN');
INSERT INTO `paisgmt` VALUES (111, 'CA', 'Canada', 'America/Vancouver', 'UTC -07:00', 'CAN');
INSERT INTO `paisgmt` VALUES (112, 'CA', 'Canada', 'America/Whitehorse', 'UTC -07:00', 'CAN');
INSERT INTO `paisgmt` VALUES (113, 'CA', 'Canada', 'America/Winnipeg', 'UTC -05:00', 'CAN');
INSERT INTO `paisgmt` VALUES (114, 'CA', 'Canada', 'America/Yellowknife', 'UTC -06:00', 'CAN');
INSERT INTO `paisgmt` VALUES (115, 'CV', 'Cape Verde', 'Atlantic/Cape_Verde', 'UTC -01:00', 'CPV');
INSERT INTO `paisgmt` VALUES (116, 'KY', 'Cayman Islands', 'America/Cayman', 'UTC -05:00', 'CYM');
INSERT INTO `paisgmt` VALUES (117, 'CF', 'Central African Republic', 'Africa/Bangui', 'UTC +01:00', 'CAF');
INSERT INTO `paisgmt` VALUES (118, 'TD', 'Chad', 'Africa/Ndjamena', 'UTC +01:00', 'TCD');
INSERT INTO `paisgmt` VALUES (119, 'CL', 'Chile', 'America/Punta_Arenas', 'UTC -03:00', 'CHL');
INSERT INTO `paisgmt` VALUES (120, 'CL', 'Chile', 'America/Santiago', 'UTC -04:00', 'CHL');
INSERT INTO `paisgmt` VALUES (121, 'CL', 'Chile', 'Pacific/Easter', 'UTC -06:00', 'CHL');
INSERT INTO `paisgmt` VALUES (122, 'CN', 'China', 'Asia/Shanghai', 'UTC +08:00', 'CHN');
INSERT INTO `paisgmt` VALUES (123, 'CN', 'China', 'Asia/Urumqi', 'UTC +06:00', 'CHN');
INSERT INTO `paisgmt` VALUES (124, 'CX', 'Christmas Island', 'Indian/Christmas', 'UTC +07:00', 'CXR');
INSERT INTO `paisgmt` VALUES (125, 'CC', 'Cocos Islands', 'Indian/Cocos', 'UTC +06:30', 'CCK');
INSERT INTO `paisgmt` VALUES (126, 'CO', 'Colombia', 'America/Bogota', 'UTC -05:00', 'COL');
INSERT INTO `paisgmt` VALUES (127, 'KM', 'Comoros', 'Indian/Comoro', 'UTC +03:00', 'COM');
INSERT INTO `paisgmt` VALUES (128, 'CK', 'Cook Islands', 'Pacific/Rarotonga', 'UTC -10:00', 'COK');
INSERT INTO `paisgmt` VALUES (129, 'CR', 'Costa Rica', 'America/Costa_Rica', 'UTC -06:00', 'CRI');
INSERT INTO `paisgmt` VALUES (130, 'HR', 'Croatia', 'Europe/Zagreb', 'UTC +02:00', 'HRV');
INSERT INTO `paisgmt` VALUES (131, 'CU', 'Cuba', 'America/Havana', 'UTC -04:00', 'CUB');
INSERT INTO `paisgmt` VALUES (132, 'CW', 'Curaçao', 'America/Curacao', 'UTC -04:00', 'CUW');
INSERT INTO `paisgmt` VALUES (133, 'CY', 'Cyprus', 'Asia/Famagusta', 'UTC +03:00', 'CYP');
INSERT INTO `paisgmt` VALUES (134, 'CY', 'Cyprus', 'Asia/Nicosia', 'UTC +03:00', 'CYP');
INSERT INTO `paisgmt` VALUES (135, 'CZ', 'Czech Republic', 'Europe/Prague', 'UTC +02:00', 'CZE');
INSERT INTO `paisgmt` VALUES (136, 'CD', 'Democratic Republic of the Congo', 'Africa/Kinshasa', 'UTC +01:00', 'COD');
INSERT INTO `paisgmt` VALUES (137, 'CD', 'Democratic Republic of the Congo', 'Africa/Lubumbashi', 'UTC +02:00', 'COD');
INSERT INTO `paisgmt` VALUES (138, 'DK', 'Denmark', 'Europe/Copenhagen', 'UTC +02:00', 'DNK');
INSERT INTO `paisgmt` VALUES (139, 'DJ', 'Djibouti', 'Africa/Djibouti', 'UTC +03:00', 'DJI');
INSERT INTO `paisgmt` VALUES (140, 'DM', 'Dominica', 'America/Dominica', 'UTC -04:00', 'DMA');
INSERT INTO `paisgmt` VALUES (141, 'DO', 'Dominican Republic', 'America/Santo_Domingo', 'UTC -04:00', 'DOM');
INSERT INTO `paisgmt` VALUES (142, 'TL', 'East Timor', 'Asia/Dili', 'UTC +09:00', 'TLS');
INSERT INTO `paisgmt` VALUES (143, 'EC', 'Ecuador', 'America/Guayaquil', 'UTC -05:00', 'ECU');
INSERT INTO `paisgmt` VALUES (144, 'EC', 'Ecuador', 'Pacific/Galapagos', 'UTC -06:00', 'ECU');
INSERT INTO `paisgmt` VALUES (145, 'EG', 'Egypt', 'Africa/Cairo', 'UTC +02:00', 'EGY');
INSERT INTO `paisgmt` VALUES (146, 'SV', 'El Salvador', 'America/El_Salvador', 'UTC -06:00', 'SLV');
INSERT INTO `paisgmt` VALUES (147, 'GQ', 'Equatorial Guinea', 'Africa/Malabo', 'UTC +01:00', 'GNQ');
INSERT INTO `paisgmt` VALUES (148, 'ER', 'Eritrea', 'Africa/Asmara', 'UTC +03:00', 'ERI');
INSERT INTO `paisgmt` VALUES (149, 'EE', 'Estonia', 'Europe/Tallinn', 'UTC +03:00', 'EST');
INSERT INTO `paisgmt` VALUES (150, 'ET', 'Ethiopia', 'Africa/Addis_Ababa', 'UTC +03:00', 'ETH');
INSERT INTO `paisgmt` VALUES (151, 'FK', 'Falkland Islands', 'Atlantic/Stanley', 'UTC -03:00', 'KLK');
INSERT INTO `paisgmt` VALUES (152, 'FO', 'Faroe Islands', 'Atlantic/Faroe', 'UTC +01:00', 'FRO');
INSERT INTO `paisgmt` VALUES (153, 'FJ', 'Fiji', 'Pacific/Fiji', 'UTC +12:00', 'FJI');
INSERT INTO `paisgmt` VALUES (154, 'FI', 'Finland', 'Europe/Helsinki', 'UTC +03:00', 'FIN');
INSERT INTO `paisgmt` VALUES (155, 'FR', 'France', 'Europe/Paris', 'UTC +02:00', 'FRA');
INSERT INTO `paisgmt` VALUES (156, 'GF', 'French Guiana', 'America/Cayenne', 'UTC -03:00', 'GUF');
INSERT INTO `paisgmt` VALUES (157, 'PF', 'French Polynesia', 'Pacific/Gambier', 'UTC -09:00', 'PYF');
INSERT INTO `paisgmt` VALUES (158, 'PF', 'French Polynesia', 'Pacific/Marquesas', 'UTC -09:30', 'PYF');
INSERT INTO `paisgmt` VALUES (159, 'PF', 'French Polynesia', 'Pacific/Tahiti', 'UTC -10:00', 'PYF');
INSERT INTO `paisgmt` VALUES (160, 'TF', 'French Southern Territories', 'Indian/Kerguelen', 'UTC +05:00', 'ATF');
INSERT INTO `paisgmt` VALUES (161, 'GA', 'Gabon', 'Africa/Libreville', 'UTC +01:00', 'GAB');
INSERT INTO `paisgmt` VALUES (162, 'GM', 'Gambia', 'Africa/Banjul', 'UTC', 'GMB');
INSERT INTO `paisgmt` VALUES (163, 'GE', 'Georgia', 'Asia/Tbilisi', 'UTC +04:00', 'GEO');
INSERT INTO `paisgmt` VALUES (164, 'DE', 'Germany', 'Europe/Berlin', 'UTC +02:00', 'DEU');
INSERT INTO `paisgmt` VALUES (165, 'DE', 'Germany', 'Europe/Busingen', 'UTC +02:00', 'DEU');
INSERT INTO `paisgmt` VALUES (166, 'GH', 'Ghana', 'Africa/Accra', 'UTC', 'GHA');
INSERT INTO `paisgmt` VALUES (167, 'GI', 'Gibraltar', 'Europe/Gibraltar', 'UTC +02:00', 'GIB');
INSERT INTO `paisgmt` VALUES (168, 'GR', 'Greece', 'Europe/Athens', 'UTC +03:00', 'GRC');
INSERT INTO `paisgmt` VALUES (169, 'GL', 'Greenland', 'America/Danmarkshavn', 'UTC', 'GRL');
INSERT INTO `paisgmt` VALUES (170, 'GL', 'Greenland', 'America/Godthab', 'UTC -02:00', 'GRL');
INSERT INTO `paisgmt` VALUES (171, 'GL', 'Greenland', 'America/Scoresbysund', 'UTC', 'GRL');
INSERT INTO `paisgmt` VALUES (172, 'GL', 'Greenland', 'America/Thule', 'UTC -03:00', 'GRL');
INSERT INTO `paisgmt` VALUES (173, 'GD', 'Grenada', 'America/Grenada', 'UTC -04:00', 'GRD');
INSERT INTO `paisgmt` VALUES (174, 'GP', 'Guadeloupe', 'America/Guadeloupe', 'UTC -04:00', 'GLP');
INSERT INTO `paisgmt` VALUES (175, 'GU', 'Guam', 'Pacific/Guam', 'UTC +10:00', 'GUM');
INSERT INTO `paisgmt` VALUES (176, 'GT', 'Guatemala', 'America/Guatemala', 'UTC -06:00', 'GTM');
INSERT INTO `paisgmt` VALUES (177, 'GG', 'Guernsey', 'Europe/Guernsey', 'UTC +01:00', 'GGY');
INSERT INTO `paisgmt` VALUES (178, 'GN', 'Guinea', 'Africa/Conakry', 'UTC', 'GIN');
INSERT INTO `paisgmt` VALUES (179, 'GW', 'Guinea-Bissau', 'Africa/Bissau', 'UTC', 'GNB');
INSERT INTO `paisgmt` VALUES (180, 'GY', 'Guyana', 'America/Guyana', 'UTC -04:00', 'GUY');
INSERT INTO `paisgmt` VALUES (181, 'HT', 'Haiti', 'America/Port-au-Prince', 'UTC -04:00', 'HTI');
INSERT INTO `paisgmt` VALUES (182, 'HN', 'Honduras', 'America/Tegucigalpa', 'UTC -06:00', 'HND');
INSERT INTO `paisgmt` VALUES (183, 'HK', 'Hong Kong', 'Asia/Hong_Kong', 'UTC +08:00', 'HKG');
INSERT INTO `paisgmt` VALUES (184, 'HU', 'Hungary', 'Europe/Budapest', 'UTC +02:00', 'HUN');
INSERT INTO `paisgmt` VALUES (185, 'IS', 'Iceland', 'Atlantic/Reykjavik', 'UTC', 'ISL');
INSERT INTO `paisgmt` VALUES (186, 'IN', 'India', 'Asia/Kolkata', 'UTC +05:30', 'IND');
INSERT INTO `paisgmt` VALUES (187, 'ID', 'Indonesia', 'Asia/Jakarta', 'UTC +07:00', 'IDN');
INSERT INTO `paisgmt` VALUES (188, 'ID', 'Indonesia', 'Asia/Jayapura', 'UTC +09:00', 'IDN');
INSERT INTO `paisgmt` VALUES (189, 'ID', 'Indonesia', 'Asia/Makassar', 'UTC +08:00', 'IDN');
INSERT INTO `paisgmt` VALUES (190, 'ID', 'Indonesia', 'Asia/Pontianak', 'UTC +07:00', 'IDN');
INSERT INTO `paisgmt` VALUES (191, 'IR', 'Iran', 'Asia/Tehran', 'UTC +04:30', 'IRN');
INSERT INTO `paisgmt` VALUES (192, 'IQ', 'Iraq', 'Asia/Baghdad', 'UTC +03:00', 'IRQ');
INSERT INTO `paisgmt` VALUES (193, 'IE', 'Ireland', 'Europe/Dublin', 'UTC +01:00', 'IRL');
INSERT INTO `paisgmt` VALUES (194, 'IM', 'Isle of Man', 'Europe/Isle_of_Man', 'UTC +01:00', 'IMN');
INSERT INTO `paisgmt` VALUES (195, 'IL', 'Israel', 'Asia/Jerusalem', 'UTC +03:00', 'ISR');
INSERT INTO `paisgmt` VALUES (196, 'IT', 'Italy', 'Europe/Rome', 'UTC +02:00', 'ITA');
INSERT INTO `paisgmt` VALUES (197, 'CI', 'Ivory Coast', 'Africa/Abidjan', 'UTC', 'CIV');
INSERT INTO `paisgmt` VALUES (198, 'JM', 'Jamaica', 'America/Jamaica', 'UTC -05:00', 'JAM');
INSERT INTO `paisgmt` VALUES (199, 'JP', 'Japan', 'Asia/Tokyo', 'UTC +09:00', 'JPN');
INSERT INTO `paisgmt` VALUES (200, 'JE', 'Jersey', 'Europe/Jersey', 'UTC +01:00', 'JEY');
INSERT INTO `paisgmt` VALUES (201, 'JO', 'Jordan', 'Asia/Amman', 'UTC +03:00', 'JOR');
INSERT INTO `paisgmt` VALUES (202, 'KZ', 'Kazakhstan', 'Asia/Almaty', 'UTC +06:00', 'KAZ');
INSERT INTO `paisgmt` VALUES (203, 'KZ', 'Kazakhstan', 'Asia/Aqtau', 'UTC +05:00', 'KAZ');
INSERT INTO `paisgmt` VALUES (204, 'KZ', 'Kazakhstan', 'Asia/Aqtobe', 'UTC +05:00', 'KAZ');
INSERT INTO `paisgmt` VALUES (205, 'KZ', 'Kazakhstan', 'Asia/Atyrau', 'UTC +05:00', 'KAZ');
INSERT INTO `paisgmt` VALUES (206, 'KZ', 'Kazakhstan', 'Asia/Oral', 'UTC +05:00', 'KAZ');
INSERT INTO `paisgmt` VALUES (207, 'KZ', 'Kazakhstan', 'Asia/Qyzylorda', 'UTC +06:00', 'KAZ');
INSERT INTO `paisgmt` VALUES (208, 'KE', 'Kenya', 'Africa/Nairobi', 'UTC +03:00', 'KEN');
INSERT INTO `paisgmt` VALUES (209, 'KI', 'Kiribati', 'Pacific/Enderbury', 'UTC +13:00', 'KIR');
INSERT INTO `paisgmt` VALUES (210, 'KI', 'Kiribati', 'Pacific/Kiritimati', 'UTC +14:00', 'KIR');
INSERT INTO `paisgmt` VALUES (211, 'KI', 'Kiribati', 'Pacific/Tarawa', 'UTC +12:00', 'KIR');
INSERT INTO `paisgmt` VALUES (212, 'KW', 'Kuwait', 'Asia/Kuwait', 'UTC +03:00', 'KWT');
INSERT INTO `paisgmt` VALUES (213, 'KG', 'Kyrgyzstan', 'Asia/Bishkek', 'UTC +06:00', 'KGZ');
INSERT INTO `paisgmt` VALUES (214, 'LA', 'Laos', 'Asia/Vientiane', 'UTC +07:00', 'LAO');
INSERT INTO `paisgmt` VALUES (215, 'LV', 'Latvia', 'Europe/Riga', 'UTC +03:00', 'LVA');
INSERT INTO `paisgmt` VALUES (216, 'LB', 'Lebanon', 'Asia/Beirut', 'UTC +03:00', 'LBN');
INSERT INTO `paisgmt` VALUES (217, 'LS', 'Lesotho', 'Africa/Maseru', 'UTC +02:00', 'LSO');
INSERT INTO `paisgmt` VALUES (218, 'LR', 'Liberia', 'Africa/Monrovia', 'UTC', 'LBR');
INSERT INTO `paisgmt` VALUES (219, 'LY', 'Libya', 'Africa/Tripoli', 'UTC +02:00', 'LBY');
INSERT INTO `paisgmt` VALUES (220, 'LI', 'Liechtenstein', 'Europe/Vaduz', 'UTC +02:00', 'LIE');
INSERT INTO `paisgmt` VALUES (221, 'LT', 'Lithuania', 'Europe/Vilnius', 'UTC +03:00', 'LTU');
INSERT INTO `paisgmt` VALUES (222, 'LU', 'Luxembourg', 'Europe/Luxembourg', 'UTC +02:00', 'LUX');
INSERT INTO `paisgmt` VALUES (223, 'MO', 'Macao', 'Asia/Macau', 'UTC +08:00', 'MAC');
INSERT INTO `paisgmt` VALUES (224, 'MK', 'Macedonia', 'Europe/Skopje', 'UTC +02:00', 'MKD');
INSERT INTO `paisgmt` VALUES (225, 'MG', 'Madagascar', 'Indian/Antananarivo', 'UTC +03:00', 'MDG');
INSERT INTO `paisgmt` VALUES (226, 'MW', 'Malawi', 'Africa/Blantyre', 'UTC +02:00', 'MWI');
INSERT INTO `paisgmt` VALUES (227, 'MY', 'Malaysia', 'Asia/Kuala_Lumpur', 'UTC +08:00', 'MYS');
INSERT INTO `paisgmt` VALUES (228, 'MY', 'Malaysia', 'Asia/Kuching', 'UTC +08:00', 'MYS');
INSERT INTO `paisgmt` VALUES (229, 'MV', 'Maldives', 'Indian/Maldives', 'UTC +05:00', 'MDV');
INSERT INTO `paisgmt` VALUES (230, 'ML', 'Mali', 'Africa/Bamako', 'UTC', 'MLI');
INSERT INTO `paisgmt` VALUES (231, 'MT', 'Malta', 'Europe/Malta', 'UTC +02:00', 'MLT');
INSERT INTO `paisgmt` VALUES (232, 'MH', 'Marshall Islands', 'Pacific/Kwajalein', 'UTC +12:00', 'MHL');
INSERT INTO `paisgmt` VALUES (233, 'MH', 'Marshall Islands', 'Pacific/Majuro', 'UTC +12:00', 'MHL');
INSERT INTO `paisgmt` VALUES (234, 'MQ', 'Martinique', 'America/Martinique', 'UTC -04:00', 'MTQ');
INSERT INTO `paisgmt` VALUES (235, 'MR', 'Mauritania', 'Africa/Nouakchott', 'UTC', 'MRT');
INSERT INTO `paisgmt` VALUES (236, 'MU', 'Mauritius', 'Indian/Mauritius', 'UTC +04:00', 'MUS');
INSERT INTO `paisgmt` VALUES (237, 'YT', 'Mayotte', 'Indian/Mayotte', 'UTC +03:00', 'MYT');
INSERT INTO `paisgmt` VALUES (238, 'MX', 'Mexico', 'America/Bahia_Banderas', 'UTC -05:00', 'MEX');
INSERT INTO `paisgmt` VALUES (239, 'MX', 'Mexico', 'America/Cancun', 'UTC -05:00', 'MEX');
INSERT INTO `paisgmt` VALUES (240, 'MX', 'Mexico', 'America/Chihuahua', 'UTC -06:00', 'MEX');
INSERT INTO `paisgmt` VALUES (241, 'MX', 'Mexico', 'America/Hermosillo', 'UTC -07:00', 'MEX');
INSERT INTO `paisgmt` VALUES (242, 'MX', 'Mexico', 'America/Matamoros', 'UTC -05:00', 'MEX');
INSERT INTO `paisgmt` VALUES (243, 'MX', 'Mexico', 'America/Mazatlan', 'UTC -06:00', 'MEX');
INSERT INTO `paisgmt` VALUES (244, 'MX', 'Mexico', 'America/Merida', 'UTC -05:00', 'MEX');
INSERT INTO `paisgmt` VALUES (245, 'MX', 'Mexico', 'America/Mexico_City', 'UTC -05:00', 'MEX');
INSERT INTO `paisgmt` VALUES (246, 'MX', 'Mexico', 'America/Monterrey', 'UTC -05:00', 'MEX');
INSERT INTO `paisgmt` VALUES (247, 'MX', 'Mexico', 'America/Ojinaga', 'UTC -06:00', 'MEX');
INSERT INTO `paisgmt` VALUES (248, 'MX', 'Mexico', 'America/Tijuana', 'UTC -07:00', 'MEX');
INSERT INTO `paisgmt` VALUES (249, 'FM', 'Micronesia', 'Pacific/Chuuk', 'UTC +10:00', 'FSM');
INSERT INTO `paisgmt` VALUES (250, 'FM', 'Micronesia', 'Pacific/Kosrae', 'UTC +11:00', 'FSM');
INSERT INTO `paisgmt` VALUES (251, 'FM', 'Micronesia', 'Pacific/Pohnpei', 'UTC +11:00', 'FSM');
INSERT INTO `paisgmt` VALUES (252, 'MD', 'Moldova', 'Europe/Chisinau', 'UTC +03:00', 'MDA');
INSERT INTO `paisgmt` VALUES (253, 'MC', 'Monaco', 'Europe/Monaco', 'UTC +02:00', 'MCO');
INSERT INTO `paisgmt` VALUES (254, 'MN', 'Mongolia', 'Asia/Choibalsan', 'UTC +08:00', 'MNG');
INSERT INTO `paisgmt` VALUES (255, 'MN', 'Mongolia', 'Asia/Hovd', 'UTC +07:00', 'MNG');
INSERT INTO `paisgmt` VALUES (256, 'MN', 'Mongolia', 'Asia/Ulaanbaatar', 'UTC +08:00', 'MNG');
INSERT INTO `paisgmt` VALUES (257, 'ME', 'Montenegro', 'Europe/Podgorica', 'UTC +02:00', 'MNE');
INSERT INTO `paisgmt` VALUES (258, 'MS', 'Montserrat', 'America/Montserrat', 'UTC -04:00', 'MSR');
INSERT INTO `paisgmt` VALUES (259, 'MA', 'Morocco', 'Africa/Casablanca', 'UTC +01:00', 'MAR');
INSERT INTO `paisgmt` VALUES (260, 'MZ', 'Mozambique', 'Africa/Maputo', 'UTC +02:00', 'MOZ');
INSERT INTO `paisgmt` VALUES (261, 'MM', 'Myanmar', 'Asia/Yangon', 'UTC +06:30', 'MMR');
INSERT INTO `paisgmt` VALUES (262, 'NA', 'Namibia', 'Africa/Windhoek', 'UTC +02:00', 'NAM');
INSERT INTO `paisgmt` VALUES (263, 'NR', 'Nauru', 'Pacific/Nauru', 'UTC +12:00', 'NRU');
INSERT INTO `paisgmt` VALUES (264, 'NP', 'Nepal', 'Asia/Kathmandu', 'UTC +05:45', 'NPL');
INSERT INTO `paisgmt` VALUES (265, 'NL', 'Netherlands', 'Europe/Amsterdam', 'UTC +02:00', 'NLD');
INSERT INTO `paisgmt` VALUES (266, 'NC', 'New Caledonia', 'Pacific/Noumea', 'UTC +11:00', 'NCL');
INSERT INTO `paisgmt` VALUES (267, 'NZ', 'New Zealand', 'Pacific/Auckland', 'UTC +12:00', 'NZL');
INSERT INTO `paisgmt` VALUES (268, 'NZ', 'New Zealand', 'Pacific/Chatham', 'UTC +12:45', 'NZL');
INSERT INTO `paisgmt` VALUES (269, 'NI', 'Nicaragua', 'America/Managua', 'UTC -06:00', 'NIC');
INSERT INTO `paisgmt` VALUES (270, 'NE', 'Niger', 'Africa/Niamey', 'UTC +01:00', 'NER');
INSERT INTO `paisgmt` VALUES (271, 'NG', 'Nigeria', 'Africa/Lagos', 'UTC +01:00', 'NGA');
INSERT INTO `paisgmt` VALUES (272, 'NU', 'Niue', 'Pacific/Niue', 'UTC -11:00', 'NIU');
INSERT INTO `paisgmt` VALUES (273, 'NF', 'Norfolk Island', 'Pacific/Norfolk', 'UTC +11:00', 'NFK');
INSERT INTO `paisgmt` VALUES (274, 'KP', 'North Korea', 'Asia/Pyongyang', 'UTC +09:00', 'PRK');
INSERT INTO `paisgmt` VALUES (275, 'MP', 'Northern Mariana Islands', 'Pacific/Saipan', 'UTC +10:00', 'MNP');
INSERT INTO `paisgmt` VALUES (276, 'NO', 'Norway', 'Europe/Oslo', 'UTC +02:00', 'NOR');
INSERT INTO `paisgmt` VALUES (277, 'OM', 'Oman', 'Asia/Muscat', 'UTC +04:00', 'OMN');
INSERT INTO `paisgmt` VALUES (278, 'PK', 'Pakistan', 'Asia/Karachi', 'UTC +05:00', 'PAK');
INSERT INTO `paisgmt` VALUES (279, 'PW', 'Palau', 'Pacific/Palau', 'UTC +09:00', 'PLW');
INSERT INTO `paisgmt` VALUES (280, 'PS', 'Palestinian Territory', 'Asia/Gaza', 'UTC +03:00', 'PSE');
INSERT INTO `paisgmt` VALUES (281, 'PS', 'Palestinian Territory', 'Asia/Hebron', 'UTC +03:00', 'PSE');
INSERT INTO `paisgmt` VALUES (282, 'PA', 'Panama', 'America/Panama', 'UTC -05:00', 'PAN');
INSERT INTO `paisgmt` VALUES (283, 'PG', 'Papua New Guinea', 'Pacific/Bougainville', 'UTC +11:00', 'PNG');
INSERT INTO `paisgmt` VALUES (284, 'PG', 'Papua New Guinea', 'Pacific/Port_Moresby', 'UTC +10:00', 'PNG');
INSERT INTO `paisgmt` VALUES (285, 'PY', 'Paraguay', 'America/Asuncion', 'UTC -04:00', 'PRY');
INSERT INTO `paisgmt` VALUES (286, 'PE', 'Peru', 'America/Lima', 'UTC -05:00', 'PER');
INSERT INTO `paisgmt` VALUES (287, 'PH', 'Philippines', 'Asia/Manila', 'UTC +08:00', 'PHL');
INSERT INTO `paisgmt` VALUES (288, 'PN', 'Pitcairn', 'Pacific/Pitcairn', 'UTC -08:00', 'PCN');
INSERT INTO `paisgmt` VALUES (289, 'PL', 'Poland', 'Europe/Warsaw', 'UTC +02:00', 'POL');
INSERT INTO `paisgmt` VALUES (290, 'PT', 'Portugal', 'Atlantic/Azores', 'UTC', 'PRT');
INSERT INTO `paisgmt` VALUES (291, 'PT', 'Portugal', 'Atlantic/Madeira', 'UTC +01:00', 'PRT');
INSERT INTO `paisgmt` VALUES (292, 'PT', 'Portugal', 'Europe/Lisbon', 'UTC +01:00', 'PRT');
INSERT INTO `paisgmt` VALUES (293, 'PR', 'Puerto Rico', 'America/Puerto_Rico', 'UTC -04:00', 'PRI');
INSERT INTO `paisgmt` VALUES (294, 'QA', 'Qatar', 'Asia/Qatar', 'UTC +03:00', 'QAT');
INSERT INTO `paisgmt` VALUES (295, 'CG', 'Republic of the Congo', 'Africa/Brazzaville', 'UTC +01:00', 'COG');
INSERT INTO `paisgmt` VALUES (296, 'RE', 'Reunion', 'Indian/Reunion', 'UTC +04:00', 'REU');
INSERT INTO `paisgmt` VALUES (297, 'RO', 'Romania', 'Europe/Bucharest', 'UTC +03:00', 'ROU');
INSERT INTO `paisgmt` VALUES (298, 'RU', 'Russia', 'Asia/Anadyr', 'UTC +12:00', 'RUS');
INSERT INTO `paisgmt` VALUES (299, 'RU', 'Russia', 'Asia/Barnaul', 'UTC +07:00', 'RUS');
INSERT INTO `paisgmt` VALUES (300, 'RU', 'Russia', 'Asia/Chita', 'UTC +09:00', 'RUS');
INSERT INTO `paisgmt` VALUES (301, 'RU', 'Russia', 'Asia/Irkutsk', 'UTC +08:00', 'RUS');
INSERT INTO `paisgmt` VALUES (302, 'RU', 'Russia', 'Asia/Kamchatka', 'UTC +12:00', 'RUS');
INSERT INTO `paisgmt` VALUES (303, 'RU', 'Russia', 'Asia/Khandyga', 'UTC +09:00', 'RUS');
INSERT INTO `paisgmt` VALUES (304, 'RU', 'Russia', 'Asia/Krasnoyarsk', 'UTC +07:00', 'RUS');
INSERT INTO `paisgmt` VALUES (305, 'RU', 'Russia', 'Asia/Magadan', 'UTC +11:00', 'RUS');
INSERT INTO `paisgmt` VALUES (306, 'RU', 'Russia', 'Asia/Novokuznetsk', 'UTC +07:00', 'RUS');
INSERT INTO `paisgmt` VALUES (307, 'RU', 'Russia', 'Asia/Novosibirsk', 'UTC +07:00', 'RUS');
INSERT INTO `paisgmt` VALUES (308, 'RU', 'Russia', 'Asia/Omsk', 'UTC +06:00', 'RUS');
INSERT INTO `paisgmt` VALUES (309, 'RU', 'Russia', 'Asia/Sakhalin', 'UTC +11:00', 'RUS');
INSERT INTO `paisgmt` VALUES (310, 'RU', 'Russia', 'Asia/Srednekolymsk', 'UTC +11:00', 'RUS');
INSERT INTO `paisgmt` VALUES (311, 'RU', 'Russia', 'Asia/Tomsk', 'UTC +07:00', 'RUS');
INSERT INTO `paisgmt` VALUES (312, 'RU', 'Russia', 'Asia/Ust-Nera', 'UTC +10:00', 'RUS');
INSERT INTO `paisgmt` VALUES (313, 'RU', 'Russia', 'Asia/Vladivostok', 'UTC +10:00', 'RUS');
INSERT INTO `paisgmt` VALUES (314, 'RU', 'Russia', 'Asia/Yakutsk', 'UTC +09:00', 'RUS');
INSERT INTO `paisgmt` VALUES (315, 'RU', 'Russia', 'Asia/Yekaterinburg', 'UTC +05:00', 'RUS');
INSERT INTO `paisgmt` VALUES (316, 'RU', 'Russia', 'Europe/Astrakhan', 'UTC +04:00', 'RUS');
INSERT INTO `paisgmt` VALUES (317, 'RU', 'Russia', 'Europe/Kaliningrad', 'UTC +02:00', 'RUS');
INSERT INTO `paisgmt` VALUES (318, 'RU', 'Russia', 'Europe/Kirov', 'UTC +03:00', 'RUS');
INSERT INTO `paisgmt` VALUES (319, 'RU', 'Russia', 'Europe/Moscow', 'UTC +03:00', 'RUS');
INSERT INTO `paisgmt` VALUES (320, 'RU', 'Russia', 'Europe/Samara', 'UTC +04:00', 'RUS');
INSERT INTO `paisgmt` VALUES (321, 'RU', 'Russia', 'Europe/Saratov', 'UTC +04:00', 'RUS');
INSERT INTO `paisgmt` VALUES (322, 'RU', 'Russia', 'Europe/Simferopol', 'UTC +03:00', 'RUS');
INSERT INTO `paisgmt` VALUES (323, 'RU', 'Russia', 'Europe/Ulyanovsk', 'UTC +04:00', 'RUS');
INSERT INTO `paisgmt` VALUES (324, 'RU', 'Russia', 'Europe/Volgograd', 'UTC +03:00', 'RUS');
INSERT INTO `paisgmt` VALUES (325, 'RW', 'Rwanda', 'Africa/Kigali', 'UTC +02:00', 'RWA');
INSERT INTO `paisgmt` VALUES (326, 'BL', 'Saint Barthélemy', 'America/St_Barthelemy', 'UTC -04:00', 'BLM');
INSERT INTO `paisgmt` VALUES (327, 'SH', 'Saint Helena', 'Atlantic/St_Helena', 'UTC', 'SHN');
INSERT INTO `paisgmt` VALUES (328, 'KN', 'Saint Kitts and Nevis', 'America/St_Kitts', 'UTC -04:00', 'KNA');
INSERT INTO `paisgmt` VALUES (329, 'LC', 'Saint Lucia', 'America/St_Lucia', 'UTC -04:00', 'LCA');
INSERT INTO `paisgmt` VALUES (330, 'MF', 'Saint Martin', 'America/Marigot', 'UTC -04:00', 'MAF');
INSERT INTO `paisgmt` VALUES (331, 'PM', 'Saint Pierre and Miquelon', 'America/Miquelon', 'UTC -02:00', 'SPM');
INSERT INTO `paisgmt` VALUES (332, 'VC', 'Saint Vincent and the Grenadines', 'America/St_Vincent', 'UTC -04:00', 'VCT');
INSERT INTO `paisgmt` VALUES (333, 'WS', 'Samoa', 'Pacific/Apia', 'UTC +13:00', 'WSM');
INSERT INTO `paisgmt` VALUES (334, 'SM', 'San Marino', 'Europe/San_Marino', 'UTC +02:00', 'SMR');
INSERT INTO `paisgmt` VALUES (335, 'ST', 'Sao Tome and Principe', 'Africa/Sao_Tome', 'UTC +01:00', 'STP');
INSERT INTO `paisgmt` VALUES (336, 'SA', 'Saudi Arabia', 'Asia/Riyadh', 'UTC +03:00', 'SAU');
INSERT INTO `paisgmt` VALUES (337, 'SN', 'Senegal', 'Africa/Dakar', 'UTC', 'SEN');
INSERT INTO `paisgmt` VALUES (338, 'RS', 'Serbia', 'Europe/Belgrade', 'UTC +02:00', 'SRB');
INSERT INTO `paisgmt` VALUES (339, 'SC', 'Seychelles', 'Indian/Mahe', 'UTC +04:00', 'SYC');
INSERT INTO `paisgmt` VALUES (340, 'SL', 'Sierra Leone', 'Africa/Freetown', 'UTC', 'SLE');
INSERT INTO `paisgmt` VALUES (341, 'SG', 'Singapore', 'Asia/Singapore', 'UTC +08:00', 'SGP');
INSERT INTO `paisgmt` VALUES (342, 'SX', 'Sint Maarten', 'America/Lower_Princes', 'UTC -04:00', 'SXM');
INSERT INTO `paisgmt` VALUES (343, 'SK', 'Slovakia', 'Europe/Bratislava', 'UTC +02:00', 'SVK');
INSERT INTO `paisgmt` VALUES (344, 'SI', 'Slovenia', 'Europe/Ljubljana', 'UTC +02:00', 'SVN');
INSERT INTO `paisgmt` VALUES (345, 'SB', 'Solomon Islands', 'Pacific/Guadalcanal', 'UTC +11:00', 'SLB');
INSERT INTO `paisgmt` VALUES (346, 'SO', 'Somalia', 'Africa/Mogadishu', 'UTC +03:00', 'SOM');
INSERT INTO `paisgmt` VALUES (347, 'ZA', 'South Africa', 'Africa/Johannesburg', 'UTC +02:00', 'ZAF');
INSERT INTO `paisgmt` VALUES (348, 'GS', 'South Georgia and the South Sandwich Islands', 'Atlantic/South_Georgia', 'UTC -02:00', 'SGS');
INSERT INTO `paisgmt` VALUES (349, 'KR', 'South Korea', 'Asia/Seoul', 'UTC +09:00', 'KOR');
INSERT INTO `paisgmt` VALUES (350, 'SS', 'South Sudan', 'Africa/Juba', 'UTC +03:00', 'SSD');
INSERT INTO `paisgmt` VALUES (351, 'ES', 'Spain', 'Africa/Ceuta', 'UTC +02:00', 'ESP');
INSERT INTO `paisgmt` VALUES (352, 'ES', 'Spain', 'Atlantic/Canary', 'UTC +01:00', 'ESP');
INSERT INTO `paisgmt` VALUES (353, 'ES', 'Spain', 'Europe/Madrid', 'UTC +02:00', 'ESP');
INSERT INTO `paisgmt` VALUES (354, 'LK', 'Sri Lanka', 'Asia/Colombo', 'UTC +05:30', 'LKA');
INSERT INTO `paisgmt` VALUES (355, 'SD', 'Sudan', 'Africa/Khartoum', 'UTC +02:00', 'SDN');
INSERT INTO `paisgmt` VALUES (356, 'SR', 'Suriname', 'America/Paramaribo', 'UTC -03:00', 'SUR');
INSERT INTO `paisgmt` VALUES (357, 'SJ', 'Svalbard and Jan Mayen', 'Arctic/Longyearbyen', 'UTC +02:00', 'SJM');
INSERT INTO `paisgmt` VALUES (358, 'SZ', 'Swaziland', 'Africa/Mbabane', 'UTC +02:00', 'SWZ');
INSERT INTO `paisgmt` VALUES (359, 'SE', 'Sweden', 'Europe/Stockholm', 'UTC +02:00', 'SWE');
INSERT INTO `paisgmt` VALUES (360, 'CH', 'Switzerland', 'Europe/Zurich', 'UTC +02:00', 'CHE');
INSERT INTO `paisgmt` VALUES (361, 'SY', 'Syria', 'Asia/Damascus', 'UTC +03:00', 'SYR');
INSERT INTO `paisgmt` VALUES (362, 'TW', 'Taiwan', 'Asia/Taipei', 'UTC +08:00', 'TWN');
INSERT INTO `paisgmt` VALUES (363, 'TJ', 'Tajikistan', 'Asia/Dushanbe', 'UTC +05:00', 'TJK');
INSERT INTO `paisgmt` VALUES (364, 'TZ', 'Tanzania', 'Africa/Dar_es_Salaam', 'UTC +03:00', 'TZA');
INSERT INTO `paisgmt` VALUES (365, 'TH', 'Thailand', 'Asia/Bangkok', 'UTC +07:00', 'THA');
INSERT INTO `paisgmt` VALUES (366, 'TG', 'Togo', 'Africa/Lome', 'UTC', 'TGO');
INSERT INTO `paisgmt` VALUES (367, 'TK', 'Tokelau', 'Pacific/Fakaofo', 'UTC +13:00', 'TKL');
INSERT INTO `paisgmt` VALUES (368, 'TO', 'Tonga', 'Pacific/Tongatapu', 'UTC +13:00', 'TON');
INSERT INTO `paisgmt` VALUES (369, 'TT', 'Trinidad and Tobago', 'America/Port_of_Spain', 'UTC -04:00', 'TTO');
INSERT INTO `paisgmt` VALUES (370, 'TN', 'Tunisia', 'Africa/Tunis', 'UTC +01:00', 'TUN');
INSERT INTO `paisgmt` VALUES (371, 'TR', 'Turkey', 'Europe/Istanbul', 'UTC +03:00', 'TUR');
INSERT INTO `paisgmt` VALUES (372, 'TM', 'Turkmenistan', 'Asia/Ashgabat', 'UTC +05:00', 'TKM');
INSERT INTO `paisgmt` VALUES (373, 'TC', 'Turks and Caicos Islands', 'America/Grand_Turk', 'UTC -04:00', 'TCA');
INSERT INTO `paisgmt` VALUES (374, 'TV', 'Tuvalu', 'Pacific/Funafuti', 'UTC +12:00', 'TUV');
INSERT INTO `paisgmt` VALUES (375, 'VI', 'U.S. Virgin Islands', 'America/St_Thomas', 'UTC -04:00', 'VIR');
INSERT INTO `paisgmt` VALUES (376, 'UG', 'Uganda', 'Africa/Kampala', 'UTC +03:00', 'UGA');
INSERT INTO `paisgmt` VALUES (377, 'UA', 'Ukraine', 'Europe/Kiev', 'UTC +03:00', 'UKR');
INSERT INTO `paisgmt` VALUES (378, 'UA', 'Ukraine', 'Europe/Uzhgorod', 'UTC +03:00', 'UKR');
INSERT INTO `paisgmt` VALUES (379, 'UA', 'Ukraine', 'Europe/Zaporozhye', 'UTC +03:00', 'UKR');
INSERT INTO `paisgmt` VALUES (380, 'AE', 'United Arab Emirates', 'Asia/Dubai', 'UTC +04:00', 'ARE');
INSERT INTO `paisgmt` VALUES (381, 'GB', 'United Kingdom', 'Europe/London', 'UTC +01:00', 'GBR');
INSERT INTO `paisgmt` VALUES (382, 'US', 'United States', 'America/Adak', 'UTC -09:00', 'USA');
INSERT INTO `paisgmt` VALUES (383, 'US', 'United States', 'America/Anchorage', 'UTC -08:00', 'USA');
INSERT INTO `paisgmt` VALUES (384, 'US', 'United States', 'America/Boise', 'UTC -06:00', 'USA');
INSERT INTO `paisgmt` VALUES (385, 'US', 'United States', 'America/Chicago', 'UTC -05:00', 'USA');
INSERT INTO `paisgmt` VALUES (386, 'US', 'United States', 'America/Denver', 'UTC -06:00', 'USA');
INSERT INTO `paisgmt` VALUES (387, 'US', 'United States', 'America/Detroit', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (388, 'US', 'United States', 'America/Indiana/Indianapolis', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (389, 'US', 'United States', 'America/Indiana/Knox', 'UTC -05:00', 'USA');
INSERT INTO `paisgmt` VALUES (390, 'US', 'United States', 'America/Indiana/Marengo', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (391, 'US', 'United States', 'America/Indiana/Petersburg', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (392, 'US', 'United States', 'America/Indiana/Tell_City', 'UTC -05:00', 'USA');
INSERT INTO `paisgmt` VALUES (393, 'US', 'United States', 'America/Indiana/Vevay', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (394, 'US', 'United States', 'America/Indiana/Vincennes', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (395, 'US', 'United States', 'America/Indiana/Winamac', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (396, 'US', 'United States', 'America/Juneau', 'UTC -08:00', 'USA');
INSERT INTO `paisgmt` VALUES (397, 'US', 'United States', 'America/Kentucky/Louisville', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (398, 'US', 'United States', 'America/Kentucky/Monticello', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (399, 'US', 'United States', 'America/Los_Angeles', 'UTC -07:00', 'USA');
INSERT INTO `paisgmt` VALUES (400, 'US', 'United States', 'America/Menominee', 'UTC -05:00', 'USA');
INSERT INTO `paisgmt` VALUES (401, 'US', 'United States', 'America/Metlakatla', 'UTC -08:00', 'USA');
INSERT INTO `paisgmt` VALUES (402, 'US', 'United States', 'America/New_York', 'UTC -04:00', 'USA');
INSERT INTO `paisgmt` VALUES (403, 'US', 'United States', 'America/Nome', 'UTC -08:00', 'USA');
INSERT INTO `paisgmt` VALUES (404, 'US', 'United States', 'America/North_Dakota/Beulah', 'UTC -05:00', 'USA');
INSERT INTO `paisgmt` VALUES (405, 'US', 'United States', 'America/North_Dakota/Center', 'UTC -05:00', 'USA');
INSERT INTO `paisgmt` VALUES (406, 'US', 'United States', 'America/North_Dakota/New_Salem', 'UTC -05:00', 'USA');
INSERT INTO `paisgmt` VALUES (407, 'US', 'United States', 'America/Phoenix', 'UTC -07:00', 'USA');
INSERT INTO `paisgmt` VALUES (408, 'US', 'United States', 'America/Sitka', 'UTC -08:00', 'USA');
INSERT INTO `paisgmt` VALUES (409, 'US', 'United States', 'America/Yakutat', 'UTC -08:00', 'USA');
INSERT INTO `paisgmt` VALUES (410, 'US', 'United States', 'Pacific/Honolulu', 'UTC -10:00', 'USA');
INSERT INTO `paisgmt` VALUES (411, 'UM', 'United States Minor Outlying Islands', 'Pacific/Midway', 'UTC -11:00', 'UMI');
INSERT INTO `paisgmt` VALUES (412, 'UM', 'United States Minor Outlying Islands', 'Pacific/Wake', 'UTC +12:00', 'UMI');
INSERT INTO `paisgmt` VALUES (413, 'UY', 'Uruguay', 'America/Montevideo', 'UTC -03:00', 'URY');
INSERT INTO `paisgmt` VALUES (414, 'UZ', 'Uzbekistan', 'Asia/Samarkand', 'UTC +05:00', 'UZB');
INSERT INTO `paisgmt` VALUES (415, 'UZ', 'Uzbekistan', 'Asia/Tashkent', 'UTC +05:00', 'UZB');
INSERT INTO `paisgmt` VALUES (416, 'VU', 'Vanuatu', 'Pacific/Efate', 'UTC +11:00', 'VUT');
INSERT INTO `paisgmt` VALUES (417, 'VA', 'Vatican', 'Europe/Vatican', 'UTC +02:00', 'VAT');
INSERT INTO `paisgmt` VALUES (418, 'VE', 'Venezuela', 'America/Caracas', 'UTC -04:00', 'VEN');
INSERT INTO `paisgmt` VALUES (419, 'VN', 'Vietnam', 'Asia/Ho_Chi_Minh', 'UTC +07:00', 'VNM');
INSERT INTO `paisgmt` VALUES (420, 'WF', 'Wallis and Futuna', 'Pacific/Wallis', 'UTC +12:00', 'WLF');
INSERT INTO `paisgmt` VALUES (421, 'EH', 'Western Sahara', 'Africa/El_Aaiun', 'UTC +01:00', 'ESH');
INSERT INTO `paisgmt` VALUES (422, 'YE', 'Yemen', 'Asia/Aden', 'UTC +03:00', 'YEM');
INSERT INTO `paisgmt` VALUES (423, 'ZM', 'Zambia', 'Africa/Lusaka', 'UTC +02:00', 'ZMB');
INSERT INTO `paisgmt` VALUES (424, 'ZW', 'Zimbabwe', 'Africa/Harare', 'UTC +02:00', 'ZWE');

-- ----------------------------
-- Table structure for participantes
-- ----------------------------
DROP TABLE IF EXISTS `participantes`;
CREATE TABLE `participantes`  (
  `id_participantes` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `apellidos` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `grupo` int(11) NULL DEFAULT NULL,
  `subgrupo` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `imagen_participante` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `id_escenario` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_participantes`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of participantes
-- ----------------------------

-- ----------------------------
-- Table structure for permisos_doc
-- ----------------------------
DROP TABLE IF EXISTS `permisos_doc`;
CREATE TABLE `permisos_doc`  (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `id_file` int(11) NULL DEFAULT NULL,
  `id_usuarios` varchar(11) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `tipo_permiso` int(2) NULL DEFAULT NULL,
  `fecha_created` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_permiso`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permisos_doc
-- ----------------------------

-- ----------------------------
-- Table structure for subgrupo
-- ----------------------------
DROP TABLE IF EXISTS `subgrupo`;
CREATE TABLE `subgrupo`  (
  `id_subgrupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_subgrupo` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descripcion_subgrupo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `imagen_subgrupo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `id_grupo` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_subgrupo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subgrupo
-- ----------------------------
INSERT INTO `subgrupo` VALUES (27, 'COSTA RICA', NULL, NULL, 50);
INSERT INTO `subgrupo` VALUES (28, 'CHILE', NULL, NULL, 50);
INSERT INTO `subgrupo` VALUES (29, 'PANAMA', NULL, NULL, 50);
INSERT INTO `subgrupo` VALUES (30, 'Defensa civil Costa Rica', NULL, NULL, 49);

-- ----------------------------
-- Table structure for tareas
-- ----------------------------
DROP TABLE IF EXISTS `tareas`;
CREATE TABLE `tareas`  (
  `id_tarearelacion` int(11) NULL DEFAULT NULL,
  `id_tarea` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_tarea` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descripcion_tarea` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `fechainisimulado_tarea` datetime(6) NULL DEFAULT NULL,
  `fechafinsimulado_tarea` datetime(6) NULL DEFAULT NULL,
  `fechainireal_tarea` datetime(6) NULL DEFAULT NULL,
  `fechafin_tarea` datetime(6) NULL DEFAULT NULL,
  `archivo` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `id_subgrupo` int(11) NULL DEFAULT NULL,
  `id_grupo` int(11) NULL DEFAULT NULL,
  `id_escenario` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_tarea`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tareas
-- ----------------------------
INSERT INTO `tareas` VALUES (6, 7, 'Presentación del Ejercicio', '<p>Descrip</p>', '2021-03-04 15:50:57.000000', '2021-03-04 15:50:57.000000', '2021-03-04 15:50:57.000000', '2021-03-04 15:50:57.000000', NULL, NULL, 49, 40);
INSERT INTO `tareas` VALUES (7, 8, 'Activación de la UCC', '<p>descripción</p>', '2021-03-04 15:50:00.000000', '2021-03-04 15:50:00.000000', '2021-03-04 15:50:00.000000', '2021-03-04 15:50:00.000000', NULL, NULL, 50, 40);

-- ----------------------------
-- Table structure for tipo
-- ----------------------------
DROP TABLE IF EXISTS `tipo`;
CREATE TABLE `tipo`  (
  `id_tipo` int(2) NOT NULL,
  `tipo_es` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `tipo_en` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo
-- ----------------------------
INSERT INTO `tipo` VALUES (1, 'Antrópico ', ' Anthropic');
INSERT INTO `tipo` VALUES (2, 'Biológico ', ' Biological');
INSERT INTO `tipo` VALUES (3, 'Ecológico ', ' Ecological');
INSERT INTO `tipo` VALUES (4, 'Geológico ', ' Geological');
INSERT INTO `tipo` VALUES (5, 'Hidrometeorológico ', ' Hidormeteorological');
INSERT INTO `tipo` VALUES (6, 'Materiales peligrosos ', 'Hazardous materials');
INSERT INTO `tipo` VALUES (7, 'Radiológico ', ' Radiological');
INSERT INTO `tipo` VALUES (8, 'Social ', ' Social');

-- ----------------------------
-- Table structure for todos
-- ----------------------------
DROP TABLE IF EXISTS `todos`;
CREATE TABLE `todos`  (
  `id` int(2) NOT NULL,
  `nombres` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of todos
-- ----------------------------
INSERT INTO `todos` VALUES (-3, 'Todos(Subgrupos)');
INSERT INTO `todos` VALUES (-2, 'Todos(Grupos)');
INSERT INTO `todos` VALUES (-1, 'Todos(Usuarios)');

-- ----------------------------
-- Table structure for userlevelpermissions
-- ----------------------------
DROP TABLE IF EXISTS `userlevelpermissions`;
CREATE TABLE `userlevelpermissions`  (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY (`userlevelid`, `tablename`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of userlevelpermissions
-- ----------------------------
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}correo.php', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}email', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}escenario', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}grupo', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}incidente', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}inicio.php', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}mensagens', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}paisgmt', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}participantes', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}subgrupo', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tareas', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tipo', 0);
INSERT INTO `userlevelpermissions` VALUES (-2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}users', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}correo.php', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}email', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}escenario', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}grupo', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}incidente', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}inicio.php', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}mensagens', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}paisgmt', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}participantes', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}subgrupo', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tareas', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tipo', 0);
INSERT INTO `userlevelpermissions` VALUES (0, '{E72B71B0-0142-48A2-8D2C-143364E37B13}users', 0);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}correo.php', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}email', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}escenario', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}grupo', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}incidente', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}inicio.php', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}mensagens', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}paisgmt', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}participantes', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}subgrupo', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tareas', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tipo', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}userlevelpermissions', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}userlevels', 495);
INSERT INTO `userlevelpermissions` VALUES (1, '{E72B71B0-0142-48A2-8D2C-143364E37B13}users', 495);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}actor_simulado', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}archivos_doc', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}audittrail', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}chat_ini.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}config.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}correo.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}email', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}escenario', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}grupo', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}grupos.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}historico.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}incidente', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}inicio.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}mensagens', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}mensajes', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}mensajes_usuarios', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}menucontenedor.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}onlyoffice.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}paisgmt', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}participantes', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}permisos_doc', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}stream.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}subgrupo', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}submit.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tareas', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}timeline.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tipo', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}todos', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}userlevelpermissions', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}userlevels', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}users', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}valida.php', 511);
INSERT INTO `userlevelpermissions` VALUES (2, '{E72B71B0-0142-48A2-8D2C-143364E37B13}view_from', 511);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}correo.php', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}email', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}escenario', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}grupo', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}incidente', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}inicio.php', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}mensagens', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}paisgmt', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}participantes', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}subgrupo', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tareas', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}tipo', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}userlevelpermissions', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}userlevels', 495);
INSERT INTO `userlevelpermissions` VALUES (3, '{E72B71B0-0142-48A2-8D2C-143364E37B13}users', 495);

-- ----------------------------
-- Table structure for userlevels
-- ----------------------------
DROP TABLE IF EXISTS `userlevels`;
CREATE TABLE `userlevels`  (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(80) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`userlevelid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf32 COLLATE = utf32_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of userlevels
-- ----------------------------
INSERT INTO `userlevels` VALUES (-2, 'Anonymous');
INSERT INTO `userlevels` VALUES (-1, 'Administrator');
INSERT INTO `userlevels` VALUES (0, 'Default');
INSERT INTO `userlevels` VALUES (1, 'EXCON-GENERAL');
INSERT INTO `userlevels` VALUES (2, 'EXCON-GRUPO');
INSERT INTO `userlevels` VALUES (3, 'PARTICIPANTES');
INSERT INTO `userlevels` VALUES (4, 'PARTICIPANTE-LIDER');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id_users` int(11) NOT NULL AUTO_INCREMENT,
  `img_user` varchar(60) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `fecha` datetime(0) NULL DEFAULT NULL,
  `nombres` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `apellidos` varchar(90) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `pais` varchar(4) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `pw` varchar(30) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `perfil` int(20) NULL DEFAULT NULL,
  `grupo` int(11) UNSIGNED NULL DEFAULT 0,
  `subgrupo` int(11) UNSIGNED NULL DEFAULT 0,
  `excon_subgrupo` int(11) NULL DEFAULT NULL,
  `estado` varchar(1) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  `horario` datetime(0) NULL DEFAULT NULL,
  `limite` datetime(0) NULL DEFAULT NULL,
  `blocks` varchar(50) CHARACTER SET utf32 COLLATE utf32_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_users`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, NULL, '2021-03-04 20:30:59', 'Danilo', 'Medina', 'danido@gmail.com', NULL, NULL, '123', 2, 42, 18, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (2, NULL, '2021-03-04 20:30:59', 'Andres', 'Paredes', 'pandres@gmail.com', NULL, NULL, '123', NULL, 43, 22, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (3, NULL, '2021-03-04 20:30:59', 'Mercedes', 'Padilla', 'mercedes@padilla.com', NULL, NULL, '123', NULL, 48, 26, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (4, NULL, '2021-03-04 20:30:59', 'Jose', 'Villota', 'jose@gmail.com', NULL, NULL, '123', NULL, 42, 18, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (5, NULL, '2021-03-04 20:30:59', 'Daniel', 'Bravo', 'dany@gmail.com', NULL, NULL, '123', 2, 42, 18, NULL, '1', NULL, '2021-03-04 21:15:22', '1');
INSERT INTO `users` VALUES (6, NULL, '2021-03-04 20:30:59', 'preuba', 'preuba', 'prueba@gmail.com', NULL, NULL, '123', NULL, 44, 23, NULL, '1', '2021-02-24 00:00:00', '2021-03-04 15:57:25', NULL);
INSERT INTO `users` VALUES (7, NULL, '2021-03-04 20:30:59', 'Juan', 'Perez', 'jam@gmail.com', NULL, NULL, '123', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (8, NULL, '2021-03-04 20:30:59', NULL, NULL, 'juan@gmail.com', NULL, NULL, '1234', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (9, NULL, '2021-03-04 20:31:00', 'Dolores', 'Lopez', 'medis@dolores.com', NULL, NULL, '123', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (10, NULL, '2021-03-04 20:31:00', 'nuev', 'nuevo', 'nuevo@gmail.com', NULL, NULL, '123', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (11, NULL, '2021-02-22 20:51:21', 'nombnre', 'APELLIDOS', 'apem@gmail.com', '123123', 'CO', 'err', 2, 48, 0, NULL, '1', '2021-02-23 00:00:00', '2021-02-26 00:00:00', NULL);
INSERT INTO `users` VALUES (12, NULL, '2021-02-22 20:53:03', 'Dario', 'Mejia', 'dasd@gmail.com', 'e2e', 'AF', '123', 1, 0, 0, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (13, NULL, '2021-02-22 20:54:01', NULL, NULL, 'd3anido@gmail.com', NULL, NULL, '312', 3, 0, 0, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (14, NULL, '2021-02-23 16:06:34', NULL, NULL, 'nuevos@gmail.com', '1222', NULL, '123', 1, 0, 0, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (15, NULL, '2021-02-24 19:01:23', NULL, NULL, 'DAPARES@GMAIL.COM', NULL, NULL, '123', 3, 0, 0, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (16, NULL, '2021-02-24 19:01:49', NULL, NULL, 'DF@GMAIL.COM', NULL, NULL, '123', 3, 0, 0, NULL, '1', NULL, NULL, NULL);
INSERT INTO `users` VALUES (17, NULL, '2021-02-24 19:02:39', 'ANTONIO', 'BRAVO', 'ANTONIO@GMAIL.COM', '123', 'CO', '123', 3, 0, 0, NULL, '1', NULL, NULL, NULL);

-- ----------------------------
-- View structure for view_from
-- ----------------------------
DROP VIEW IF EXISTS `view_from`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_from` AS SELECT Concat('G', '-', grupo.id_grupo) AS id, Concat(grupo.nombre_grupo) AS nombre_agrupacion FROM grupo WHERE grupo.nombre_grupo IS NOT NULL UNION ALL SELECT Concat('P', '-', users.id_users) AS id, Concat('(User) ', users.nombres, ' ', users.apellidos) AS `CONCAT('(User) ',users.nombres,' ',users.apellidos)` FROM users WHERE users.nombres IS NOT NULL UNION ALL SELECT Concat('S', '-', subgrupo.id_grupo) AS id, Concat(grupo.nombre_grupo, ' -', ' (Subgrupo) ', subgrupo.nombre_subgrupo) AS Name_exp_6 FROM subgrupo JOIN grupo ON subgrupo.id_grupo = grupo.id_grupo WHERE subgrupo.nombre_subgrupo IS NOT NULL ORDER BY nombre_agrupacion ;

SET FOREIGN_KEY_CHECKS = 1;
