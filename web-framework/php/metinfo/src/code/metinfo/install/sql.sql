DROP TABLE IF EXISTS `met_admin_array`;
CREATE TABLE `met_admin_array` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `array_name` varchar(255) NOT NULL DEFAULT '',
  `admin_type` text,
  `admin_ok` int(11) NOT NULL DEFAULT '0',
  `admin_op` varchar(30) DEFAULT 'metinfo',
  `admin_issueok` int(11) DEFAULT '0',
  `admin_group` int(11) DEFAULT '0',
  `user_webpower` int(11) DEFAULT '0',
  `array_type` int(11) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  `langok` varchar(255) DEFAULT 'metinfo',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_admin_column`;
CREATE TABLE `met_admin_column` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `bigclass` int(11) DEFAULT '0',
  `field` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `list_order` int(11) DEFAULT '0',
  `icon` varchar(255) DEFAULT '',
  `info` text,
  `display` int(11) DEFAULT '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_admin_logs`;
CREATE TABLE `met_admin_logs` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) DEFAULT '',
  `name` varchar(255) DEFAULT '',
  `module` varchar(255) DEFAULT '',
  `current_url` varchar(255) DEFAULT '',
  `brower` varchar(255) DEFAULT '',
  `result` varchar(255) DEFAULT '',
  `ip` varchar(50) DEFAULT '',
  `client` varchar(50) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `user_agent` varchar(255) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_admin_table`;
CREATE TABLE `met_admin_table` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `admin_type` text,
  `admin_id` char(20) NOT NULL DEFAULT '',
  `admin_pass` char(64) NOT NULL DEFAULT '',
  `admin_name` varchar(30) NOT NULL DEFAULT '',
  `admin_sex` tinyint(1) DEFAULT '1',
  `admin_tel` varchar(20) DEFAULT '',
  `admin_mobile` varchar(20) DEFAULT '',
  `admin_email` varchar(150) DEFAULT '',
  `admin_qq` varchar(12) DEFAULT '',
  `admin_msn` varchar(40) DEFAULT '',
  `admin_taobao` varchar(40) DEFAULT '',
  `admin_introduction` text,
  `admin_login` int(11) DEFAULT '0',
  `admin_modify_ip` varchar(20) DEFAULT '',
  `admin_modify_date` datetime,
  `admin_register_date` datetime,
  `admin_approval_date` datetime,
  `admin_ok` int(11) DEFAULT '0',
  `admin_op` varchar(30) DEFAULT 'metinfo',
  `admin_issueok` int(11) DEFAULT '0',
  `admin_group` int(11) DEFAULT '0',
  `companyname` varchar(255) DEFAULT '',
  `companyaddress` varchar(255) DEFAULT '',
  `companyfax` varchar(255) DEFAULT '',
  `usertype` int(11) DEFAULT '0',
  `checkid` int(1) DEFAULT '0',
  `companycode` varchar(50) DEFAULT '',
  `companywebsite` varchar(50) DEFAULT '',
  `cookie` text,
  `admin_shortcut` text,
  `lang` varchar(50) DEFAULT '',
  `content_type` INT(11) DEFAULT '0',
  `langok` varchar(255) DEFAULT 'metinfo',
  `admin_login_lang` varchar(50) DEFAULT '' COMMENT '登录默认语言',
  `admin_check` int(11) DEFAULT '0' COMMENT '发布信息需要审核才能正常显示',
  PRIMARY KEY  (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_app_config`;
