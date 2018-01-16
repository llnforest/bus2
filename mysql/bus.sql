/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : bus

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-01-15 19:00:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员自增ID',
  `name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL COMMENT '管理员的密码',
  `nick_name` varchar(255) DEFAULT NULL COMMENT '管理员的简称',
  `status` int(11) DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；',
  `email` varchar(255) DEFAULT '' COMMENT '邮箱',
  `phone` varchar(15) NOT NULL COMMENT '手机号',
  `last_login_ip` varchar(16) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `create_time` datetime DEFAULT NULL COMMENT '注册时间',
  `role` varchar(255) DEFAULT NULL COMMENT '角色ID',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

-- ----------------------------
-- Records of tp_admin
-- ----------------------------
INSERT INTO `tp_admin` VALUES ('4', 'cs_admin', 'e10adc3949ba59abbe56e057f20f883e', '超管', '1', '', '', '0.0.0.0', '2018-01-08 11:13:18', '2017-10-18 00:07:01', '1', '1');
INSERT INTO `tp_admin` VALUES ('2', 'chenjj', '25d55ad283aa400af464c76d713c07ad', '测试', '1', 'lil@shijiashou.com', '13585788049', '0.0.0.0', '2017-12-08 14:37:46', '2017-12-08 13:50:14', '1,4', '2');
INSERT INTO `tp_admin` VALUES ('3', 'chenj', 'e10adc3949ba59abbe56e057f20f883e', '测试', '1', '892192@qq.com', '13585788049', '0.0.0.0', '2017-12-25 22:33:51', '2017-12-25 17:22:36', '1', '1');
INSERT INTO `tp_admin` VALUES ('1', 'lildh', '0ba1bc1db3ac5bf1de030c56e22a9221', '系统管理员', '1', 'llnforest@gmail.com', '13585788049', '0.0.0.0', '2017-12-27 00:34:13', '2017-12-25 22:38:51', '1', '0');
INSERT INTO `tp_admin` VALUES ('6', 'dh_admin', 'e10adc3949ba59abbe56e057f20f883e', '超级管理员', '1', '', '', null, null, '2017-12-27 00:36:50', '1', '2');

-- ----------------------------
-- Table structure for tp_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_log`;
CREATE TABLE `tp_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `log` longtext NOT NULL COMMENT '日志备注',
  `log_url` varchar(255) NOT NULL COMMENT '执行的URL',
  `username` varchar(255) NOT NULL COMMENT '执行者',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `create_time` datetime NOT NULL COMMENT '操作时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

-- ----------------------------
-- Records of tp_admin_log
-- ----------------------------
INSERT INTO `tp_admin_log` VALUES ('1', '1', '0', '管理员<spen style=\'color: #1dd2af;\'>[ admin ]</spen>偷偷的进入后台了,', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('2', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('3', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('4', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('5', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('6', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('7', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('8', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('9', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('10', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('11', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('12', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('13', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('14', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('15', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('16', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('17', '1', '0', '', '/bus/contact/contactadd.html', '超管', '添加往来', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('18', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('19', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('20', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('21', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('22', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('23', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('24', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('25', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('26', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('27', '1', '0', '2', '/bus/contact/contactedit/id/2.html', '超管', '修改往来', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('28', '1', '0', '', '/bus/contact/contactadd.html', '超管', '添加往来', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('29', '1', '0', '', '/bus/contact/contactadd.html', '超管', '添加往来', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('30', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('31', '1', '0', '', '/bus/contact/contactadd.html', '超管', '添加往来', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('32', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('33', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('34', '2', '0', '管理员测试登录后台', '/index/publics/login.html', '测试', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('35', '2', '0', '管理员测试登录后台', '/index/publics/login.html', '测试', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('36', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('37', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '0000-00-00 00:00:00', '1');
INSERT INTO `tp_admin_log` VALUES ('38', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-09 18:21:13', '1');
INSERT INTO `tp_admin_log` VALUES ('39', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-13 22:24:10', '1');
INSERT INTO `tp_admin_log` VALUES ('40', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-15 00:16:41', '1');
INSERT INTO `tp_admin_log` VALUES ('41', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-16 00:51:48', '1');
INSERT INTO `tp_admin_log` VALUES ('42', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-16 23:23:49', '1');
INSERT INTO `tp_admin_log` VALUES ('43', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-17 20:14:52', '1');
INSERT INTO `tp_admin_log` VALUES ('44', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-17 21:13:50', '1');
INSERT INTO `tp_admin_log` VALUES ('45', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-24 12:12:13', '1');
INSERT INTO `tp_admin_log` VALUES ('46', '1', '0', '', '/bus/corporation/corporationadd.html', '超管', '添加归属', '2017-12-24 12:58:16', '1');
INSERT INTO `tp_admin_log` VALUES ('47', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-25 17:17:28', '1');
INSERT INTO `tp_admin_log` VALUES ('48', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-25 17:20:01', '1');
INSERT INTO `tp_admin_log` VALUES ('49', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-25 19:14:40', '1');
INSERT INTO `tp_admin_log` VALUES ('50', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-25 22:03:32', '1');
INSERT INTO `tp_admin_log` VALUES ('51', '3', '0', '管理员测试登录后台', '/index/publics/login.html', '测试', '后台登录', '2017-12-25 22:03:47', '1');
INSERT INTO `tp_admin_log` VALUES ('52', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-25 22:04:52', '1');
INSERT INTO `tp_admin_log` VALUES ('53', '3', '0', '管理员测试登录后台', '/index/publics/login.html', '测试', '后台登录', '2017-12-25 22:15:33', '1');
INSERT INTO `tp_admin_log` VALUES ('54', '3', '0', '管理员测试登录后台', '/index/publics/login.html', '测试', '后台登录', '2017-12-25 22:31:31', '1');
INSERT INTO `tp_admin_log` VALUES ('55', '1', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-25 22:31:53', '1');
INSERT INTO `tp_admin_log` VALUES ('56', '3', '0', '管理员测试登录后台', '/index/publics/login.html', '测试', '后台登录', '2017-12-25 22:33:51', '1');
INSERT INTO `tp_admin_log` VALUES ('57', '1', '0', '管理员系统管理员登录后台', '/index/publics/login.html', '系统管理员', '后台登录', '2017-12-25 22:43:50', '1');
INSERT INTO `tp_admin_log` VALUES ('58', '4', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-25 22:45:50', '1');
INSERT INTO `tp_admin_log` VALUES ('59', '4', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-26 09:27:53', '1');
INSERT INTO `tp_admin_log` VALUES ('60', '1', '0', '管理员系统管理员登录后台', '/index/publics/login.html', '系统管理员', '后台登录', '2017-12-26 18:42:53', '1');
INSERT INTO `tp_admin_log` VALUES ('61', '4', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-26 22:58:31', '1');
INSERT INTO `tp_admin_log` VALUES ('62', '1', '0', '管理员系统管理员登录后台', '/index/publics/login.html', '系统管理员', '后台登录', '2017-12-27 00:34:13', '0');
INSERT INTO `tp_admin_log` VALUES ('63', '4', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-27 09:26:55', '1');
INSERT INTO `tp_admin_log` VALUES ('64', '4', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-29 10:29:30', '1');
INSERT INTO `tp_admin_log` VALUES ('65', '4', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2017-12-31 21:24:25', '1');
INSERT INTO `tp_admin_log` VALUES ('66', '4', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2018-01-07 21:17:01', '1');
INSERT INTO `tp_admin_log` VALUES ('67', '4', '0', '租车客户：，租车人数：', '/reserve/order/orderadd.html', '超管', '添加订单', '2018-01-07 23:09:40', '1');
INSERT INTO `tp_admin_log` VALUES ('68', '4', '0', '车牌号：', '/bus/bus/busadd.html', '超管', '添加车辆', '2018-01-08 01:07:12', '1');
INSERT INTO `tp_admin_log` VALUES ('69', '4', '0', '派单ID：', '/reserve/record/editreceive/style/1/order_id/201801073430315/id/4.html', '超管', '接单出发', '2018-01-08 01:53:15', '1');
INSERT INTO `tp_admin_log` VALUES ('70', '4', '0', '派单ID：', '/reserve/record/editback/style/1/order_id/201801073430315/id/4.html', '超管', '回车确认', '2018-01-08 01:53:43', '1');
INSERT INTO `tp_admin_log` VALUES ('71', '4', '0', '派单ID：', '/reserve/record/editreceive/style/1/order_id/201801073430315/id/5.html', '超管', '接单出发', '2018-01-08 01:56:10', '1');
INSERT INTO `tp_admin_log` VALUES ('72', '4', '0', '派单ID：', '/reserve/record/editback/style/1/order_id/201801073430315/id/5.html', '超管', '回车确认', '2018-01-08 01:56:17', '1');
INSERT INTO `tp_admin_log` VALUES ('73', '4', '0', '派单ID：', '/reserve/record/editback/style/1/order_id/201801073430315/id/5.html', '超管', '回车确认', '2018-01-08 01:58:42', '1');
INSERT INTO `tp_admin_log` VALUES ('74', '4', '0', '管理员超管登录后台', '/index/publics/login.html', '超管', '后台登录', '2018-01-08 11:13:17', '1');
INSERT INTO `tp_admin_log` VALUES ('75', '4', '0', '租车客户：，租车人数：', '/reserve/order/orderadd.html', '超管', '添加订单', '2018-01-08 11:14:04', '1');
INSERT INTO `tp_admin_log` VALUES ('76', '4', '0', '租车客户：，租车人数：', '/reserve/order/orderadd.html', '超管', '添加订单', '2018-01-08 11:14:32', '1');
INSERT INTO `tp_admin_log` VALUES ('77', '4', '0', '租车客户：，租车人数：', '/reserve/order/orderadd.html', '超管', '添加订单', '2018-01-08 11:43:14', '1');

-- ----------------------------
-- Table structure for tp_auth_menu
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_menu`;
CREATE TABLE `tp_auth_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `app` char(20) NOT NULL COMMENT '应用名称app',
  `model` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '操作名称',
  `url_param` char(50) NOT NULL COMMENT 'url参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `icon` varchar(50) NOT NULL COMMENT '菜单图标',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  `rule_param` varchar(255) NOT NULL COMMENT '验证规则',
  `nav_id` int(11) DEFAULT '0' COMMENT 'nav ID ',
  `request` varchar(255) NOT NULL COMMENT '请求方式（日志生成）',
  `log_rule` varchar(255) NOT NULL COMMENT '日志规则',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `model` (`model`),
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of tp_auth_menu
-- ----------------------------
INSERT INTO `tp_auth_menu` VALUES ('1', '0', 'index', 'auth', 'default', '', '0', '1', '系统管理', '', '', '6', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('2', '1', 'index', 'admin', 'index', '', '0', '1', '权限管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('3', '2', 'index', 'auth', 'role', '', '1', '1', '角色管理', '', '', '1', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('4', '3', 'index', 'auth', 'roleAdd', '', '1', '0', '添加角色', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('5', '3', 'index', 'auth', 'roleEdit', '', '1', '0', '编辑角色', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('6', '3', 'index', 'auth', 'roleDelete', '', '1', '0', '删除角色', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('7', '3', 'index', 'auth', 'authorize', '', '1', '0', '授权角色', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('8', '1', 'index', 'auth', 'menu', '', '1', '1', '菜单管理', '', '', '1', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('36', '2', 'index', 'admin', 'index', '', '1', '1', '用户管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('9', '0', 'reserve', 'order', 'index', '', '1', '1', '预约调度', '', '', '1', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('10', '0', 'bus', 'bus', 'index', '', '1', '1', '车辆管理', '', '', '2', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('11', '0', 'customer', 'index', 'index', '', '1', '1', '客户管理', '', '', '3', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('12', '0', 'finance', 'index', 'index', '', '1', '1', '财务管理', '', '', '4', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('13', '0', 'persion', 'index', 'index', '', '1', '1', '人事管理', '', '', '5', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('14', '9', 'reserve', 'order', 'index', '', '1', '1', '预约中心', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('15', '9', 'reserve', 'record', 'index', '', '1', '1', '调度中心', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('17', '10', 'bus', 'bus', 'index', '', '1', '1', '车辆档案', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('18', '10', 'bus', 'illegal', 'index', '', '1', '1', '违章记录', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('19', '10', 'bus', 'accident', 'index', '', '1', '1', '事故记录', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('20', '10', 'bus', 'check', 'index', '', '1', '1', '年检记录', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('21', '10', 'bus', 'machine', 'index', '', '1', '1', '配件管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('22', '21', 'bus', 'machine', 'machineInList', '', '1', '0', '配件录入列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('23', '21', 'bus', 'machine', 'machineOutList', '', '1', '0', '配件领取列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('24', '11', 'customer', 'contact', 'index', '', '1', '1', '往来单位', '', '', '1', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('25', '10', 'bus', 'corporation', 'index', '', '1', '1', '车辆归属', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('26', '25', 'bus', 'corporation', 'corporationAdd', '', '1', '0', '添加归属', '', '', '0', '', '0', 'POST', '归属名称：{name}');
INSERT INTO `tp_auth_menu` VALUES ('27', '13', 'persion', 'user', 'index', '', '1', '1', '员工管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('28', '13', 'persion', 'department', 'index', '', '1', '1', '部门管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('29', '13', 'persion', 'level', 'index', '', '1', '1', '职级管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('30', '13', 'persion', 'holiday', 'index', '', '1', '1', '请假管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('31', '25', 'bus', 'corporation', 'corporationEdit', '', '1', '0', '修改归属', '', '', '0', '', '0', 'POST', '归属ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('32', '25', 'bus', 'corporation', 'corporationDelete', '', '1', '0', '删除归属', '', '', '0', '', '0', 'POST', '归属ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('33', '24', 'customer', 'contact', 'contactAdd', '', '1', '0', '添加往来', '', '', '0', '', '0', 'POST', '往来单位：{name}');
INSERT INTO `tp_auth_menu` VALUES ('34', '24', 'customer', 'contact', 'contactEdit', '', '1', '0', '修改往来', '', '', '0', '', '0', 'POST', '往来单位ID：{id}，往来单位：{name}');
INSERT INTO `tp_auth_menu` VALUES ('35', '24', 'customer', 'contact', 'contactDelete', '', '1', '0', '删除往来', '', '', '0', '', '0', 'POST', '往来ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('37', '1', 'index', 'auth', 'log', '', '1', '1', '操作日志', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('38', '10', 'bus', 'protect', 'index', '', '1', '1', '维修保养', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('39', '11', 'customer', 'customer', 'index', '', '1', '1', '客户管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('40', '12', 'finance', 'bus', 'index', '', '1', '1', '车辆费用', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('41', '12', 'finance', 'oil', 'index', '', '1', '1', '油费管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('42', '12', 'finance', 'wages', 'index', '', '1', '1', '工资管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('49', '19', 'bus', 'accident', 'accidentAdd', '', '1', '0', '添加事故', '', '', '0', '', '0', 'POST', '驾驶员ID：{user_id}，车辆ID：{bus_id}，事故日期：{accident_date}');
INSERT INTO `tp_auth_menu` VALUES ('44', '12', 'finance', 'reimburse', 'index', '', '1', '1', '报销管理', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('45', '12', 'finance', 'customer', 'index', '', '1', '1', '客户账单', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('46', '0', 'system', 'index', 'index', '', '1', '0', '系统操作', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('47', '46', 'index', 'admin', 'password', '', '1', '0', '修改密码', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('48', '46', 'index', 'upload', 'image', '', '1', '0', '上传图片', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('50', '19', 'bus', 'accident', 'accidentEdit', '', '1', '0', '修改事故', '', '', '0', '', '0', 'POST', '驾驶员ID：{user_id}，车辆ID：{bus_id}，事故日期：{accident_date}');
INSERT INTO `tp_auth_menu` VALUES ('51', '19', 'bus', 'accident', 'accidentDelete', '', '1', '0', '删除事故', '', '', '0', '', '0', 'POST', '事故ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('52', '19', 'bus', 'accident', 'busSelect', '', '1', '0', '选择车牌号', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('53', '19', 'bus', 'accident', 'userSelect', '', '1', '0', '选择驾驶员', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('54', '19', 'bus', 'accident', 'contactSelect', '', '1', '0', '选择往来单位', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('55', '17', 'bus', 'bus', 'busAdd', '', '1', '0', '添加车辆', '', '', '0', '', '0', 'POST', '车牌号：{num}');
INSERT INTO `tp_auth_menu` VALUES ('56', '17', 'bus', 'bus', 'busEdit', '', '1', '0', '修改车辆', '', '', '0', '', '0', 'POST', '车牌号：{num}');
INSERT INTO `tp_auth_menu` VALUES ('57', '17', 'bus', 'bus', 'busStatus', '', '1', '0', '修改状态', '', '', '0', '', '0', 'POST', '车牌ID：{id}，修改后的状态：{status}');
INSERT INTO `tp_auth_menu` VALUES ('58', '17', 'bus', 'bus', 'userSelect', '', '1', '0', '选择驾驶员', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('59', '17', 'bus', 'bus', 'busUserSelect', '', '1', '0', '选择合伙人', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('60', '17', 'bus', 'bus', 'busInfo', '', '1', '0', '车辆信息', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('61', '17', 'bus', 'bus', 'busList', '', '1', '0', '用车列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('62', '17', 'bus', 'bus', 'busUser', '', '1', '0', '股份列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('63', '17', 'bus', 'bus', 'editRate', '', '1', '0', '修改股份比例', '', '', '0', '', '0', 'POST', '股份ID：{id}，改后股份比例：{data}');
INSERT INTO `tp_auth_menu` VALUES ('64', '17', 'bus', 'bus', 'busUserDelete', '', '1', '0', '删除股东', '', '', '0', '', '0', 'POST', '股份ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('65', '17', 'bus', 'bus', 'importBus', '', '1', '0', '导入车辆', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('66', '17', 'bus', 'bus', 'importBusUser', '', '1', '0', '导入股东', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('67', '20', 'bus', 'check', 'checkAdd', '', '1', '0', '添加年检', '', '', '0', '', '0', 'POST', '车辆ID：{id}，年检日期：{check_date}');
INSERT INTO `tp_auth_menu` VALUES ('68', '20', 'bus', 'check', 'checkEdit', '', '1', '0', '修改年检', '', '', '0', '', '0', 'POST', '车辆ID：{id}，年检日期：{check_date}');
INSERT INTO `tp_auth_menu` VALUES ('69', '20', 'bus', 'check', 'checkDelete', '', '1', '0', '删除年检', '', '', '0', '', '0', 'POST', '年检ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('70', '20', 'bus', 'check', 'busSelect', '', '1', '0', '选择车牌号', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('71', '25', 'bus', 'corporation', 'editStatus', '', '1', '0', '修改归属公司状态', '', '', '0', '', '0', 'POST', '归属ID：{id}，修改后的状态：{data}');
INSERT INTO `tp_auth_menu` VALUES ('72', '25', 'bus', 'corporation', 'orderSort', '', '1', '0', '修改排序', '', '', '0', '', '0', 'POST', '归属ID：{id}，修改后的排序：{data}');
INSERT INTO `tp_auth_menu` VALUES ('73', '18', 'bus', 'illegal', 'illegalAdd', '', '1', '0', '添加违章', '', '', '0', '', '0', 'POST', '车辆ID：{bus_id}，驾驶员ID：{user_id}，违章日期：{illegal_date}');
INSERT INTO `tp_auth_menu` VALUES ('74', '18', 'bus', 'illegal', 'illegalEdit', '', '1', '0', '修改违章', '', '', '0', '', '0', 'POST', '车辆ID：{bus_id}，驾驶员ID：{user_id}，违章日期：{illegal_date}');
INSERT INTO `tp_auth_menu` VALUES ('75', '18', 'bus', 'illegal', 'illegalDelete', '', '1', '0', '删除违章', '', '', '0', '', '0', 'POST', '违章ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('76', '18', 'bus', 'illegal', 'busSelect', '', '1', '0', '选择车牌号', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('77', '18', 'bus', 'illegal', 'userSelect', '', '1', '0', '选择驾驶员', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('78', '38', 'bus', 'protect', 'protectAdd', '', '1', '0', '添加维保', '', '', '0', '', '0', 'POST', '车辆ID：{bus_id}，维保日期：{protect_date}');
INSERT INTO `tp_auth_menu` VALUES ('79', '38', 'bus', 'protect', 'protectEdit', '', '1', '0', '修改维保', '', '', '0', '', '0', 'POST', '车辆ID：{bus_id}，维保日期：{protect_date}');
INSERT INTO `tp_auth_menu` VALUES ('80', '38', 'bus', 'protect', 'protectDelete', '', '1', '0', '删除维保', '', '', '0', '', '0', 'POST', '维保ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('81', '38', 'bus', 'protect', 'busSelect', '', '1', '0', '选择车牌号', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('82', '38', 'bus', 'protect', 'contactSelect', '', '1', '0', '选择维保点', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('83', '21', 'bus', 'machine', 'machineAdd', '', '1', '0', '添加配件', '', '', '0', '', '0', 'POST', '配件名称：{name}');
INSERT INTO `tp_auth_menu` VALUES ('84', '21', 'bus', 'machine', 'machineEdit', '', '1', '0', '修改配件', '', '', '0', '', '0', 'POST', '配件名称：{name}');
INSERT INTO `tp_auth_menu` VALUES ('85', '21', 'bus', 'machine', 'machineDelete', '', '1', '0', '删除配件', '', '', '0', '', '0', 'POST', '配件ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('86', '21', 'bus', 'machine', 'machineInDelete', '', '1', '0', '删除进货记录', '', '', '0', '', '0', 'POST', '进货ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('87', '21', 'bus', 'machine', 'machineOutDelete', '', '1', '0', '删除出库记录', '', '', '0', '', '0', 'POST', '出库ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('88', '21', 'bus', 'machine', 'operateAdd', '', '1', '0', '添加配件库存', '', '', '0', '', '0', 'POST', '配件ID：{id}，数量：{num}');
INSERT INTO `tp_auth_menu` VALUES ('89', '21', 'bus', 'machine', 'operateEdit', '', '1', '0', '修改配件库存', '', '', '0', '', '0', 'POST', '配件ID：{id}，数量：{num}');
INSERT INTO `tp_auth_menu` VALUES ('90', '21', 'bus', 'machine', 'userSelect', '', '1', '0', '选择用户', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('91', '21', 'bus', 'machine', 'busSelect', '', '1', '0', '选择车牌号', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('92', '24', 'customer', 'contact', 'editStatus', '', '1', '0', '修改状态', '', '', '0', '', '0', 'POST', '往来单位ID：{id}，修改后的状态：{status}');
INSERT INTO `tp_auth_menu` VALUES ('93', '39', 'customer', 'customer', 'customerAdd', '', '1', '0', '添加客户', '', '', '0', '', '0', 'POST', '客户名称：{name}');
INSERT INTO `tp_auth_menu` VALUES ('94', '39', 'customer', 'customer', 'customerEdit', '', '1', '0', '修改客户', '', '', '0', '', '0', 'POST', '客户ID：{id}，客户名称：{name}');
INSERT INTO `tp_auth_menu` VALUES ('95', '39', 'customer', 'customer', 'customerDelete', '', '1', '0', '删除客户', '', '', '0', '', '0', 'POST', '客户ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('96', '39', 'customer', 'customer', 'editStatus', '', '1', '0', '修改状态', '', '', '0', '', '0', 'POST', '客户ID：{id}，改后状态：{data}');
INSERT INTO `tp_auth_menu` VALUES ('97', '39', 'customer', 'customer', 'importCustomer', '', '1', '0', '导入客户', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('98', '14', 'reserve', 'order', 'orderAdd', '', '1', '0', '添加订单', '', '', '0', '', '0', 'POST', '租车客户：{customer_id}，租车人数：{num}');
INSERT INTO `tp_auth_menu` VALUES ('99', '14', 'reserve', 'order', 'selectBus', '', '1', '0', '派单', '', '', '0', '', '0', 'POST', '订单ID：{id}，派单车辆：{bus_id}');
INSERT INTO `tp_auth_menu` VALUES ('100', '14', 'reserve', 'order', 'editStatus', '', '1', '0', '关闭订单', '', '', '0', '', '0', 'POST', '订单ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('101', '14', 'reserve', 'order', 'customerSelect', '', '1', '0', '选择客户', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('102', '14', 'reserve', 'order', 'userSelect', '', '1', '0', '选择驾驶员', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('103', '15', 'reserve', 'record', 'editReceive', '', '1', '0', '接单出发', '', '', '0', '', '0', 'POST', '派单ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('104', '15', 'reserve', 'record', 'editBack', '', '1', '0', '回车确认', '', '', '0', '', '0', 'POST', '派单ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('105', '15', 'reserve', 'record', 'editOff', '', '1', '0', '取消接单', '', '', '0', '', '0', 'POST', '派单ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('106', '15', 'reserve', 'record', 'recordDelete', '', '1', '0', '删除调度', '', '', '0', '', '0', 'POST', '派单ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('107', '15', 'reserve', 'record', 'recordStatistics', '', '1', '0', '调度统计', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('108', '37', 'index', 'auth', 'viewLog', '', '1', '0', '日志详情', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('109', '37', 'index', 'auth', 'clear', '', '1', '0', '清空日志', '', '', '0', '', '0', 'POST', '');
INSERT INTO `tp_auth_menu` VALUES ('110', '36', 'index', 'admin', 'add', '', '1', '0', '增加用户', '', '', '0', '', '0', 'POST', '用户名：{name}');
INSERT INTO `tp_auth_menu` VALUES ('111', '36', 'index', 'admin', 'edit', '', '1', '0', '修改用户', '', '', '0', '', '0', 'POST', '用户ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('112', '36', 'index', 'admin', 'status', '', '1', '0', '修改状态', '', '', '0', '', '0', 'POST', '用户ID：{id}，修改后状态：{data}');
INSERT INTO `tp_auth_menu` VALUES ('113', '36', 'index', 'admin', 'delete', '', '1', '0', '删除用户', '', '', '0', '', '0', 'POST', '用户ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('114', '28', 'persion', 'department', 'departmentAdd', '', '1', '0', '添加部门', '', '', '0', '', '0', 'POST', '部门名称：{name}');
INSERT INTO `tp_auth_menu` VALUES ('115', '28', 'persion', 'department', 'departmentEdit', '', '1', '0', '修改部门', '', '', '0', '', '0', 'POST', '部门ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('116', '28', 'persion', 'department', 'departmentDelete', '', '1', '0', '删除部门', '', '', '0', '', '0', 'POST', '部门ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('117', '28', 'persion', 'department', 'orderSort', '', '1', '0', '部门排序', '', '', '0', '', '0', 'POST', '部门ID：{id}，排序：{data}');
INSERT INTO `tp_auth_menu` VALUES ('118', '30', 'persion', 'holiday', 'holidayAdd', '', '1', '0', '添加请假', '', '', '0', '', '0', 'POST', '员工ID：{user_id}');
INSERT INTO `tp_auth_menu` VALUES ('119', '30', 'persion', 'holiday', 'holidayEdit', '', '1', '0', '修改请假', '', '', '0', '', '0', 'POST', '请假ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('120', '30', 'persion', 'holiday', 'holidayDelete', '', '1', '0', '删除请假', '', '', '0', '', '0', 'POST', '请假ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('121', '30', 'persion', 'holiday', 'userSelect', '', '1', '0', '选择员工', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('122', '29', 'persion', 'level', 'levelAdd', '', '1', '0', '添加职级', '', '', '0', '', '0', 'POST', '职级名称：{name}');
INSERT INTO `tp_auth_menu` VALUES ('123', '29', 'persion', 'level', 'levelEdit', '', '1', '0', '修改职级', '', '', '0', '', '0', 'POST', '职级ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('124', '29', 'persion', 'level', 'levelDelete', '', '1', '0', '删除职级', '', '', '0', '', '0', 'POST', '职级ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('125', '29', 'persion', 'level', 'orderSort', '', '1', '0', '修改排序', '', '', '0', '', '0', 'POST', '职级ID：{id}，修改后排序：{data}');
INSERT INTO `tp_auth_menu` VALUES ('126', '27', 'persion', 'user', 'userAdd', '', '1', '0', '添加员工', '', '', '0', '', '0', 'POST', '员工名称：{name}');
INSERT INTO `tp_auth_menu` VALUES ('127', '27', 'persion', 'user', 'userEdit', '', '1', '0', '修改员工', '', '', '0', '', '0', 'POST', '员工ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('128', '27', 'persion', 'user', 'userDelete', '', '1', '0', '删除员工', '', '', '0', '', '0', 'POST', '员工ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('129', '27', 'persion', 'user', 'importUser', '', '1', '0', '导入员工', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('130', '40', 'finance', 'bus', 'protect', '', '1', '0', '维修保养列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('131', '40', 'finance', 'bus', 'check', '', '1', '0', '年检列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('132', '40', 'finance', 'bus', 'illegal', '', '1', '0', '违章列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('133', '40', 'finance', 'bus', 'accident', '', '1', '0', '事故列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('134', '40', 'finance', 'bus', 'editMachineMoney', '', '1', '0', '修改进货款', '', '', '0', '', '0', 'POST', '进货ID：{id}，进货金额：{data}');
INSERT INTO `tp_auth_menu` VALUES ('135', '40', 'finance', 'bus', 'editAccidentMoney', '', '1', '0', '修改事故款', '', '', '0', '', '0', 'POST', '事故ID：{id}，事故金额：{data}');
INSERT INTO `tp_auth_menu` VALUES ('136', '40', 'finance', 'bus', 'editCheckMoney', '', '1', '0', '修改年检款', '', '', '0', '', '0', 'POST', '年检ID：{id}，年检金额：{data}');
INSERT INTO `tp_auth_menu` VALUES ('137', '40', 'finance', 'bus', 'editIllegalMoney', '', '1', '0', '修改违章款', '', '', '0', '', '0', 'POST', '违章ID：{id}，违章金额：{data}');
INSERT INTO `tp_auth_menu` VALUES ('138', '40', 'finance', 'bus', 'editProtectMoney', '', '1', '0', '修改维保款', '', '', '0', '', '0', 'POST', '维保ID：{id}，维保金额：{data}');
INSERT INTO `tp_auth_menu` VALUES ('139', '45', 'finance', 'customer', 'customerList', '', '1', '0', '客户账单列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('140', '45', 'finance', 'customer', 'customerSelect', '', '1', '0', '客户选择', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('141', '45', 'finance', 'customer', 'customerAdd', '', '1', '0', '添加账单', '', '', '0', '', '0', 'POST', '入账类型：{type}，入账金额：{money}，入账时间：{add_date}');
INSERT INTO `tp_auth_menu` VALUES ('142', '45', 'finance', 'customer', 'customerDelete', '', '1', '0', '删除账单', '', '', '0', '', '0', 'POST', '账单ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('143', '41', 'finance', 'oil', 'oilAdd', '', '1', '0', '添加油卡', '', '', '0', '', '0', 'POST', '油卡描述：{name}，购买日期：{buy_date}，购买金额：{money}');
INSERT INTO `tp_auth_menu` VALUES ('144', '41', 'finance', 'oil', 'oilEdit', '', '1', '0', '修改油卡', '', '', '0', '', '0', 'POST', '油卡ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('145', '41', 'finance', 'oil', 'oilDelete', '', '1', '0', '删除油卡', '', '', '0', '', '0', 'POST', '油卡ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('146', '41', 'finance', 'oil', 'oilInDelete', '', '1', '0', '删除油卡充值', '', '', '0', '', '0', 'POST', '油卡充值ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('147', '41', 'finance', 'oil', 'addOilIn', '', '1', '0', '充值油卡', '', '', '0', '', '0', 'POST', '油卡ID：{oil_id}，充值金额：{true_money}');
INSERT INTO `tp_auth_menu` VALUES ('148', '41', 'finance', 'oil', 'oilOutDelete', '', '1', '0', '删除加油记录', '', '', '0', '', '0', 'POST', '加油记录ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('149', '41', 'finance', 'oil', 'addOilOut', '', '1', '0', '油卡加油', '', '', '0', '', '0', 'POST', '油卡ID：{oil_id}，加油金额：{fee}');
INSERT INTO `tp_auth_menu` VALUES ('150', '41', 'finance', 'oil', 'busSelect', '', '1', '0', '选择车牌号', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('151', '41', 'finance', 'oil', 'oilIn', '', '1', '0', '油卡充值列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('152', '41', 'finance', 'oil', 'oilOut', '', '1', '0', '加油记录列表', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('153', '41', 'finance', 'oil', 'contactSelect', '', '1', '0', '选择维保点', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('154', '44', 'finance', 'reimburse', 'userSelect', '', '1', '0', '选择员工', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('155', '44', 'finance', 'reimburse', 'reimburseAdd', '', '1', '0', '添加报销', '', '', '0', '', '0', 'POST', '员工ID：{user_id}，报销金额：{fee}');
INSERT INTO `tp_auth_menu` VALUES ('156', '44', 'finance', 'reimburse', 'reimburseEdit', '', '1', '0', '修改报销', '', '', '0', '', '0', 'POST', '报销ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('157', '44', 'finance', 'reimburse', 'reimburseDelete', '', '1', '0', '删除报销', '', '', '0', '', '0', 'POST', '报销ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('158', '42', 'finance', 'wages', 'wagesAdd', '', '1', '0', '添加工资', '', '', '0', '', '0', 'POST', '员工ID：{user_id}，发放时间：{wages_date}');
INSERT INTO `tp_auth_menu` VALUES ('159', '42', 'finance', 'wages', 'wagesEdit', '', '1', '0', '修改工资', '', '', '0', '', '0', 'POST', '工资ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('160', '42', 'finance', 'wages', 'wagesDelete', '', '1', '0', '删除工资', '', '', '0', '', '0', 'POST', '工资ID：{id}');
INSERT INTO `tp_auth_menu` VALUES ('161', '42', 'finance', 'wages', 'userSelect', '', '1', '0', '选择员工', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('162', '42', 'finance', 'wages', 'importWages', '', '1', '0', '导入工资', '', '', '0', '', '0', '', '');
INSERT INTO `tp_auth_menu` VALUES ('163', '1', 'index', 'system', 'index', '', '1', '1', '平台管理', '', '', '2', '', '0', '', '');

-- ----------------------------
-- Table structure for tp_auth_role
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_role`;
CREATE TABLE `tp_auth_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '角色名称',
  `pid` smallint(6) DEFAULT '0' COMMENT '父角色ID',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序字段',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of tp_auth_role
-- ----------------------------
INSERT INTO `tp_auth_role` VALUES ('1', '超级管理员', '0', '1', '拥有网站最高管理员权限！', '0000-00-00 00:00:00', '2017-12-25 22:57:45', '0', '0');
INSERT INTO `tp_auth_role` VALUES ('4', '财务权限', '0', '1', 'admin,admin', '2017-12-08 11:01:25', '2017-12-08 11:01:35', '0', '1');
INSERT INTO `tp_auth_role` VALUES ('3', '人事', '0', '1', '1212', '2017-12-08 10:43:47', '2017-12-08 10:50:21', '0', '1');

-- ----------------------------
-- Table structure for tp_auth_role_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_role_user`;
CREATE TABLE `tp_auth_role_user` (
  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色 id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- ----------------------------
-- Records of tp_auth_role_user
-- ----------------------------
INSERT INTO `tp_auth_role_user` VALUES ('1', '2');
INSERT INTO `tp_auth_role_user` VALUES ('4', '2');
INSERT INTO `tp_auth_role_user` VALUES ('1', '3');
INSERT INTO `tp_auth_role_user` VALUES ('1', '4');

-- ----------------------------
-- Table structure for tp_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_rule`;
CREATE TABLE `tp_auth_rule` (
  `menu_id` int(11) NOT NULL COMMENT '后台菜单 ID',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` varchar(30) NOT NULL DEFAULT '1' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `url_param` varchar(255) DEFAULT NULL COMMENT '额外url参数',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `rule_param` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  `nav_id` int(11) DEFAULT '0' COMMENT 'nav id',
  PRIMARY KEY (`menu_id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限规则表';

-- ----------------------------
-- Records of tp_auth_rule
-- ----------------------------
INSERT INTO `tp_auth_rule` VALUES ('9', 'reserve', 'admin_url', 'reserve/order/index', '', '预约调度', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('10', 'bus', 'admin_url', 'bus/bus/index', '', '车辆管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('11', 'customer', 'admin_url', 'customer/index/index', '', '客户管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('12', 'finance', 'admin_url', 'finance/index/index', '', '财务管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('13', 'persion', 'admin_url', 'persion/index/index', '', '人事管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('14', 'reserve', 'admin_url', 'reserve/order/index', '', '预约记录', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('15', 'reserve', 'admin_url', 'reserve/record/index', '', '调度记录', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('17', 'bus', 'admin_url', 'bus/bus/index', '', '车辆档案', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('18', 'bus', 'admin_url', 'bus/illegal/index', '', '违章记录', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('19', 'bus', 'admin_url', 'bus/accident/index', '', '事故记录', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('20', 'bus', 'admin_url', 'bus/check/index', '', '年检记录', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('21', 'bus', 'admin_url', 'bus/machine/index', '', '配件管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('22', 'bus', 'admin_url', 'bus/machine/machineinlist', '', '配件录入', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('23', 'bus', 'admin_url', 'bus/machine/machineoutlist', '', '配件领取', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('24', 'customer', 'admin_url', 'customer/contact/index', '', '往来单位', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('25', 'bus', 'admin_url', 'bus/corporation/index', '', '车辆归属', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('26', 'bus', 'admin_url', 'bus/corporation/corporationadd', '', '添加归属', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('27', 'persion', 'admin_url', 'persion/user/index', '', '员工管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('28', 'persion', 'admin_url', 'persion/department/index', '', '部门管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('29', 'persion', 'admin_url', 'persion/level/index', '', '职级管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('30', 'persion', 'admin_url', 'persion/holiday/index', '', '请假管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('31', 'bus', 'admin_url', 'bus/corporation/corporationedit', '', '修改归属', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('32', 'bus', 'admin_url', 'bus/corporation/corporationdelete', '', '删除归属', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('33', 'customer', 'admin_url', 'customer/contact/contactadd', '', '添加往来', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('34', 'customer', 'admin_url', 'customer/contact/contactedit', '', '修改往来', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('35', 'customer', 'admin_url', 'customer/contact/contactdelete', '', '删除往来', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('36', 'index', 'admin_url', 'index/admin/index', '', '用户管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('37', 'index', 'admin_url', 'index/auth/log', '', '操作日志', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('38', 'bus', 'admin_url', 'bus/protect/index', '', '维修保养', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('39', 'customer', 'admin_url', 'customer/customer/index', '', '客户管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('40', 'finance', 'admin_url', 'finance/bus/index', '', '车辆费用', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('41', 'finance', 'admin_url', 'finance/oil/index', '', '油费管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('42', 'finance', 'admin_url', 'finance/wages/index', '', '工资管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('44', 'finance', 'admin_url', 'finance/reimburse/index', '', '报销管理', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('45', 'finance', 'admin_url', 'finance/customer/index', '', '客户账单', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('46', 'system', 'admin_url', 'system/index/index', '', '系统操作', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('47', 'index', 'admin_url', 'index/admin/password', '', '修改密码', '1', '', '0');
INSERT INTO `tp_auth_rule` VALUES ('48', 'index', 'admin_url', 'index/upload/image', '', '上传图片', '1', '', '0');

-- ----------------------------
-- Table structure for tp_bus
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus`;
CREATE TABLE `tp_bus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `num` varchar(10) DEFAULT NULL COMMENT '车牌号',
  `brand` varchar(50) DEFAULT NULL COMMENT '厂牌型号',
  `fir_user_id` int(11) DEFAULT '0' COMMENT '主驾驶员id',
  `sec_user_id` int(11) DEFAULT '0' COMMENT '副驾驶员id',
  `site_num` int(11) DEFAULT '0' COMMENT '座位数',
  `buy_date` date DEFAULT NULL COMMENT '购买日期',
  `home_date` date DEFAULT NULL COMMENT '入户日期',
  `drive_year` varchar(5) DEFAULT NULL COMMENT '使用年限',
  `drive_code` varchar(20) DEFAULT NULL COMMENT '行驶证号',
  `business_code` varchar(20) DEFAULT NULL COMMENT '营运证号',
  `engine_code` varchar(20) DEFAULT NULL COMMENT '发动机号',
  `color` varchar(20) DEFAULT NULL COMMENT '颜色',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型 1：自有车 2：加盟车 3：外请车',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 0：停用  1：使用  2：维修  3：报废',
  `department_id` int(11) DEFAULT '0' COMMENT '所属公司内部部门id',
  `corporation_id` int(11) DEFAULT '0' COMMENT '所属公司id',
  `is_bathroom` int(11) DEFAULT '0' COMMENT '是否有卫生间',
  `is_tv` int(11) DEFAULT '0' COMMENT '是否有电视',
  `is_air` int(11) DEFAULT '0' COMMENT '是否有空调',
  `is_microphone` int(11) DEFAULT '0' COMMENT '是否有麦克风',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fir_user_id` (`fir_user_id`),
  KEY `department_id` (`department_id`),
  KEY `corporation_id` (`corporation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='车辆信息表';

-- ----------------------------
-- Records of tp_bus
-- ----------------------------
INSERT INTO `tp_bus` VALUES ('7', '皖A00001', null, '7', '0', '30', null, null, null, null, null, null, null, '1', '1', '0', '4', '0', '0', '1', '0', '2017-12-31 21:29:15', '2017-12-31 21:29:14', '1');
INSERT INTO `tp_bus` VALUES ('8', '皖142423', '大众', '7', '28', '10', '0000-00-00', '0000-00-00', null, '', '', '', '', '1', '1', '0', '3', '0', '1', '1', '0', '2018-01-08 01:07:12', '2018-01-08 01:07:12', '1');

-- ----------------------------
-- Table structure for tp_bus_accident
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_accident`;
CREATE TABLE `tp_bus_accident` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) DEFAULT '0' COMMENT '驾驶员id',
  `bus_id` int(11) DEFAULT '0' COMMENT '车辆id',
  `accident_date` date DEFAULT NULL COMMENT '事故日期',
  `repair_id` int(11) DEFAULT '0' COMMENT '修理店或4S（往来单位）id',
  `lose` int(11) DEFAULT '0' COMMENT '罚款金额',
  `insurance_money` int(11) DEFAULT '0' COMMENT '保险赔偿',
  `contact_id` int(11) DEFAULT '0' COMMENT '保险公司（往来单位）id',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bus_id` (`bus_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='车辆事故记录表';

-- ----------------------------
-- Records of tp_bus_accident
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_check
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_check`;
CREATE TABLE `tp_bus_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bus_id` int(11) DEFAULT '0' COMMENT '车辆id',
  `check_date` date DEFAULT NULL COMMENT '年检日期',
  `end_date` date DEFAULT NULL COMMENT '结束日期',
  `fee` int(11) DEFAULT '0' COMMENT '费用',
  `contact_id` int(11) DEFAULT '0' COMMENT '检测站（往来单位）id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `bus_id` (`bus_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='车辆年检记录表';

-- ----------------------------
-- Records of tp_bus_check
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_contact
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_contact`;
CREATE TABLE `tp_bus_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `contact` varchar(10) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(15) DEFAULT NULL COMMENT '联系方式',
  `status` int(11) DEFAULT '1' COMMENT '状态：0停用 1启用',
  `type` tinyint(1) DEFAULT '1' COMMENT '是否合作 1:4S店 2:油气站 3:车管所 4:保险公司 5:维修店 6:检测站',
  `address` varchar(255) DEFAULT NULL COMMENT '地址信息',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='车辆往来单位表';

-- ----------------------------
-- Records of tp_bus_contact
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_corporation
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_corporation`;
CREATE TABLE `tp_bus_corporation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `contact` varchar(10) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(15) DEFAULT NULL COMMENT '联系方式',
  `status` int(11) DEFAULT '1' COMMENT '状态：0停用 1启用',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='车辆所属公司或个人表';

-- ----------------------------
-- Records of tp_bus_corporation
-- ----------------------------
INSERT INTO `tp_bus_corporation` VALUES ('3', '大恒车行', '大恒', '13842321242', '1', '0', '2017-12-24 12:58:16', '2017-12-25 15:40:50', '1');
INSERT INTO `tp_bus_corporation` VALUES ('4', '昌顺汽车', null, null, '1', '20', '2017-12-25 01:41:51', '2017-12-25 15:40:52', '1');

-- ----------------------------
-- Table structure for tp_bus_customer
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_customer`;
CREATE TABLE `tp_bus_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `user_type` int(11) DEFAULT '1' COMMENT '客户属性：1公司 2个人',
  `user_name` varchar(50) NOT NULL COMMENT '客户姓名',
  `type` int(11) DEFAULT '1' COMMENT '客户类型 1老客户 2临时客户',
  `phone` varchar(15) DEFAULT NULL COMMENT '联系方式',
  `status` int(11) DEFAULT '1' COMMENT '状态：0停用 1启用',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='客户信息表';

-- ----------------------------
-- Records of tp_bus_customer
-- ----------------------------
INSERT INTO `tp_bus_customer` VALUES ('5', '测试公司名', '1', '李林', '1', '13585788049', '1', '2017-12-17 21:03:46', '2017-12-25 15:40:39', '1');
INSERT INTO `tp_bus_customer` VALUES ('6', '测试2', '2', '小李', '2', '13574332123', '1', '2017-12-17 21:05:57', '2017-12-25 15:40:40', '1');
INSERT INTO `tp_bus_customer` VALUES ('7', '大恒客户', '1', '大萨达', '1', '15332232132', '1', '2017-12-17 21:06:59', '2017-12-25 15:40:41', '1');
INSERT INTO `tp_bus_customer` VALUES ('8', '额外儿', '1', '21', '1', '13892341242', '1', '2017-12-17 21:08:37', '2017-12-25 15:40:42', '1');
INSERT INTO `tp_bus_customer` VALUES ('9', '张三', '1', '张三', '1', '18888888888', '1', '2017-12-25 00:50:40', '2017-12-25 15:40:44', '1');

-- ----------------------------
-- Table structure for tp_bus_illegal
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_illegal`;
CREATE TABLE `tp_bus_illegal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) DEFAULT '0' COMMENT '驾驶员id',
  `bus_id` int(11) DEFAULT '0' COMMENT '车辆id',
  `illegal_date` date DEFAULT NULL COMMENT '违章日期',
  `money` int(11) DEFAULT '0' COMMENT '罚款金额',
  `score` int(11) DEFAULT '0' COMMENT '扣分',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bus_id` (`bus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='车辆违章记录表';

-- ----------------------------
-- Records of tp_bus_illegal
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_machine
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_machine`;
CREATE TABLE `tp_bus_machine` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) DEFAULT NULL COMMENT '配件名称',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='车辆配件表';

-- ----------------------------
-- Records of tp_bus_machine
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_machine_in
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_machine_in`;
CREATE TABLE `tp_bus_machine_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `machine_id` int(11) NOT NULL COMMENT '配件id',
  `num` int(11) DEFAULT NULL COMMENT '配件数量',
  `in_date` date DEFAULT NULL COMMENT '购入日期',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '进货费用',
  `user_id` int(11) NOT NULL COMMENT '采购人id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `machine_id` (`machine_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='车辆配件入库记录表';

-- ----------------------------
-- Records of tp_bus_machine_in
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_machine_out
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_machine_out`;
CREATE TABLE `tp_bus_machine_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bus_id` int(11) NOT NULL COMMENT '车辆id',
  `machine_id` int(11) NOT NULL COMMENT '配件id',
  `num` int(11) DEFAULT NULL COMMENT '使用数量',
  `out_date` date DEFAULT NULL COMMENT '使用日期',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `bus_id` (`bus_id`),
  KEY `machine_id` (`machine_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='车辆配件出库记录表';

-- ----------------------------
-- Records of tp_bus_machine_out
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_order
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_order`;
CREATE TABLE `tp_bus_order` (
  `id` bigint(20) NOT NULL COMMENT 'ID',
  `customer_id` int(11) DEFAULT '0' COMMENT '客户id',
  `start_date` date DEFAULT NULL COMMENT '预约开始日期',
  `end_date` date NOT NULL COMMENT '预约结束日期',
  `type` int(11) DEFAULT '1' COMMENT '类型：1全包现收 2全包预收 3全包记账 4净价现收 5 净价预收 6净价记账',
  `order_type` int(11) DEFAULT '1' COMMENT '订单类型：1普通单次 2常规班次',
  `start_address` varchar(100) DEFAULT NULL COMMENT '开始地点',
  `end_address` varchar(100) NOT NULL COMMENT '结束地点',
  `num` int(11) NOT NULL DEFAULT '1' COMMENT '人数',
  `status` int(11) DEFAULT '0' COMMENT '订单状态：0待派单 1已派单 2交易成功 3取消',
  `is_bathroom` int(11) DEFAULT '0' COMMENT '是否有卫生间',
  `is_tv` int(11) DEFAULT '1' COMMENT '是否有电视',
  `is_air` int(11) DEFAULT '1' COMMENT '是否有空调',
  `is_microphone` int(11) DEFAULT '0' COMMENT '是否有麦克风',
  `return_money` int(11) DEFAULT '0' COMMENT '返利金额',
  `true_money` int(11) DEFAULT '0' COMMENT '实际支付部分',
  `total_money` int(11) DEFAULT '0' COMMENT '订单总额',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单预约表';

-- ----------------------------
-- Records of tp_bus_order
-- ----------------------------
INSERT INTO `tp_bus_order` VALUES ('201712243613104', '6', '2017-12-03', '2017-12-06', '2', '1', '安徽合肥', '江苏苏州', '50', '1', '0', '1', '1', '0', '0', '100', '1000', '2017-12-24 12:14:04', '1', null);
INSERT INTO `tp_bus_order` VALUES ('201801073430315', '9', '2018-01-09', '2018-01-10', '2', '1', '合肥', '六安', '25', '2', '0', '1', '1', '1', '80', '0', '1000', '2018-01-07 23:09:40', '1', '就这个订单');
INSERT INTO `tp_bus_order` VALUES ('201801083542857', '9', '2018-01-09', '2018-01-18', '2', '1', '1', '1', '20', '0', '0', '1', '1', '0', '0', '2', '1', '2018-01-08 11:14:04', '1', '2');
INSERT INTO `tp_bus_order` VALUES ('201801084574131', '9', '2018-01-08', '2018-01-09', '2', '1', '123', '12321', '12', '0', '0', '1', '1', '0', '0', '0', '1221', '2018-01-08 11:14:32', '1', '');
INSERT INTO `tp_bus_order` VALUES ('201801082691683', '9', '2018-01-02', '2018-01-10', '2', '1', '12', '1221', '24', '0', '0', '0', '0', '0', '0', '0', '212', '2018-01-08 11:43:14', '1', '');

-- ----------------------------
-- Table structure for tp_bus_order_follow
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_order_follow`;
CREATE TABLE `tp_bus_order_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '备注ID',
  `order_id` bigint(20) NOT NULL COMMENT '订单ID',
  `admin_id` int(11) NOT NULL COMMENT '备注者ID',
  `remarks` text NOT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '备注时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='跟单备注表';

-- ----------------------------
-- Records of tp_bus_order_follow
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_protect
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_protect`;
CREATE TABLE `tp_bus_protect` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bus_id` int(11) DEFAULT '0' COMMENT '车辆id',
  `protect_date` date DEFAULT NULL COMMENT '保养日期',
  `fee` int(11) DEFAULT '0' COMMENT '费用',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `contact_id` int(11) DEFAULT '0' COMMENT '4S、维修店（往来单位）id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `bus_id` (`bus_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='车辆保养记录表';

-- ----------------------------
-- Records of tp_bus_protect
-- ----------------------------

-- ----------------------------
-- Table structure for tp_bus_record
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_record`;
CREATE TABLE `tp_bus_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` bigint(20) DEFAULT '0' COMMENT '预约订单id',
  `bus_id` int(11) DEFAULT '0' COMMENT '车辆id',
  `fir_user_id` int(11) DEFAULT '0' COMMENT '主驾驶员id',
  `sec_user_id` int(11) DEFAULT '0' COMMENT '副驾驶员id',
  `start_date` date DEFAULT NULL COMMENT '触发日期',
  `end_date` date DEFAULT NULL COMMENT '结束日期',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 0:待接单； 1:接单出发（途中） 2:已回车  3:取消',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fir_user_id` (`fir_user_id`),
  KEY `sec_user_id` (`sec_user_id`),
  KEY `bus_id` (`bus_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='车辆调度记录表';

-- ----------------------------
-- Records of tp_bus_record
-- ----------------------------
INSERT INTO `tp_bus_record` VALUES ('3', '201712243613104', '4', '7', '0', null, null, '0', '2017-12-24 21:21:58', '2017-12-25 15:40:10', '1');
INSERT INTO `tp_bus_record` VALUES ('4', '201801073430315', '8', '7', '28', '2018-01-08', null, '2', '2018-01-08 01:47:29', '2018-01-08 01:53:43', '1');
INSERT INTO `tp_bus_record` VALUES ('5', '201801073430315', '7', '7', '0', '2018-01-08', null, '2', '2018-01-08 01:47:29', '2018-01-08 01:58:42', '1');

-- ----------------------------
-- Table structure for tp_bus_record_follow
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_record_follow`;
CREATE TABLE `tp_bus_record_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '备注ID',
  `record_id` int(11) NOT NULL COMMENT '派单ID',
  `admin_id` int(11) NOT NULL COMMENT '备注者ID',
  `remarks` text NOT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '备注时间',
  PRIMARY KEY (`id`),
  KEY `record_id` (`record_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='调度备注表';

-- ----------------------------
-- Records of tp_bus_record_follow
-- ----------------------------
INSERT INTO `tp_bus_record_follow` VALUES ('1', '0', '4', '是的', '2018-01-08 00:13:53');

-- ----------------------------
-- Table structure for tp_bus_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_bus_user`;
CREATE TABLE `tp_bus_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `bus_id` varchar(10) DEFAULT NULL COMMENT '车牌号',
  `user_id` varchar(50) DEFAULT NULL COMMENT '用户id',
  `rate` varchar(20) DEFAULT NULL COMMENT '股份比例',
  `status` int(11) DEFAULT '1' COMMENT '状态：1有效 2无效',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bus_id` (`bus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='车辆合伙人表';

-- ----------------------------
-- Records of tp_bus_user
-- ----------------------------
INSERT INTO `tp_bus_user` VALUES ('5', '4', '7', null, '1', '1');
INSERT INTO `tp_bus_user` VALUES ('7', '5', '28', '1/3', '1', '1');

-- ----------------------------
-- Table structure for tp_fi_customer
-- ----------------------------
DROP TABLE IF EXISTS `tp_fi_customer`;
CREATE TABLE `tp_fi_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `customer_id` int(11) DEFAULT '0' COMMENT '客户id',
  `order_id` int(11) DEFAULT '0' COMMENT '预约订单id',
  `type` int(11) DEFAULT '1' COMMENT '类型：1欠 2还',
  `money` int(11) DEFAULT '0' COMMENT '入账金额',
  `add_date` date NOT NULL COMMENT '入账时间',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='客户财务账单表';

-- ----------------------------
-- Records of tp_fi_customer
-- ----------------------------
INSERT INTO `tp_fi_customer` VALUES ('5', '9', '2147483647', '1', '1000', '2018-01-09', '2018-01-08 01:58:42', '1');

-- ----------------------------
-- Table structure for tp_fi_oil
-- ----------------------------
DROP TABLE IF EXISTS `tp_fi_oil`;
CREATE TABLE `tp_fi_oil` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(100) DEFAULT NULL COMMENT '油卡描述',
  `buy_date` date DEFAULT NULL COMMENT '购买日期',
  `money` int(11) DEFAULT '0' COMMENT '面值',
  `true_money` int(11) DEFAULT NULL COMMENT '购买金额',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='油卡购买费用记录';

-- ----------------------------
-- Records of tp_fi_oil
-- ----------------------------

-- ----------------------------
-- Table structure for tp_fi_oil_in
-- ----------------------------
DROP TABLE IF EXISTS `tp_fi_oil_in`;
CREATE TABLE `tp_fi_oil_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `oil_id` int(11) DEFAULT '0' COMMENT '油卡id',
  `in_date` date DEFAULT NULL COMMENT '充值日期',
  `money` int(11) DEFAULT '0' COMMENT '面值金额',
  `true_money` int(11) DEFAULT '0' COMMENT '实际充值',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `oil_id` (`oil_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='油卡充值记录表';

-- ----------------------------
-- Records of tp_fi_oil_in
-- ----------------------------

-- ----------------------------
-- Table structure for tp_fi_oil_out
-- ----------------------------
DROP TABLE IF EXISTS `tp_fi_oil_out`;
CREATE TABLE `tp_fi_oil_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bus_id` int(11) DEFAULT '0' COMMENT '车辆id',
  `oil_id` int(11) DEFAULT '0' COMMENT '油卡id',
  `out_date` date DEFAULT NULL COMMENT '加油日期',
  `fee` int(11) DEFAULT '0' COMMENT '费用',
  `contact_id` int(11) DEFAULT '0' COMMENT '加油站（往来单位）id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `bus_id` (`bus_id`),
  KEY `contact_id` (`contact_id`),
  KEY `oil_id` (`oil_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='车辆加油记录表';

-- ----------------------------
-- Records of tp_fi_oil_out
-- ----------------------------

-- ----------------------------
-- Table structure for tp_fi_reimburse
-- ----------------------------
DROP TABLE IF EXISTS `tp_fi_reimburse`;
CREATE TABLE `tp_fi_reimburse` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(100) DEFAULT NULL COMMENT '报销描述',
  `department_id` int(11) NOT NULL COMMENT '报销部门id',
  `user_id` int(11) NOT NULL COMMENT '报销员工id',
  `fee` int(11) DEFAULT NULL COMMENT '报销金额',
  `reimburse_date` date DEFAULT NULL COMMENT '报销日期',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='财务报销记录';

-- ----------------------------
-- Records of tp_fi_reimburse
-- ----------------------------

-- ----------------------------
-- Table structure for tp_fi_share
-- ----------------------------
DROP TABLE IF EXISTS `tp_fi_share`;
CREATE TABLE `tp_fi_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT '员工id',
  `bus_id` int(11) DEFAULT NULL COMMENT '车辆id',
  `fenhong` int(11) DEFAULT NULL COMMENT '分红',
  `gongzi_bu` int(11) DEFAULT NULL COMMENT '工资补贴',
  `baoxiao_bu` int(11) NOT NULL COMMENT '报销补贴',
  `daishou_kou` int(11) NOT NULL COMMENT '代收扣除',
  `total_money` int(11) DEFAULT NULL COMMENT '合计金额',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bus_id` (`bus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='车辆合伙人分红表';

-- ----------------------------
-- Records of tp_fi_share
-- ----------------------------

-- ----------------------------
-- Table structure for tp_fi_wages
-- ----------------------------
DROP TABLE IF EXISTS `tp_fi_wages`;
CREATE TABLE `tp_fi_wages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT '员工id',
  `base_wages` int(11) DEFAULT NULL COMMENT '基本工资',
  `jintie` int(11) DEFAULT NULL COMMENT '津贴',
  `shebaobutie` int(11) NOT NULL COMMENT '社保补贴',
  `manqin` int(11) NOT NULL COMMENT '满勤',
  `gongling` int(11) DEFAULT NULL COMMENT '工龄',
  `jiaban` int(11) DEFAULT NULL COMMENT '加班',
  `youxiu` int(11) DEFAULT NULL COMMENT '优秀员工奖',
  `tuifuzhuang` int(11) DEFAULT NULL COMMENT '退服装',
  `qitafa` int(11) NOT NULL COMMENT '其他补发',
  `yingfa` int(11) DEFAULT NULL COMMENT '应发工资',
  `queqin` int(11) NOT NULL COMMENT '缺勤',
  `qingjia` int(11) NOT NULL COMMENT '请假',
  `kuanggong` int(11) DEFAULT NULL COMMENT '旷工',
  `chidao` int(11) DEFAULT NULL COMMENT '迟到',
  `shebao` int(11) DEFAULT NULL COMMENT '社保',
  `suodeshui` int(11) NOT NULL COMMENT '所得税',
  `yajin` int(11) NOT NULL COMMENT '服装押金',
  `guoshi` int(11) DEFAULT NULL COMMENT '过失',
  `canju` int(11) DEFAULT NULL COMMENT '餐具',
  `jiekuan` int(11) DEFAULT NULL COMMENT '借款金额',
  `qitakou` int(11) DEFAULT NULL COMMENT '其他扣',
  `shifa` int(11) NOT NULL COMMENT '实际工资',
  `wages_date` date DEFAULT NULL COMMENT '月份',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='员工工资表';

-- ----------------------------
-- Records of tp_fi_wages
-- ----------------------------
INSERT INTO `tp_fi_wages` VALUES ('2', '28', '4000', null, '0', '0', null, null, null, null, '200', '4200', '0', '0', null, null, null, '0', '0', null, null, null, null, '4200', '2017-12-01', '2017-12-25 14:20:34', '2017-12-25 15:38:41', '1');

-- ----------------------------
-- Table structure for tp_hr_department
-- ----------------------------
DROP TABLE IF EXISTS `tp_hr_department`;
CREATE TABLE `tp_hr_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `is_bus` tinyint(1) DEFAULT '0' COMMENT '是否和车辆有关 1是 0否',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='公司内部部门表';

-- ----------------------------
-- Records of tp_hr_department
-- ----------------------------
INSERT INTO `tp_hr_department` VALUES ('5', '汽车1部', '1', '1', '1');
INSERT INTO `tp_hr_department` VALUES ('6', '财务部', '0', '20', '1');

-- ----------------------------
-- Table structure for tp_hr_holiday
-- ----------------------------
DROP TABLE IF EXISTS `tp_hr_holiday`;
CREATE TABLE `tp_hr_holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) DEFAULT NULL COMMENT '员工id',
  `start_date` date DEFAULT NULL COMMENT '开始日期',
  `end_date` date DEFAULT NULL COMMENT '结束日期',
  `days` varchar(5) DEFAULT NULL COMMENT '请假天数',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型 1:事假 2:病假 3:其他 ',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='员工请假记录表';

-- ----------------------------
-- Records of tp_hr_holiday
-- ----------------------------

-- ----------------------------
-- Table structure for tp_hr_level
-- ----------------------------
DROP TABLE IF EXISTS `tp_hr_level`;
CREATE TABLE `tp_hr_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公司内部级别表';

-- ----------------------------
-- Records of tp_hr_level
-- ----------------------------

-- ----------------------------
-- Table structure for tp_hr_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_hr_user`;
CREATE TABLE `tp_hr_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `head_img` varchar(255) DEFAULT NULL COMMENT '驾驶员照片',
  `num` varchar(10) DEFAULT NULL COMMENT '员工编号',
  `name` varchar(20) DEFAULT NULL COMMENT '员工姓名',
  `phone` varchar(11) DEFAULT NULL COMMENT '联系电话',
  `code` varchar(20) DEFAULT NULL COMMENT '身份证号码',
  `code_zheng_img` varchar(255) DEFAULT NULL COMMENT '身份证正面照片',
  `code_fan_img` varchar(255) DEFAULT NULL COMMENT '身份证反面照片',
  `sex` tinyint(2) DEFAULT '1' COMMENT '性别 1：男； 2：女 ',
  `join_date` date DEFAULT NULL COMMENT '入职日期',
  `out_date` date DEFAULT NULL COMMENT '离职日期',
  `is_partner` tinyint(1) DEFAULT '0' COMMENT '购车的合作伙伴：0：否 1：是',
  `is_driver` tinyint(1) DEFAULT '1' COMMENT '是否是驾驶员 1是 0否',
  `drive_img` varchar(255) DEFAULT NULL COMMENT '驾照照片',
  `department_id` int(11) DEFAULT '0' COMMENT '所属公司内部部门id',
  `level_id` int(11) DEFAULT '0' COMMENT '所属公司内部级别id',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态 1：在职； 2：离职 ; 3：纯临时司机',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `system_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `level_id` (`level_id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='员工信息表';

-- ----------------------------
-- Records of tp_hr_user
-- ----------------------------
INSERT INTO `tp_hr_user` VALUES ('28', null, '000019', '张三', '18888888888', null, null, null, '1', '2017-12-12', null, '1', '1', null, '6', '0', '1', '2017-12-24 23:19:20', '2017-12-25 15:38:58', '1');
INSERT INTO `tp_hr_user` VALUES ('7', null, '000009', '李林', '13585788049', '', '', '', '1', '0000-00-00', '0000-00-00', '1', '1', '', '0', '0', '1', '2017-12-24 12:54:18', '2017-12-25 15:38:59', '1');

-- ----------------------------
-- Table structure for tp_system
-- ----------------------------
DROP TABLE IF EXISTS `tp_system`;
CREATE TABLE `tp_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '系统id',
  `name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `code` varchar(20) NOT NULL COMMENT '企业简称',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `status` int(11) DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='系统公司表';

-- ----------------------------
-- Records of tp_system
-- ----------------------------
INSERT INTO `tp_system` VALUES ('1', '昌顺汽车', 'cs', null, '1');
INSERT INTO `tp_system` VALUES ('2', '大恒汽车', 'dh', '', '1');
