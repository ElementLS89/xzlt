<?php
$dzuid=DB::fetch_first("Describe ".DB::table('common_user').' dzuid');
if(!$dzuid['Field'] && !$dzuid[0]){
	runquery("ALTER TABLE sms_common_user ADD `dzuid` INT(10) NULL DEFAULT '0' AFTER `uid`, ADD INDEX (`dzuid`);");
}

$mini=DB::fetch_first("Describe ".DB::table('common_user').' mini');
if(!$mini['Field'] && !$mini[0]){
	runquery('ALTER TABLE sms_common_user ADD `mini` VARCHAR(255) CHARACTER SET utf8 NOT NULL AFTER `unionid`;');
}
	
$topic=DB::fetch_first("Describe ".DB::table('topic').' price');
$theme=DB::fetch_first("Describe ".DB::table('topic_themes').' price');

if(!$topic['Field'] && !$topic[0]){
	runquery("ALTER TABLE sms_topic ADD `price` SMALLINT(6) NOT NULL DEFAULT '0' AFTER `show`;");
}
if(!$theme['Field'] && !$theme[0]){
	runquery("ALTER TABLE sms_topic_themes ADD `price` SMALLINT(6) NOT NULL DEFAULT '0' AFTER `tid`;");
}


$sql_check = <<<EOF
ALTER TABLE sms_common_user_count CHANGE  `gold`  `gold` FLOAT NOT NULL DEFAULT  '0';
ALTER TABLE `sms_common_paylog` CHANGE `body` `body` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
CREATE TABLE IF NOT EXISTS `sms_topic_theme_log` (
  `lid` int(10) NOT NULL AUTO_INCREMENT,
  `vid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `price` smallint(6) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `vid` (`vid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `sms_common_icon` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 NOT NULL,
  `code_on` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `sms_common_illustration` (
  `picid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `atc` varchar(255) NOT NULL,
  `thumb` tinyint(1) NOT NULL,
  `width` smallint(6) NOT NULL,
  `height` smallint(6) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`picid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `sms_common_mini` (
  `mini` varchar(40) NOT NULL,
  `uid` int(10) NOT NULL,
  PRIMARY KEY (`mini`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOF;
runquery($sql_check);
?>