CREATE TABLE `met_app_config` (
  `id` int(11) NOT NULL auto_increment,
  `appno` int(20) DEFAULT '0',
  `name` varchar(255) DEFAULT '',
  `value` text,
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_applist`;
CREATE TABLE IF NOT EXISTS `met_applist` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) DEFAULT '0',
  `ver` varchar(50) DEFAULT '',
  `m_name` varchar(50) DEFAULT '',
  `m_class` varchar(50) DEFAULT '',
  `m_action` varchar(50) DEFAULT '',
  `appname` varchar(50) DEFAULT '',
  `info` text,
  `addtime` int(11) DEFAULT '0',
  `updatetime` int(11) DEFAULT '0',
  `target` int(11) DEFAULT '0',
  `display` int(11) DEFAULT '1',
  `depend`  varchar(100) NULL,
  `mlangok`  int(1) NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_app_plugin`;
CREATE TABLE IF NOT EXISTS `met_app_plugin` (
  `id` int(11) NOT NULL auto_increment,
  `no_order` int(11) DEFAULT '0',
  `no` int(11) DEFAULT '0',
  `m_name` varchar(255) DEFAULT '',
  `m_action` varchar(255) DEFAULT '',
  `effect` tinyint(1) DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_column`;
CREATE TABLE `met_column` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) DEFAULT '',
  `foldername` varchar(50) DEFAULT '',
  `filename` varchar(50) DEFAULT '',
  `bigclass` int(11) DEFAULT '0',
  `samefile` int(11) DEFAULT '0',
  `module` int(11) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `wap_ok` int(1) DEFAULT '0',
  `wap_nav_ok` int( 11 ) DEFAULT '0',
  `if_in` int(1) DEFAULT '0',
  `nav` int(1) DEFAULT '0',
  `ctitle` varchar(200) DEFAULT '',
  `keywords` varchar(200) DEFAULT '',
  `content` longtext,
  `description` text,
  `other_info` text,
  `custom_info` text,
  `list_order` int(11) DEFAULT '0',
  `new_windows` varchar(50) DEFAULT '',
  `classtype` int(11) DEFAULT '1',
  `out_url` varchar(200) DEFAULT '',
  `index_num` int(11) DEFAULT '0',
  `access` text,
  `indeximg` varchar(255) DEFAULT '',
  `columnimg` varchar(255) DEFAULT '',
  `isshow` int(11) DEFAULT '1',
  `lang` varchar(50) DEFAULT '',
  `namemark` varchar(255) DEFAULT '',
  `releclass` int(11) DEFAULT '0',
  `display` int(11) DEFAULT '0',
  `icon` varchar(100) DEFAULT '',
  `nofollow` int(1) DEFAULT '0',
  `text_size` int(11) DEFAULT '0',
  `text_color` varchar(100) DEFAULT '',
  `thumb_list` varchar (50) DEFAULT '',
  `thumb_detail` varchar(50) DEFAULT '',
  `list_length` int(11) DEFAULT '0',
  `tab_num` int(11) DEFAULT '0',
  `tab_name` varchar(255) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_config`;
CREATE TABLE `met_config` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) DEFAULT '',
  `value` text ,
  `mobile_value` text,
  `columnid` int(11) DEFAULT '0',
  `flashid` int(11) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_cv`;
CREATE TABLE `met_cv` (
  `id` int(11) NOT NULL auto_increment,
  `addtime` datetime,
  `readok` int(11) DEFAULT '0',
  `customerid` varchar(50) DEFAULT '0',
  `jobid` int(11) NOT NULL DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  `ip` varchar(255) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_download`;
CREATE TABLE `met_download` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) DEFAULT '',
  `ctitle` varchar(200) DEFAULT '',
  `keywords` varchar(200) DEFAULT '',
  `description` text,
  `content` longtext,
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `new_ok` int(1) DEFAULT '0',
  `wap_ok` int(1) DEFAULT '0',
  `downloadurl` varchar(255) DEFAULT '',
  `filesize` varchar(100) DEFAULT '',
  `com_ok` int(1) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  `updatetime` datetime,
  `addtime` datetime,
  `issue` varchar(100) DEFAULT '',
  `access` text,
  `top_ok` int(1) DEFAULT '0',
  `downloadaccess` text,
  `filename` varchar(255) DEFAULT '',
  `lang` varchar(50) DEFAULT '',
  `recycle` int(11) NOT NULL DEFAULT '0',
  `displaytype` int(11) NOT NULL DEFAULT '1',
  `tag` text,
  `links` varchar(200) DEFAULT '',
  `text_size` int(11)  DEFAULT '0',
  `text_color` varchar(100) DEFAULT '',
  `other_info` text,
  `custom_info` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_feedback`;
CREATE TABLE `met_feedback` (
  `id` int(11) NOT NULL auto_increment,
  `class1` int(11) DEFAULT '0',
  `fdtitle` varchar(255) DEFAULT '',
  `fromurl` varchar(255) DEFAULT '',
  `ip` varchar(255) DEFAULT '',
  `addtime` datetime,
  `readok` int(11) DEFAULT '0',
  `useinfo` text,
  `customerid` varchar(30) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_flash`;
