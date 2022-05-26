/*
    ecshop 数据库更新文件
*/
alter table ecs_article  add `is_recommend` enum('0','1') default '0' comment '是否为推荐专题文章';
alter table ecs_article add `article_pic` text comment  '文章图片上传';


CREATE TABLE `ecs_vcode` (
  `sms_id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(255) DEFAULT NULL,
  `vcode` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`sms_id`),
  KEY `mobile` (`mobile`),
  KEY `vcode` (`vcode`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `ecs_ad`
  ADD COLUMN is_show tinyint(1) NOT NULL DEFAULT '0' AFTER enabled;

ALTER TABLE `ecs_category`
  ADD COLUMN cate_img varchar(255) NULL AFTER filter_attr,
  ADD COLUMN is_top tinyint(1) NOT NULL DEFAULT '0' COMMENT '首页顶部展示',
  ADD COLUMN is_goods tinyint(1) NOT NULL DEFAULT '0' COMMENT '首页物品展示';

ALTER TABLE `ecs_brand`
  ADD COLUMN is_index tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否首页显示' AFTER is_show

ALTER TABLE `ecs_article`
  ADD COLUMN is_index tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为精选文章' AFTER article_pic

  ALTER TABLE `ecs_user_address`
ADD COLUMN `is_default`  enum('false','true') NULL DEFAULT 'false' AFTER `best_time`;

ALTER TABLE `ecs_comment`
ADD COLUMN `order_id` int(10) NOT NULL DEFAULT 0 AFTER `user_id`,
ADD COLUMN `app_user_id` int(10) NOT NULL DEFAULT 0 AFTER `order_id`;


CREATE TABLE `ecs_app_config`  (
  `k` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `val` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `ecs_app_config` VALUES ('end_time','');
INSERT INTO `ecs_app_config` VALUES ('prompt','');
INSERT INTO `ecs_app_config` VALUES ('yes_no', '1');


INSERT INTO `ecs_app_config` VALUES ('img1','');
INSERT INTO `ecs_app_config` VALUES ('img_url1','');

INSERT INTO `ecs_app_config` VALUES ('img2','');
INSERT INTO `ecs_app_config` VALUES ('img_url2','');

INSERT INTO `ecs_app_config` VALUES ('img3','');
INSERT INTO `ecs_app_config` VALUES ('img_url3','');

INSERT INTO `ecs_app_config` VALUES ('img4','');
INSERT INTO `ecs_app_config` VALUES ('img_url4','');


INSERT INTO `ecs_app_config` VALUES ('url','');
INSERT INTO `ecs_app_config` VALUES ('version','');
INSERT INTO `ecs_app_config` VALUES ('day','');
INSERT INTO `ecs_app_config` VALUES ('tel','');

INSERT INTO `ecs_app_config` VALUES ('external_1','');
INSERT INTO `ecs_app_config` VALUES ('external_2','');
INSERT INTO `ecs_app_config` VALUES ('external_3','');

INSERT INTO `ecs_app_config` VALUES ('prompt_image','');
INSERT INTO `ecs_app_config` VALUES ('prompt_external_image','');
INSERT INTO `ecs_app_config` VALUES ('prompt_image_url','');
INSERT INTO `ecs_app_config` VALUES ('prompt_bonus_id','');
INSERT INTO `ecs_app_config` VALUES ('prompt_image_status','2');
INSERT INTO `ecs_app_config` VALUES ('kefu_tel','');

INSERT INTO `ecs_app_config` VALUES ('appdownload','');
INSERT INTO `ecs_app_config` VALUES ('default_image','');
INSERT INTO `ecs_app_config` VALUES ('app_logo','');

ALTER TABLE `ecs_goods_activity`
ADD COLUMN `package_image` varchar(255) NULL;

CREATE TABLE `ecs_banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_src` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `img_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `app_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mp_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;


CREATE TABLE `ecs_return_goods` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_id` varchar(200) NOT NULL COMMENT '退换单号',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `order_sn` varchar(200) NOT NULL COMMENT '订单编号',
  `user_id` varchar(200) DEFAULT NULL COMMENT '下单会员',
   `goods_id` varchar(200) DEFAULT NULL  COMMENT  '商品id',
  `goods_name` varchar(200) DEFAULT NULL  COMMENT  '商品名字',
  `num` varchar(200) DEFAULT NULL  COMMENT  '退换数量',
  `return_code` varchar(200) DEFAULT NULL  COMMENT  '买家退回运单号',
  `return_text` varchar(255) DEFAULT NULL  COMMENT  '买家退回理由',
  `seller_return_code` varchar(200) DEFAULT NULL  COMMENT  '卖家退回运单号',
  `return_status` ENUM(  'succ',  'error','wait','code' ) NOT NULL DEFAULT 'wait' COMMENT 'succ同意，error 拒绝，code填写运单号,wait 待审核',
  `t_time` int(11) DEFAULT NULL COMMENT '同意，拒绝时间',
  `ctime` int(11) DEFAULT NULL COMMENT '写入时间',
  PRIMARY KEY (`r_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE  `ecs_order_info` ADD  `apply_for_status` ENUM(  'true',  'false' ) NULL DEFAULT  'false' COMMENT '是否申请退换货';


ALTER TABLE `ecs_users` ADD `user_pic` longtext  COMMENT '用户头像';

INSERT INTO `ecs_admin_action`(`action_id`, `parent_id`, `action_code`, `relevance`) VALUES (156, 12, 'keywords', '');

ALTER TABLE `ecs_account_log`
ADD COLUMN `order_sn` varchar(32) NULL AFTER `change_type`;

CREATE TABLE `ykt_pay_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `params` longtext COMMENT '参数',
  `response` longtext COMMENT '返回参数',
  `status` enum('succ','fail') DEFAULT NULL COMMENT '成功失败',
  `created_at` int(11) DEFAULT NULL COMMENT '请求时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


ALTER TABLE `ecs_account_log`
ADD COLUMN `state` enum('true','false') NULL DEFAULT 'false' AFTER `order_sn`;

CREATE TABLE `ecs_index_prompt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `image_prompt` varchar(255) DEFAULT NULL COMMENT '显示文字',
  `sort` int(11) NOT NULL COMMENT '排序',
  `status` enum('true','false') DEFAULT 'true' COMMENT '是否显示',
  `ctime` longtext COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


ALTER TABLE `ecs_users`
MODIFY COLUMN `birthday` date NOT NULL DEFAULT '1970-01-01' AFTER `sex`,
MODIFY COLUMN `last_time` datetime(0) NOT NULL DEFAULT '1970-01-01 00:00:00' AFTER `last_login`,
ADD COLUMN `openid` varchar(32) NULL AFTER `passwd_answer`;

ALTER TABLE `ecs_users`
ADD COLUMN `openid_mp` varchar(32) NULL AFTER `openid`;

CREATE TABLE `ecs_order_delivery_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `o_time` varchar(255) DEFAULT NULL COMMENT '配送时间',
  `quantity_order` int(11) NOT NULL COMMENT '配送单量',
  `ctime` longtext COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


ALTER TABLE  `ecs_goods` ADD  `delivery_status` ENUM(  'true',  'false' ) NULL DEFAULT  'true' COMMENT '是否允许快递配送';

INSERT INTO `ecs_shop_config`(`parent_id`, `code`, `type`, `store_range`, `store_dir`, `value`, `sort_order`) VALUES (0, 'sms_set_update','peizhi', '', '', '', 1);

ALTER TABLE `ecs_cart`
ADD COLUMN `is_checked`  enum('false','true') NULL DEFAULT 'false' AFTER `goods_attr_id`;

ALTER TABLE `ecs_user_address`
ADD COLUMN `mobile_addr_id_list` varchar(255) NULL AFTER `is_default`;

CREATE TABLE `ecs_delivery_method` (
  `delivery_id` int(11) NOT NULL AUTO_INCREMENT  COMMENT'配送id',
  `parent_id` int(11) DEFAULT '0' COMMENT '父级id',
  `delivery_name` varchar(255) DEFAULT NULL COMMENT '配送名称',
  `sort_order` varchar(255) DEFAULT NULL COMMENT '排序',
  `cost` varchar(255) DEFAULT NULL COMMENT '费用',
  `is_show` enum('false','true') DEFAULT 'true' COMMENT '是否显示',
  `k_status` enum('false','true') DEFAULT 'false' COMMENT '是否为凯宇配送',
  `ctime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`delivery_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `ecs_delivery_method`
ADD COLUMN `type` int(2) NOT NULL DEFAULT 0 COMMENT '是否是快递配送' AFTER `ctime`;

ALTER TABLE `ecs_users`
MODIFY COLUMN `birthday` date NOT NULL DEFAULT '1970-01-01' AFTER `sex`,
MODIFY COLUMN `last_time` datetime(0) NOT NULL DEFAULT '1970-01-01 10:20:10' AFTER `last_login`,
ADD COLUMN `platform` varchar(255) NULL AFTER `passwd_answer`;

ALTER TABLE `ecs_order_info`
ADD COLUMN `platform` varchar(255) NULL AFTER `apply_for_status`;

INSERT INTO `ecs_shop_config`(`id`, `parent_id`, `code`, `type`, `store_range`, `store_dir`, `value`, `sort_order`) VALUES (123, 1, 'shop_other', 'file', '', '', '', 1);


ALTER TABLE `ecs_goods`
ADD COLUMN `active` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否开启秒杀，true开启，false关闭' AFTER `delivery_status`;

ALTER TABLE `ecs_goods`
ADD COLUMN `start_time` varchar(255) NULL COMMENT '秒杀开始时间' AFTER `active`,
ADD COLUMN `end_time` varchar(255) NULL COMMENT '秒杀结束时间' AFTER `start_time`;

ALTER TABLE `ecs_goods`
ADD COLUMN `spike_count` int(11) NULL COMMENT '秒杀商品数量' AFTER `end_time`,
ADD COLUMN `spike_sum` varchar(255) NULL COMMENT '秒杀商品金额' AFTER `spike_count`;


ALTER TABLE `ecs_order_info`
ADD COLUMN `order_type` tinyint(1) NOT NULL DEFAULT 0 AFTER `platform`;
ALTER TABLE `ecs_users`
ADD COLUMN  `rank_up` int(10) NOT NULL DEFAULT 0 AFTER `platform`;




ALTER TABLE `ecs_goods`
ADD COLUMN `is_pintuan` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否开启商品拼团' AFTER `delivery_status`,
ADD COLUMN `pt_price` decimal(10, 0) NOT NULL DEFAULT 0.00 COMMENT '拼团金额' AFTER `is_pintuan`;


ALTER TABLE `ecs_order_info`
ADD COLUMN `order_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单类型：0普通订单，1拼团订单，2秒杀订单。默认普通订单' AFTER `platform`;

ALTER TABLE `ecs_order_info`
ADD COLUMN `pt_id` int(11) NOT NULL DEFAULT 0 COMMENT '相互拼团的订单ID' AFTER `order_type`;


ALTER TABLE `ecs_order_goods`
ADD COLUMN `act_id` int(11) NOT NULL DEFAULT 0 COMMENT '超值礼包的ID' AFTER `goods_id`;

ALTER TABLE `ecs_order_info`
ADD COLUMN `tax_num` varchar(128) NULL COMMENT '纳税人识别号' AFTER `tax`;


CREATE TABLE `ecs_user_visit_log` (
  `visit_id` int(11) NOT NULL AUTO_INCREMENT  COMMENT'用户浏览id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  `goods_id` int(5) DEFAULT NULL COMMENT '商品id',
  `hitCounts` int(5) DEFAULT NULL COMMENT '点击次数',
  `addTime` datetime(0) NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '添加时间',
	`platform` varchar(255) DEFAULT NULL  COMMENT '来源',
  PRIMARY KEY (`visit_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ecs_user_recommend` (
  `recommend_id` int(11) NOT NULL AUTO_INCREMENT  COMMENT'推荐id',
  `user_id` int(11) DEFAULT '0' COMMENT '新注册用户id',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `parent_id` int(11) DEFAULT NULL COMMENT '推荐人id',
  `recommend` varchar(255) DEFAULT NULL COMMENT '推荐人名',
  PRIMARY KEY (`recommend_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `ecs_app_config`(`k`, `val`) VALUES ('default_image', 'https://imgt1.oss-cn-shanghai.aliyuncs.com/tools/default_category.png');

ALTER TABLE `ecs_goods`
ADD COLUMN `sales_volume_count` varchar(255) NULL DEFAULT 0 COMMENT '订单销量' AFTER `pt_price`;

ALTER TABLE `ecs_users`
ADD COLUMN `openid_h5` varchar(32) NULL  COMMENT 'H5的openid' AFTER `openid`;


CREATE TABLE `ecs_app_update`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(255) NULL COMMENT 'app名称',
  `nowId` varchar(255) NULL COMMENT 'app当前版本',
  `updateId` varchar(255) NULL COMMENT 'app更新版本',
  `iosLink` varchar(255) NULL COMMENT 'iosapp更新地址',
  `androidLink` varchar(255) NULL COMMENT '安卓app更新地址',
  PRIMARY KEY (`id`)
);
CREATE TABLE `ecs_copyright_modify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `copyright_one` varchar(255) DEFAULT NULL COMMENT '第一句',
  `copyright_two` varchar(255) DEFAULT NULL COMMENT '第二句',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

ALTER TABLE `ecs_users`
ADD COLUMN  `recode` varchar (255)  NULL  COMMENT '会员邀请码' AFTER `platform`;

ALTER TABLE `ecs_user_account`
ADD COLUMN  `bank_addr` varchar (255)  NULL  COMMENT '开户行地址';

ALTER TABLE `ecs_user_account`
ADD COLUMN  `bank_account` varchar (255)  NULL  COMMENT '开户行';

ALTER TABLE `ecs_users`
MODIFY COLUMN `mobile_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `home_phone`;

ALTER TABLE `ecs_users`
MODIFY COLUMN `mobile_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `home_phone`;

ALTER TABLE `ecs_users`
ADD COLUMN `recode` varchar(255) NULL DEFAULT NULL COMMENT '会员邀请码' AFTER `user_pic`;

ALTER TABLE `ecs_users`
ADD COLUMN `unionid` varchar(255) NULL COMMENT '不同平台的下微信登录标式' AFTER `recode`;


ALTER TABLE `ecs_users`
ADD COLUMN `apple_openid` varbinary(255) NULL COMMENT '苹果账号登录' AFTER `user_pic`;

ALTER TABLE `ecs_nav`
ADD COLUMN `show_in_nav_pc` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'pc分类显示' AFTER `type`;


------ 2020年10月10日10:03:31 商品附件上传表
CREATE TABLE `ecs_goods_upload`  (
  `file_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) NOT NULL COMMENT '商品id',
  `file_url` varchar(255) NOT NULL COMMENT '文件链接地址',
  `file_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '文件描述',
  `sort_order` int(255) NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`file_id`)
);

ALTER TABLE `ecs_goods_upload`
ADD COLUMN `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '附件名字' AFTER `sort_order`;


ALTER TABLE `ecs_users`
ADD COLUMN `chartcode` varchar(255) NULL COMMENT '图形验证码';