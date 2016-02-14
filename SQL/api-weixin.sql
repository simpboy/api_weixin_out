/*
Navicat MySQL Data Transfer

Source Server         : vm-ware
Source Server Version : 50624
Source Host           : 192.168.1.160:3306
Source Database       : api-weixin

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2016-02-03 14:29:26
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
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='挣钱明细表';

-- ----------------------------
-- Records of money_record
-- ----------------------------

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
  `award_total_money` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '奖金',
  `gender` tinyint(1) DEFAULT NULL COMMENT '性别1男，0女',
  `company` varchar(100) DEFAULT NULL COMMENT '公司',
  `self_description` text COMMENT '个性签名',
  `reg_time` int(11) NOT NULL COMMENT '注册时间',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `openid` varchar(30) NOT NULL COMMENT '微信openid',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '-1禁用0正常',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
