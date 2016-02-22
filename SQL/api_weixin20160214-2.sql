/*
Navicat MySQL Data Transfer

Source Server         : vm-ware
Source Server Version : 50624
Source Host           : 192.168.1.160:3306
Source Database       : api_weixin

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2016-02-14 17:46:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `money_record`
-- ----------------------------
DROP TABLE IF EXISTS `money_record`;
CREATE TABLE `money_record` (
  `record_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `money` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '奖励金额',
  `content` text COMMENT '描述',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL COMMENT '0未支付，1已支付',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间，发放时间',
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='奖励明细表';

-- ----------------------------
-- Records of money_record
-- ----------------------------
INSERT INTO `money_record` VALUES ('1', '14', '1.00', '111', '1455369064', '1', '1455381013');
INSERT INTO `money_record` VALUES ('2', '14', '100.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369240', '1', '1455381005');
INSERT INTO `money_record` VALUES ('3', '14', '100.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369263', '1', '0');
INSERT INTO `money_record` VALUES ('4', '14', '1222.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369326', '1', '1455380997');
INSERT INTO `money_record` VALUES ('5', '14', '22222.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369338', '1', '1455380989');
INSERT INTO `money_record` VALUES ('9', '14', '144.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369556', '1', '0');
INSERT INTO `money_record` VALUES ('10', '14', '1555.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369607', '1', '0');
INSERT INTO `money_record` VALUES ('11', '3', '1.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369621', '1', '0');
INSERT INTO `money_record` VALUES ('12', '3', '1.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369713', '1', '0');
INSERT INTO `money_record` VALUES ('13', '4', '1.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369732', '1', '0');
INSERT INTO `money_record` VALUES ('14', '4', '1.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369767', '1', '0');
INSERT INTO `money_record` VALUES ('16', '4', '1.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369873', '1', '0');
INSERT INTO `money_record` VALUES ('17', '14', '1.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455369946', '1', '0');
INSERT INTO `money_record` VALUES ('18', '14', '1111.00', '华为销售大型机器，已经结帐，奖励100w元人民币，祝福，新年快乐。', '1455374155', '1', '0');
INSERT INTO `money_record` VALUES ('19', '10', '100.00', '项目描述', '1455374704', '1', '1455426873');
INSERT INTO `money_record` VALUES ('20', '14', '1.00', '111', '1455379016', '1', '1455381160');
INSERT INTO `money_record` VALUES ('21', '14', '1.00', '1', '1455381437', '1', '1455426893');
INSERT INTO `money_record` VALUES ('22', '11', '1.00', '1', '1455430160', '1', '1455430160');
INSERT INTO `money_record` VALUES ('23', '24', '7.00', '', '1455442569', '0', '1455442569');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `mobile` varchar(15) NOT NULL COMMENT '用户手机号',
  `referer_username` varchar(50) DEFAULT NULL COMMENT '推荐人姓名',
  `referer_mobile` varchar(15) DEFAULT NULL COMMENT '推荐人手机号',
  `award_total_money` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '已发奖金',
  `gender` tinyint(1) DEFAULT NULL COMMENT '性别1男，0女',
  `company` varchar(100) DEFAULT NULL COMMENT '公司',
  `self_description` text COMMENT '个性签名',
  `reg_time` int(11) NOT NULL COMMENT '注册时间',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `openid` char(50) DEFAULT '微信openid',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1禁用0正常',
  `password` char(32) DEFAULT NULL,
  `except_award_money` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '未发奖励',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '1', '2', '4', '5', '0.00', '1', '大金蝶软件有限公司', '7', '1455338870', null, '', '-1', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('2', '1', '2', '4', '5', '0.00', '1', '大金蝶软件有限公司', '7', '1455338889', null, '', '-1', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('3', 'q', 'q', 'q', 'q', '2.00', '1', '大金蝶软件有限公司', 'q', '1455339282', null, '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('4', '1', '1', '1', '1', '3.00', '1', '大金蝶软件有限公司', '1', '1455339320', null, '', '-1', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('5', 'w', 'w', 'ww', '', '0.00', '1', '大金蝶软件有限公司', 'w', '1455339429', null, '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('6', 'w', 'w', 'ww', '', '0.00', '1', '大金蝶软件有限公司', 'w', '1455339454', null, '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('7', '6', '6', '6', '6', '0.00', '1', '大金蝶软件有限公司', '6', '1455339520', null, '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('8', '4', '4', '', '', '0.00', '1', '大金蝶软件有限公司', '', '1455339560', null, '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('9', '4', '4', '', '', '0.00', '1', '大金蝶软件有限公司', '', '1455339777', null, '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('10', '1', '2', '4', '5', '100.00', '1', '大金蝶软件有限公司', '7', '1455339834', '-1', '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('11', '王小名', '132714584551', '小红', '138888888', '1.00', '1', '大金蝶软件有限公司', '没有扫描要说的\r\n第二行', '1455342887', '-1', '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('12', '王小华', '132714584551', '小红', '128899999999', '123456789.00', '1', '大金蝶软件有限公司', '大金蝶软件有限公司', '1455343008', '-1', '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('13', '小明明', '132714584551', '小明哥', '1356666666', '0.00', '1', '大腾讯', '大腾讯', '1455363175', '1455363175', '', '0', 'e10adc3949ba59abbe56e057f20f883e', '0.00');
INSERT INTO `user` VALUES ('14', '王小明', '13714584553', '6', '128899999999', '48682.00', '1', '大腾讯', '大腾讯', '1455363279', '1455363279', '', '-1', 'e10adc3949ba59abbe56e057f20f883e', '45767.00');
INSERT INTO `user` VALUES ('15', '1', '2', '1', '1', '0.00', null, null, null, '1455437562', '1455437562', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('16', '2', '2', '2', '2', '0.00', null, null, null, '1455437580', '1455437580', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('17', '2', '2', '2', '2', '0.00', null, null, null, '1455437593', '1455437593', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('18', '2', '2', '2', '2', '0.00', null, null, null, '1455437626', '1455437626', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('19', '2', '2', '2', '2', '0.00', null, null, null, '1455437638', '1455437638', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('20', '12', '12', '12', '12', '0.00', null, null, null, '1455437648', '1455437648', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('21', '4', '4', '44', '4', '0.00', null, null, null, '1455437666', '1455437666', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('22', '', '', '', '', '0.00', null, null, null, '1455440397', '1455440397', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('23', '&amp;lt;java script&amp;gt;', '13714584553', '1', '1', '0.00', null, null, null, '1455441705', '1455441705', '', '0', null, '0.00');
INSERT INTO `user` VALUES ('24', '王小明', '13714581111', '', '', '0.00', null, null, null, '1455442179', '1455442179', '', '-1', null, '7.00');


alter table `user` add COLUMN `project_description` text COMMENT '项目描述';