CREATE TABLE `met_flash` (
  `id` int(11) NOT NULL auto_increment,
  `module` text,
  `img_title` varchar(255) DEFAULT '',
  `img_path` varchar(255) DEFAULT '',
  `img_link` varchar(255) DEFAULT '',
  `flash_path` varchar(255) DEFAULT '',
  `flash_back` varchar(255) DEFAULT '',
  `no_order` int(11) DEFAULT '0',
  `width` int(11) DEFAULT '0',
  `height` int(11) DEFAULT '0',
  `wap_ok` int(11) DEFAULT '0',
  `img_title_color` varchar(100) DEFAULT '',
  `img_des` varchar(255) DEFAULT '',
  `img_des_color` varchar(100) DEFAULT '',
  `img_text_position` varchar(100) DEFAULT '4',
  `img_title_fontsize` int(11) DEFAULT '0',
  `img_des_fontsize` int(11) DEFAULT '0',
  `height_m` int(11) DEFAULT '0',
  `height_t` int(11) DEFAULT '0',
  `mobile_img_path` varchar(255) DEFAULT '',
  `img_title_mobile` varchar(255) DEFAULT '',
  `img_title_color_mobile` varchar(100) DEFAULT '',
  `img_text_position_mobile` varchar(100) DEFAULT '4',
  `img_title_fontsize_mobile` int(11) DEFAULT '0',
  `img_des_mobile` varchar(255) DEFAULT '',
  `img_des_color_mobile` varchar(100) DEFAULT '',
  `img_des_fontsize_mobile` int(11) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  `target` int(11) DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_flash_button`;
CREATE TABLE `met_flash_button` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flash_id` int(11) NOT NULL DEFAULT '0',
  `but_text` varchar(255) DEFAULT '',
  `but_url` varchar(255) DEFAULT '',
  `but_text_size` int(11) DEFAULT '0',
  `but_text_color` varchar(100) DEFAULT '',
  `but_text_hover_color` varchar(100) DEFAULT '',
  `but_color` varchar(100) DEFAULT '',
  `but_hover_color` varchar(100) DEFAULT '',
  `but_size` varchar(100) DEFAULT '',
  `is_mobile` int(11) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `target` int(11) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_flist`;
CREATE TABLE `met_flist` (
  `id` int(11) NOT NULL auto_increment,
  `listid` int(11) DEFAULT '0',
  `paraid` int(11) DEFAULT '0',
  `info` text,
  `lang` varchar(50) DEFAULT '',
  `imgname` varchar(255) DEFAULT '',
  `module` int(11) DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_ifcolumn`;
CREATE TABLE IF NOT EXISTS `met_ifcolumn` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) DEFAULT '0',
  `name` varchar(50) DEFAULT '',
  `appname` varchar(50) DEFAULT '' COMMENT '应用名称',
  `addfile` tinyint(1) DEFAULT '1',
  `memberleft` tinyint(1) DEFAULT '0',
  `uniqueness` tinyint(1) DEFAULT '0',
  `fixed_name` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_ifcolumn_addfile`;
CREATE TABLE IF NOT EXISTS `met_ifcolumn_addfile` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `no` int(11) DEFAULT '0',
  `filename` varchar(255) DEFAULT '',
  `m_name` varchar(255) DEFAULT '',
  `m_module` varchar(255) DEFAULT '',
  `m_class` varchar(255) DEFAULT '',
  `m_action` varchar(255) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_ifmember_left`;
CREATE TABLE IF NOT EXISTS `met_ifmember_left` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `no` int(11) DEFAULT '0',
  `columnid` int(11) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `foldername` varchar(255) DEFAULT '',
  `filename` varchar(255) DEFAULT '',
  `target` int(11) DEFAULT '0',
  `own_order` varchar(11) DEFAULT '',
  `effect` int(1) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_img`;
CREATE TABLE `met_img` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) DEFAULT '',
  `ctitle` varchar(200) DEFAULT '',
  `keywords` varchar(200) DEFAULT '',
  `description` text,
  `content` longtext,
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `wap_ok` int(1) DEFAULT '0',
  `new_ok` int(1) DEFAULT '0',
  `imgurl` varchar(255) DEFAULT '',
  `imgurls` varchar(255) DEFAULT '',
  `displayimg` text,
  `com_ok` int(1) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  `updatetime` datetime,
  `addtime` datetime,
  `issue` varchar(100) DEFAULT '',
  `access` text,
  `top_ok` int(1) DEFAULT '0',
  `filename` varchar(255) DEFAULT '',
  `lang` varchar(50) DEFAULT '',
  `content1` text,
  `content2` text,
  `content3` text,
  `content4` text,
  `contentinfo` varchar(255) DEFAULT '',
  `contentinfo1` varchar(255) DEFAULT '',
  `contentinfo2` varchar(255) DEFAULT '',
  `contentinfo3` varchar(255) DEFAULT '',
  `contentinfo4` varchar(255) DEFAULT '',
  `recycle` int(11) DEFAULT '0',
  `displaytype` int(11) DEFAULT '1',
  `tag` text,
  `links` varchar(200) DEFAULT '',
  `imgsize` varchar(200) DEFAULT '',
  `text_size` int(11)  DEFAULT '0',
  `text_color` varchar(100) DEFAULT '',
  `other_info` text,
  `custom_info` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_infoprompt`;
