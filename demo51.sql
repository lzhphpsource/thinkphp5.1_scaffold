/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : demo51

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 07/11/2018 17:02:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for hd_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `hd_auth_group`;
CREATE TABLE `hd_auth_group`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色描述',
  `rules` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `update_time` int(10) UNSIGNED NOT NULL COMMENT '更新时间',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '添加时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`, `create_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of hd_auth_group
-- ----------------------------
INSERT INTO `hd_auth_group` VALUES (31, '超级管理员', '所有权限都有', '112,116,117,118,119,120,121,161,122,162,163,164,128,129,130,173,174,260,175,176,345,155,156,157,199,198,158,200,212,201,202,159,203,204,205,206,207', 1539056159, 1535530706, 1);
INSERT INTO `hd_auth_group` VALUES (32, '测试设置', '测试设置', '112,116,117,118,119,120,121,128,129,130', 1541553847, 1541496768, 1);

-- ----------------------------
-- Table structure for hd_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `hd_auth_group_access`;
CREATE TABLE `hd_auth_group_access`  (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of hd_auth_group_access
-- ----------------------------
INSERT INTO `hd_auth_group_access` VALUES (1251, 32);
INSERT INTO `hd_auth_group_access` VALUES (1297, 31);

-- ----------------------------
-- Table structure for hd_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `hd_auth_rule`;
CREATE TABLE `hd_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `node_icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '节点图标',
  `class_icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类图标',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `condition` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `sort` smallint(6) NOT NULL DEFAULT 0 COMMENT '排序',
  `pid` smallint(6) NOT NULL COMMENT '父级ID',
  `level` tinyint(1) UNSIGNED NOT NULL COMMENT '模块级别',
  `update_time` int(10) UNSIGNED NOT NULL COMMENT '更新时间',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `is_display` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否显示',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 349 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of hd_auth_rule
-- ----------------------------
INSERT INTO `hd_auth_rule` VALUES (112, '/Admin', '后台', 1, '', '', 1, '', 0, 0, 1, 1510821470, 1510821470, 1);
INSERT INTO `hd_auth_rule` VALUES (116, '/Admin/Index', '首页', 1, '', '', 1, '', 1, 112, 2, 1510821685, 1510821685, 1);
INSERT INTO `hd_auth_rule` VALUES (117, '/Admin/Index/index', '后台首页', 1, '', '', 1, '', 0, 116, 3, 1510821714, 1510821714, 1);
INSERT INTO `hd_auth_rule` VALUES (118, '/Admin/Index/home', '欢迎页', 1, '', '', 1, '', 0, 117, 4, 1510821738, 1510821738, 1);
INSERT INTO `hd_auth_rule` VALUES (119, '/Admin/System', '系统', 1, '', '', 1, '', 2, 112, 2, 1510821858, 1510821858, 1);
INSERT INTO `hd_auth_rule` VALUES (120, '/Admin/System/index', '系统配置', 1, '', '', 1, '', 0, 119, 3, 1519893466, 1510821899, 1);
INSERT INTO `hd_auth_rule` VALUES (121, '/Admin/System/setconfig', '网站设置', 1, '', '', 1, '', 1, 120, 4, 1511230393, 1510821953, 1);
INSERT INTO `hd_auth_rule` VALUES (122, '/Admin/System/configlist', '配置列表', 1, '', '', 1, '', 3, 120, 4, 1511230425, 1510822002, 1);
INSERT INTO `hd_auth_rule` VALUES (128, '/Admin/Member', '用户', 1, '', '', 1, '', 3, 112, 2, 1510903419, 1510903374, 1);
INSERT INTO `hd_auth_rule` VALUES (129, '/Admin/Member/index', '会员管理', 1, '', '', 1, '', 0, 128, 3, 1510903806, 1510903806, 1);
INSERT INTO `hd_auth_rule` VALUES (130, '/Admin/Member/userList', '会员列表', 1, '', '', 1, '', 1, 129, 4, 1527299741, 1510903840, 1);
INSERT INTO `hd_auth_rule` VALUES (155, '/Admin/Access', '权限', 1, '', '', 1, '', 99, 112, 2, 1538100786, 1510905487, 1);
INSERT INTO `hd_auth_rule` VALUES (156, '/Admin/Access/index', '权限管理', 1, '', '', 1, '', 0, 155, 3, 1510905515, 1510905515, 1);
INSERT INTO `hd_auth_rule` VALUES (157, '/Admin/Access/authlist', '管理列表', 1, '', '', 1, '', 1, 156, 4, 1511254157, 1510905538, 1);
INSERT INTO `hd_auth_rule` VALUES (158, '/Admin/Access/rolelist', '角色管理', 1, '', '', 1, '', 4, 156, 4, 1519893513, 1510905567, 1);
INSERT INTO `hd_auth_rule` VALUES (159, '/Admin/Access/nodelist', '节点列表', 1, '', '', 1, '', 8, 156, 4, 1511254459, 1510905590, 1);
INSERT INTO `hd_auth_rule` VALUES (161, '/Admin/System/saveallconfig', '提交设置', 1, '', '', 1, '', 2, 120, 4, 1511231152, 1511230376, 0);
INSERT INTO `hd_auth_rule` VALUES (162, '/Admin/System/addconfig', '新增配置', 1, '', '', 1, '', 4, 120, 4, 1511231142, 1511230491, 0);
INSERT INTO `hd_auth_rule` VALUES (163, '/Admin/System/editconfig', '修改配置', 1, '', '', 1, '', 5, 120, 4, 1511231136, 1511230545, 0);
INSERT INTO `hd_auth_rule` VALUES (164, '/Admin/System/delconfig', '删除配置', 1, '', '', 1, '', 6, 120, 4, 1511231126, 1511230582, 0);
INSERT INTO `hd_auth_rule` VALUES (173, '/Admin/Member/useradd', '新增用户', 1, '', '', 1, '', 2, 129, 4, 1535531275, 1511245710, 0);
INSERT INTO `hd_auth_rule` VALUES (174, '/Admin/Member/useredit', '编辑用户', 1, '', '', 1, '', 3, 129, 4, 1535531312, 1511245754, 0);
INSERT INTO `hd_auth_rule` VALUES (175, '/Admin/Member/groupauth', '授权用户', 1, '', '', 1, '', 4, 129, 4, 1515375704, 1511245818, 0);
INSERT INTO `hd_auth_rule` VALUES (176, '/Admin/Member/deluser', '删除用户', 1, '', '', 1, '', 6, 129, 4, 1512525152, 1511245856, 0);
INSERT INTO `hd_auth_rule` VALUES (198, '/Admin/Access/deluser', '删除管理', 1, '', '', 1, '', 3, 156, 4, 1511254227, 1511254183, 0);
INSERT INTO `hd_auth_rule` VALUES (199, '/Admin/Member/groupauth', '授权用户', 1, '', '', 1, '', 2, 156, 4, 1511254236, 1511254218, 0);
INSERT INTO `hd_auth_rule` VALUES (200, '/Admin/Access/addrole', '新增角色', 1, '', '', 1, '', 5, 156, 4, 1511254321, 1511254321, 0);
INSERT INTO `hd_auth_rule` VALUES (201, '/Admin/Access/disabledrole', '禁用角色', 1, '', '', 1, '', 6, 156, 4, 1511254348, 1511254348, 0);
INSERT INTO `hd_auth_rule` VALUES (202, '/Admin/Access/delrole', '删除角色', 1, '', '', 1, '', 7, 156, 4, 1511254376, 1511254376, 0);
INSERT INTO `hd_auth_rule` VALUES (203, '/Admin/Access/add', '新增节点', 1, '', '', 1, '', 9, 156, 4, 1511254488, 1511254488, 0);
INSERT INTO `hd_auth_rule` VALUES (204, '/Admin/Access/delrole', '删除节点', 1, '', '', 1, '', 10, 156, 4, 1511254515, 1511254515, 0);
INSERT INTO `hd_auth_rule` VALUES (205, '/Admin/Access/setstatus', '禁用节点', 1, '', '', 1, '', 11, 156, 4, 1511254540, 1511254540, 0);
INSERT INTO `hd_auth_rule` VALUES (206, '/Admin/Access/edit', '编辑节点', 1, '', '', 1, '', 12, 156, 4, 1511254669, 1511254635, 0);
INSERT INTO `hd_auth_rule` VALUES (207, '/Admin/Access/delnode', '删除节点', 1, '', '', 1, '', 13, 156, 4, 1519895514, 1511254712, 0);
INSERT INTO `hd_auth_rule` VALUES (212, '/Admin/Access/authrole', '角色授权', 1, '', '', 1, '', 5, 156, 4, 1511577101, 1511577101, 0);
INSERT INTO `hd_auth_rule` VALUES (260, '/Admin/Member/disableduser', '拉黑用户', 1, '', '', 1, '', 3, 129, 4, 1515375501, 1515375501, 0);
INSERT INTO `hd_auth_rule` VALUES (345, '/Admin/member/expmember', '导出用户', 1, '', '', 1, '', 7, 129, 4, 1535531363, 1535531363, 0);
INSERT INTO `hd_auth_rule` VALUES (346, '/admin/demo', '测试', 1, '', '', 1, '', 3, 112, 2, 1541574115, 1541574080, 1);
INSERT INTO `hd_auth_rule` VALUES (347, '/admin/demo/index', '测试管理', 1, '', '', 1, '', 1, 346, 3, 1541574103, 1541574103, 1);
INSERT INTO `hd_auth_rule` VALUES (348, '/admin/demo/demoList', '测试列表', 1, '', '', 1, '', 1, 347, 4, 1541574135, 1541574135, 1);

-- ----------------------------
-- Table structure for hd_config
-- ----------------------------
DROP TABLE IF EXISTS `hd_config`;
CREATE TABLE `hd_config`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配置类型',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配置分组',
  `extra` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '配置值',
  `default` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认值',
  `placeholder` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '参数提示',
  `sort` smallint(3) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_name`(`name`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `group`(`group`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 129 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of hd_config
-- ----------------------------
INSERT INTO `hd_config` VALUES (1, 'web_title', 1, '网站标题', 1, '', '请填写网站名称，例如：教师中国', 1456276977, 1479261037, 1, '五加陆健康管理系统', '', '', 0);
INSERT INTO `hd_config` VALUES (2, 'web_keywords', 1, '网站关键词', 1, '', '请填写网站关键词，多个词汇使用 , 分开。例如：教育中国、银行贷款', 1456277098, 1478519645, 1, '五加陆健康管理系统', '', '', 1);
INSERT INTO `hd_config` VALUES (3, 'web_description', 2, '网站描述', 1, '', '请填写网站描述，例如：宣涵投资依托中国最具专业的理财咨询服务平台', 1456277486, 1478519660, 1, '五加陆健康管理系统-一家自己的云平台', '', '', 3);
INSERT INTO `hd_config` VALUES (4, 'config_type_list', 3, '配置类型列表', 3, '', '主要用于数据解析和页面表单的生成', 1378898976, 1478519488, 1, '0:数字\n1:字符\n2:文本\n3:数组\n4:枚举', '', '', 2);
INSERT INTO `hd_config` VALUES (5, 'config_group_list', 3, '配置分组', 3, '', '配置分组', 1379228036, 1526882968, 1, '1:基本\n2:注册\n3:系统\n', '', '', 4);
INSERT INTO `hd_config` VALUES (6, 'web_close', 4, '网站状态', 1, '0:关闭,1:开启', '设置“网站”状态', 1456277699, 1478519535, 1, '1', '', '', 5);
INSERT INTO `hd_config` VALUES (7, 'web_icp', 1, '网站备案', 1, '', '请填写网站版权，例如：京ICP备14041796号', 1456280288, 1478519630, 1, '京ICP备14041796号', '', '', 8);
INSERT INTO `hd_config` VALUES (8, 'system_trace', 4, '调试模式', 3, '0:关闭,1:开启', '是否打开网站页面Trace调试模式', 1456282149, 1478519653, 1, '0', '', '', 1);
INSERT INTO `hd_config` VALUES (9, 'user_allow_register', 4, '会员注册', 2, '0:关闭,1:开启', '会员注册是否开启', 1469941204, 1478603754, 1, '0', '', '', 10);
INSERT INTO `hd_config` VALUES (121, 'sms_expiring_time', 0, '短信验证有效期', 2, '', '请设置短信验证有效期时间（单位秒）', 1481601285, 1481601285, 1, '60', '', '', 75);
INSERT INTO `hd_config` VALUES (128, 'enterprise_telephone', 1, '企业客服电话', 1, '', '请设置企业客服电话', 1489749981, 1489749981, 1, '400-900-6639', '', '', 100);

-- ----------------------------
-- Table structure for hd_member
-- ----------------------------
DROP TABLE IF EXISTS `hd_member`;
CREATE TABLE `hd_member`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID主键',
  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户登录名',
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '会员昵称',
  `mobile` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '手机号码',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '会员密码',
  `avatar` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户头像',
  `register_ip` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '注册IP',
  `login_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '登录时间',
  `login_ip` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录IP',
  `login_num` smallint(4) UNSIGNED NULL DEFAULT 0 COMMENT '登录次数',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '用户状态（0：禁用，1：开启）',
  `register_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '注册时间',
  `update_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE COMMENT '用户名索引'
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户管理表，' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of hd_member
-- ----------------------------
INSERT INTO `hd_member` VALUES (1, '超级管理员', '超级管理员', '15210455141', 'e10adc3949ba59abbe56e057f20f883e', '/public/uploads/product/2018-11-07/5be2a67e5e312.png', '61.48.25.19', 1541580415, '127.0.0.1', 415, 1, 1534323256, 1541066955);

SET FOREIGN_KEY_CHECKS = 1;