CREATE TABLE IF NOT EXISTS `met_infoprompt` (
  `id` int(11) NOT NULL auto_increment,
  `news_id` int(11) DEFAULT '0',
  `newstitle` varchar(120) DEFAULT '',
  `content` text,
  `url` varchar(200) DEFAULT '',
  `member` varchar(50) DEFAULT '',
  `type` varchar(35) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `see_ok` int(11) DEFAULT '0',
  `lang` varchar(10) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_job`;
CREATE TABLE `met_job` (
  `id` int(11) NOT NULL auto_increment,
  `position` varchar(200) DEFAULT '',
  `count` int(11) DEFAULT '0',
  `place` varchar(200) DEFAULT '',
  `deal` varchar(200) DEFAULT '',
  `addtime` date,
  `updatetime` date,
  `useful_life` int(11) DEFAULT '0',
  `content` longtext,
  `access` text,
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `wap_ok` int(1) DEFAULT '0',
  `top_ok` int(1) DEFAULT '0',
  `email` varchar(255) DEFAULT '',
  `filename` varchar(255) DEFAULT '',
  `lang` varchar(50) DEFAULT '',
  `displaytype` int(11) DEFAULT '1',
  `text_size` int(11)  DEFAULT '0',
  `text_color` varchar(100) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_label`;
CREATE TABLE `met_label` (
  `id` int(11) NOT NULL auto_increment,
  `oldwords` varchar(255) DEFAULT '',
  `newwords` varchar(255) DEFAULT '',
  `newtitle` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `num` int(11) DEFAULT '99',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_lang`;
CREATE TABLE `met_lang` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) DEFAULT '',
  `useok` int(1) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `mark` varchar(50) DEFAULT '',
  `synchronous` varchar(50) DEFAULT '',
  `flag` varchar(100) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `newwindows` int(1) DEFAULT '0',
  `metconfig_webhtm` int(1) DEFAULT '0',
  `metconfig_htmtype` varchar(50) DEFAULT '',
  `metconfig_weburl` varchar(255) DEFAULT '',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_lang_admin`;
CREATE TABLE `met_lang_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '' COMMENT '语言名称',
  `useok` int(1) DEFAULT '1' COMMENT '语言是否开启，1开启，0不开启',
  `no_order` int(11) DEFAULT '0' COMMENT '排序',
  `mark` varchar(50) DEFAULT '' COMMENT '语言标识（唯一）',
  `synchronous` varchar(50) DEFAULT '' COMMENT '同步官方语言标识',
  `link` varchar(255) DEFAULT '' COMMENT '语言外部链接',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_language`;
CREATE TABLE `met_language` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) DEFAULT '',
  `value` text,
  `site` tinyint(1) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `array` int(11) DEFAULT '0',
  `app` int(11) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_link`;
CREATE TABLE `met_link` (
  `id` int(11) NOT NULL auto_increment,
  `webname` varchar(255) DEFAULT '',
  `module` text,
  `weburl` varchar(255) DEFAULT '',
  `weblogo` varchar(255) DEFAULT '',
  `link_type` int(11) DEFAULT '0',
  `info` varchar(255) DEFAULT '',
  `contact` varchar(255) DEFAULT '',
  `orderno` int(11) DEFAULT '0',
  `com_ok` int(11) DEFAULT '0',
  `show_ok` int(11) DEFAULT '0',
  `addtime` datetime,
  `lang` varchar(50) DEFAULT '',
  `ip` varchar(255) DEFAULT '',
  `nofollow` tinyint(1) DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_menu`;
CREATE TABLE `met_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `icon` varchar(255) DEFAULT '',
  `text_color` varchar(100) DEFAULT '',
  `but_color` varchar(100) DEFAULT '',
  `target` int(11) DEFAULT '0' ,
  `enabled` int(11) DEFAULT '1',
  `no_order` int(11) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_message`;
CREATE TABLE `met_message` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(255) DEFAULT '',
  `addtime` datetime,
  `readok` int(11) DEFAULT '0',
  `useinfo` text,
  `lang` varchar(50) DEFAULT '',
  `access` text,
  `customerid` varchar(30) DEFAULT '0',
  `checkok` int(11) DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_mlist`;
CREATE TABLE `met_mlist` (
  `id` int(11) NOT NULL auto_increment,
  `listid` int(11) DEFAULT '0',
  `paraid` int(11) DEFAULT '0',
  `info` text,
  `lang` varchar(50) DEFAULT '',
  `imgname` varchar(255) DEFAULT '',
  `module` int(11) DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_news`;
CREATE TABLE `met_news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) DEFAULT '',
  `ctitle` varchar(200) DEFAULT '',
  `keywords` varchar(200) DEFAULT '',
  `description` text,
  `content` longtext,
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `wap_ok` int(1) DEFAULT '0',
  `img_ok` int(1) DEFAULT '0',
  `imgurl` varchar(255) DEFAULT '',
  `imgurls` varchar(255) DEFAULT '',
  `com_ok` int(1) DEFAULT '0',
  `issue` varchar(100) DEFAULT '',
  `hits` int(11) DEFAULT '0',
  `updatetime` datetime,
  `addtime` datetime,
  `access` text,
  `top_ok` int(1) DEFAULT '0',
  `filename` varchar(255) DEFAULT '',
  `lang` varchar(50) DEFAULT '',
  `recycle` int(11) DEFAULT '0',
  `displaytype` int(11) DEFAULT '1',
  `tag` text,
  `links` varchar(200) DEFAULT '',
  `publisher` varchar(50) DEFAULT '',
  `text_size` int(11)  DEFAULT '0',
  `text_color` varchar(100) DEFAULT '',
  `other_info` text,
  `custom_info` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_online`;
CREATE TABLE `met_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_order` int(11) DEFAULT '0',
  `name` varchar(255) DEFAULT '',
  `value` varchar(255) DEFAULT '',
  `icon` varchar(255) DEFAULT '',
  `type` int(11) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_otherinfo`;
CREATE TABLE `met_otherinfo` (
  `id` int(11) NOT NULL auto_increment,
  `info1` varchar(255) DEFAULT '',
  `info2` varchar(255) DEFAULT '',
  `info3` varchar(255) DEFAULT '',
  `info4` varchar(255) DEFAULT '',
  `info5` varchar(255) DEFAULT '',
  `info6` varchar(255) DEFAULT '',
  `info7` varchar(255) DEFAULT '',
  `info8` text,
  `info9` text,
  `info10` text,
  `imgurl1` varchar(255) DEFAULT '',
  `imgurl2` varchar(255) DEFAULT '',
  `rightmd5` varchar(255) DEFAULT '',
  `righttext` varchar(255) DEFAULT '',
  `authcode` text,
  `authpass` varchar(255) DEFAULT '',
  `authtext` varchar(255) DEFAULT '',
  `data` longtext,
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_para`;
CREATE TABLE `met_para` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT '0',
  `value` varchar(255) DEFAULT '',
  `module` int(10) DEFAULT '0',
  `order` int(10) DEFAULT '0',
  `lang` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_parameter`;
CREATE TABLE `met_parameter` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) DEFAULT '',
  `options` text,
  `description` text,
  `no_order` int(2) DEFAULT '0',
  `type` int(2) DEFAULT '0',
  `access` text,
  `wr_ok` int(2) DEFAULT '0',
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `module` int(2) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  `wr_oks` int(2) DEFAULT '0',
  `related` varchar(50) DEFAULT '',
  `edit_ok` int(2) DEFAULT '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_plist`;
CREATE TABLE `met_plist` (
  `id` int(11) NOT NULL auto_increment,
  `listid` int(11) DEFAULT '0',
  `paraid` int(11) DEFAULT '0',
  `info` text,
  `lang` varchar(50) DEFAULT '',
  `imgname` varchar(255) DEFAULT '',
  `module` int(11) DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_product`;
CREATE TABLE `met_product` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) DEFAULT '',
  `ctitle` varchar(200) DEFAULT '',
  `keywords` varchar(200) DEFAULT '',
  `description` text,
  `content` longtext,
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `classother` text NOT NULL,
  `no_order` int(11) DEFAULT '0',
  `wap_ok` int(1) DEFAULT '0',
  `new_ok` int(1) DEFAULT '0',
  `imgurl` varchar(255) DEFAULT '',
  `imgurls` varchar(255) DEFAULT '',
  `displayimg` text,
  `com_ok` int(1) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  `updatetime` datetime,
  `addtime` datetime,
  `issue` varchar(100) DEFAULT '',
  `access` text,
  `top_ok` int(1) DEFAULT '0',
  `filename` varchar(255) DEFAULT '',
  `lang` varchar(50) DEFAULT '',
  `video` text,
  `content1` mediumtext,
  `content2` mediumtext,
  `content3` mediumtext,
  `content4` mediumtext,
  `contentinfo` varchar(255) DEFAULT '',
  `contentinfo1` varchar(255) DEFAULT '',
  `contentinfo2` varchar(255) DEFAULT '',
  `contentinfo3` varchar(255) DEFAULT '',
  `contentinfo4` varchar(255) DEFAULT '',
  `recycle` int(11) DEFAULT '0',
  `displaytype` int(11) DEFAULT '1',
  `tag` text,
  `links` varchar(200) DEFAULT '',
  `imgsize` varchar(200) DEFAULT '',
  `text_size` int(11)  DEFAULT '0',
  `text_color` varchar(100) DEFAULT '',
  `other_info` text,
  `custom_info` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_skin_table`;
CREATE TABLE `met_skin_table` (
  `id` int(11) NOT NULL auto_increment,
  `skin_name` varchar(200) DEFAULT '',
  `skin_file` varchar(20) DEFAULT '',
  `skin_info` text,
  `devices` int(11) DEFAULT '0',
  `ver` varchar(10) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_tags`;
CREATE TABLE `met_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255)  DEFAULT '',
  `tag_pinyin` varchar(255)  DEFAULT '',
  `module` int(11) DEFAULT 0,
  `cid` int(11) DEFAULT 0,
  `list_id` varchar(255)  DEFAULT '',
  `title` varchar(255)  DEFAULT '',
  `keywords` varchar(255)  DEFAULT '',
  `description` varchar(255)  DEFAULT '',
  `tag_color` varchar(255)  DEFAULT '',
  `tag_size` int(10) DEFAULT '0',
  `sort` int(10) DEFAULT 0,
  `lang` varchar(100) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_templates`;
CREATE TABLE IF NOT EXISTS `met_templates` (
  `id` int(11) NOT NULL auto_increment,
  `no` varchar(20) DEFAULT '0',
  `pos` int(11) DEFAULT '0',
  `no_order` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `style` int(11) DEFAULT '0',
  `selectd` varchar(500) DEFAULT '',
  `name` varchar(50) DEFAULT '',
  `value` text,
  `defaultvalue` text,
  `valueinfo` varchar(100) DEFAULT '',
  `tips` varchar(255) DEFAULT '',
  `lang` varchar(50) DEFAULT '',
  `bigclass` int(11) DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_ui_list`;
CREATE TABLE `met_ui_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `installid` int(10) DEFAULT '0',
  `parent_name` varchar(100) DEFAULT '',
  `ui_name` varchar(100) DEFAULT '',
  `skin_name` varchar(100) DEFAULT '',
  `ui_page` varchar(200) DEFAULT '',
  `ui_title` varchar(100) DEFAULT '',
  `ui_description` varchar(500) DEFAULT '',
  `ui_order` int(10) DEFAULT '0',
  `ui_version` varchar(100) DEFAULT '',
  `ui_installtime` int(10) DEFAULT '0',
  `ui_edittime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_ui_config`;
CREATE TABLE `met_ui_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT '0',
  `parent_name` varchar(100) DEFAULT '',
  `ui_name` varchar(100) DEFAULT '',
  `skin_name` varchar(100) DEFAULT '',
  `uip_type` int(10) DEFAULT '0',
  `uip_style` tinyint(1) DEFAULT '0',
  `uip_select` varchar(500) DEFAULT '1',
  `uip_name` varchar(100) DEFAULT '',
  `uip_key` varchar(100) DEFAULT '',
  `uip_value` text,
  `uip_default` varchar(255) DEFAULT '',
  `uip_title` varchar(100) DEFAULT '',
  `uip_description` varchar(255) DEFAULT '',
  `uip_order` int(10)  DEFAULT '0',
  `lang` varchar(100) DEFAULT '',
  `uip_hidden` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_user`;
CREATE TABLE IF NOT EXISTS `met_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) DEFAULT '',
  `password` varchar(32) DEFAULT '',
  `head` varchar(100) DEFAULT '',
  `email` varchar(50) DEFAULT '',
  `tel` varchar(20) DEFAULT '',
  `groupid` int(11) DEFAULT '0',
  `register_time` int(11) DEFAULT '0',
  `register_ip` varchar(15) DEFAULT '',
  `login_time` int(11) DEFAULT '0',
  `login_count` int(11) DEFAULT '0',
  `login_ip` varchar(15) DEFAULT '',
  `valid` int(1) DEFAULT '0',
  `source` varchar(20) DEFAULT '',
  `lang` varchar(50) DEFAULT '',
  `idvalid` int(1) DEFAULT '0' COMMENT '实名认证状态',
  `reidinfo` varchar(100) DEFAULT '' COMMENT '实名信息  姓名|身份证|手机号',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

DROP TABLE IF EXISTS `met_user_group`;
CREATE TABLE IF NOT EXISTS `met_user_group` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) DEFAULT '',
  `access` int(11) DEFAULT '0',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_user_group_pay`;
CREATE TABLE IF NOT EXISTS`met_user_group_pay` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(11) DEFAULT '0' COMMENT '会员组ID',
  `price` double(10,2) DEFAULT '0' COMMENT '购买价格',
  `recharge_price` double(10,2) DEFAULT '0'  COMMENT '充值价格',
  `buyok` int(1) DEFAULT '0' COMMENT '付费会员',
  `rechargeok` int(50) DEFAULT '0' COMMENT '充值会员',
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_user_list`;
CREATE TABLE IF NOT EXISTS `met_user_list` (
  `id` int(11) NOT NULL auto_increment,
  `listid` int(11) DEFAULT '0',
  `paraid` int(11) DEFAULT '0',
  `info` text,
  `lang` varchar(50) DEFAULT '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `met_user_other`;
CREATE TABLE IF NOT EXISTS `met_user_other` (
  `id` int(11) NOT NULL auto_increment,
  `metconfig_uid` int(11) DEFAULT '0',
  `openid` varchar(100) DEFAULT '',
  `unionid` varchar(100) DEFAULT '',
  `access_token` varchar(255) DEFAULT '',
  `expires_in` int(11) DEFAULT '0',
  `type` varchar(10) DEFAULT '',
  PRIMARY KEY  (`id`),
  KEY `openid` (`openid`),
  KEY `metconfig_uid` (`metconfig_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

DROP TABLE IF EXISTS `met_weixin_reply_log`;
CREATE TABLE IF NOT EXISTS `met_weixin_reply_log` (
  `id` int(11) NOT NULL auto_increment,
  `FromUserName` varchar(255) DEFAULT '',
  `Content` text,
  `rid` int(11) DEFAULT NULL,
  `CreateTime` int(10) DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;


INSERT INTO met_applist VALUES(null, '0', '1.0', 'ueditor', 'index', 'doindex', '百度编辑器', '编辑器', '0', '0', '0','0','','0');
INSERT INTO met_applist VALUES(null,'10070','1.5', 'metconfig_sms', 'index', 'doindex', '短信功能', '短信接口', '0', '0', '0','1','','0');
INSERT INTO met_applist VALUES(null,'50002','1.0', 'metconfig_template', 'temtool', 'dotemlist', '官方模板管理工具', '官方商业模板请在此进行管理操作', '0', '0', '0','1','','1');

#系统全局配置
INSERT INTO met_config VALUES(null,'metcms_v','7.3.0','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_ch_lang','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_lang_mark','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_admin_type_ok','0','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_admin_type','cn','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_index_type','cn','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_host','api.metinfo.cn','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_host_new','app.metinfo.cn','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_api', 'https://u.mituo.cn/api/client', '', '0', '0', 'metinfo');
INSERT INTO met_config VALUES(null,'metconfig_tablename','admin_array|admin_column|admin_logs|admin_table|app_config|app_plugin|applist|column|config|cv|download|feedback|flash|flash_button|flist|ifcolumn|ifcolumn_addfile|ifmember_left|img|infoprompt|job|label|lang|lang_admin|language|link|menu|message|mlist|news|online|otherinfo|para|parameter|plist|product|skin_table|tags|templates|ui_config|ui_list|user|user_group|user_group_pay|user_list|user_other|weixin_reply_log','','0','0','metinfo');

#其他配置
INSERT INTO met_config VALUES(null,'metconfig_safe_prompt', '0', '', '0', '0', 'metinfo');
INSERT INTO met_config VALUES(null,'metconfig_uiset_guide', '1', '', '0', '0', 'metinfo');
INSERT INTO met_config VALUES(null,'metconfig_301jump', '', '', 0, 0, 'metinfo');
INSERT INTO met_config VALUES(null,'metconfig_https', '', '', 0, 0, 'metinfo');
INSERT INTO met_config VALUES(null,'disable_cssjs', 0, '', 0, 0, 'metinfo');
INSERT INTO met_config VALUES(null,'metconfig_secret_key','','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_member_force','byuqujz','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_editor', 'ueditor', '', '0', '0', 'metinfo');
INSERT INTO met_config VALUES (null, 'metconfig_text_fonts', '../public/fonts/Cantarell-Regular.ttf', '','0','0', 'metinfo');
INSERT INTO met_config VALUES(null,'metconfig_smsprice','0.1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_sms_token', '', '', '0', '0', 'metinfo');
INSERT INTO met_config VALUES(null,'metconfig_sms_url', 'https://u.mituo.cn/api/sms', '', '0', '0', 'metinfo');

#SEO-siteMap
INSERT INTO met_config VALUES(null,'metconfig_sitemap_lang','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_sitemap_not2','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_sitemap_not1','0','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_sitemap_txt','0','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_sitemap_xml','1','','0','0','metinfo');

#版权控制配置
INSERT INTO met_config VALUES(null,'metconfig_agents_logo_login','../public/images/login-logo.png','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_logo_index','../public/images/logo.png','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_img','../public/images/metinfo.gif','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_copyright_foot','Powered by <b><a href=https://www.metinfo.cn target=_blank title=CMS>MetInfo $metcms_v</a></b> &copy;2008-$m_now_year &nbsp;<a href=https://www.mituo.cn target=_blank title=米拓建站>mituo.cn</a>','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_copyright_foot1','本站基于 <b><a href=https://www.metinfo.cn target=_blank title=米拓建站>米拓企业建站系统 $metcms_v</a></b> 搭建','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_copyright_foot2','技术支持：<b><a href=https://www.mituo.cn target=_blank title=米拓建站>米拓建站 </a></b> $metcms_v ','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_copyright_nofollow', '0', '', '0', '0', 'metinfo');
INSERT INTO met_config VALUES(null,'metconfig_copyright_type','0','','0','0','metinfo');
#版权控制
INSERT INTO met_config VALUES(null,'metconfig_agents_type','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_linkurl','https://www.mituo.cn','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_pageset_logo','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_update','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_code','','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_backup','metinfo','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_sms','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_app','1','','0','0','metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_metmsg', '1', '', '', '', 'metinfo');
#代理信息
INSERT INTO met_config VALUES(null,'metconfig_agents_thanks','感谢使用 Metinfo','','0','0','cn-metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_name','MetInfo|米拓企业建站系统','','0','0','cn-metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_copyright','长沙米拓信息技术有限公司（MetInfo Inc.）','','0','0','cn-metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_depict_login','MetInfo','','0','0','cn-metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_thanks','thanks use Metinfo','','0','0','en-metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_name','Metinfo CMS','','0','0','en-metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_copyright','China Changsha MetInfo Information Co., Ltd.','','0','0','en-metinfo');
INSERT INTO met_config VALUES(null,'metconfig_agents_depict_login','Metinfo Build marketing value corporate website','','0','0','en-metinfo');

#后台栏目
INSERT INTO `met_admin_column` VALUES ('1', 'lang_administration', 'manage', '0', '1301', '1', '0', 'manage', '', '1');
INSERT INTO `met_admin_column` VALUES ('2', 'lang_htmColumn', 'column', '0', '1201', '1', '1', 'column', '', '1');
INSERT INTO `met_admin_column` VALUES ('3', 'lang_feedback_interaction', '', '0', '1202', '1', '2', 'feedback-interaction', '', '1');
INSERT INTO `met_admin_column` VALUES ('4', 'lang_seo_set_v6', 'seo', '0', '1404', '1', '3', 'seo', '', '1');
INSERT INTO `met_admin_column` VALUES ('5', 'lang_appearance', 'app/metconfig_template', '0', '1405', '1', '4', 'template', '', '1');
INSERT INTO `met_admin_column` VALUES ('6', 'lang_myapp', 'myapp', '0', '1505', '1', '5', 'application', '', '1');
INSERT INTO `met_admin_column` VALUES ('7', 'lang_the_user', '', '0', '1506', '1', '6', 'user', '', '1');
INSERT INTO `met_admin_column` VALUES ('8', 'lang_safety', '', '0', '1200', '1', '7', 'safety', '', '1');
INSERT INTO `met_admin_column` VALUES ('9', 'lang_multilingual', 'language', '0', '1002', '1', '8', 'multilingualism', '', '1');
INSERT INTO `met_admin_column` VALUES ('10', 'lang_unitytxt_39', '', '0', '1100', '1', '9', 'setting', '', '1');
INSERT INTO `met_admin_column` VALUES ('11', 'cooperation_platform', 'partner', '0', '1508', '1', '10', 'partner', '', '1');
INSERT INTO `met_admin_column` VALUES ('21', 'lang_mod8', 'feed_feedback_8', '3', '1509', '2', '0', 'feedback', '', '1');
INSERT INTO `met_admin_column` VALUES ('22', 'lang_mod7', 'feed_message_7', '3', '1510', '2', '1', 'message', '', '1');
INSERT INTO `met_admin_column` VALUES ('23', 'lang_mod6', 'feed_job_6', '3', '1511', '2', '2', 'recruit', '', '1');
INSERT INTO `met_admin_column` VALUES ('24', 'lang_customerService', 'online', '3', '1106', '2', '3', 'online', '', '1');
INSERT INTO `met_admin_column` VALUES ('25', 'lang_indexlink', 'link', '4', '1406', '2', '0', 'link', '', '0');
INSERT INTO `met_admin_column` VALUES ('26', 'lang_member', 'user', '7', '1601', '2', '0', 'member', '', '1');
INSERT INTO `met_admin_column` VALUES ('27', 'lang_managertyp2', 'admin/user', '7', '1603', '2', '1', 'administrator', '', '1');
INSERT INTO `met_admin_column` VALUES ('28', 'lang_safety_efficiency', 'safe', '8', '1004', '2', '0', 'safe', '', '1');
INSERT INTO `met_admin_column` VALUES ('29', 'lang_data_processing', 'databack', '8', '1005', '2', '1', 'databack', '', '1');
INSERT INTO `met_admin_column` VALUES ('30', 'lang_upfiletips7', 'webset', '10', '1007', '2', '0', 'information', '', '1');
INSERT INTO `met_admin_column` VALUES ('31', 'lang_indexpic', 'imgmanage', '10', '1003', '2', '1', 'picture', '', '1');
INSERT INTO `met_admin_column` VALUES ('32', 'lang_banner_manage', 'banner', '10', '1604', '2', '2', 'banner', '', '1');
INSERT INTO `met_admin_column` VALUES ('33', 'lang_the_menu', 'menu', '10', '1605', '2', '3', 'bottom-menu', '', '1');
INSERT INTO `met_admin_column` VALUES ('34', 'lang_checkupdate', 'update', '37', '1104', '2', '4', 'update', '', '0');
INSERT INTO `met_admin_column` VALUES ('35', 'lang_appinstall', 'appinstall', '6', '1800', '2', '0', 'appinstall', '', '0');
INSERT INTO `met_admin_column` VALUES ('36', 'lang_dlapptips6', 'appuninstall', '6', '1801', '2', '0', 'appuninstall', '', '0');
INSERT INTO `met_admin_column` VALUES ('37', 'lang_top_menu', 'top_menu', '0', '1900', '1', '0', 'top_menu', '', '0');
INSERT INTO `met_admin_column` VALUES ('38', 'lang_clearCache', 'clear_cache', '37', '1901', '2', '0', 'clear_cache', '', '0');
INSERT INTO `met_admin_column` VALUES ('39', 'lang_funcCollection', 'function_complete', '37', '1902', '2', '0', 'function_complete', '', '0');
INSERT INTO `met_admin_column` VALUES ('40', 'lang_environmental_test', 'environmental_test', '37', '1903', '2', '0', 'environmental_test', '', '0');
INSERT INTO `met_admin_column` VALUES ('41', 'lang_navSetting', 'navSetting', '6', '1904', '2', '0', 'navSetting', '', '0');
INSERT INTO `met_admin_column` VALUES ('42', 'lang_style_settings', 'style_settings', '5', '1905', '2', '0', 'style_settings', '', '0');

#后台语言
INSERT INTO met_lang_admin VALUES (null, '简体中文', '1', '1', 'cn', 'cn', '', 'cn');
INSERT INTO met_lang_admin VALUES (null, 'English', '1', '2', 'en', 'en', '', 'en');

#管理员
INSERT INTO met_admin_array VALUES(null,'管理员','metinfo','1','metinfo','0','10000','256','2','metinfo','metinfo');

#模板
INSERT INTO met_skin_table VALUES(null,'metv7','metv7','MetInfo v7.0正式版新推出一套全新精致免费模板！','0','');
INSERT INTO met_otherinfo VALUES(null,'NOUSER','2147483647','','','','','','','','','','','','','','','','','metinfo');