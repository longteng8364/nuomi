CREATE DATABASE o2o;
use o2o;

/* 分类表 */
CREATE TABLE `o2o_category`(
    `id` int unsigned NOT NULL auto_increment,
    `name` VARCHAR(64) NOT NULL DEFAULT '',
    `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
    `listorder` int(8) unsigned NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY parent_id(`parent_id`)
)ENGINE=InnoDB auto_increment=1 DEFAULT CHARSET=utf8;


/* 城市表 */
CREATE TABLE `o2o_city`(
    `id` int unsigned NOT NULL auto_increment,
    `name` VARCHAR(64) NOT NULL DEFAULT '',
    `uname` VARCHAR(64) NOT NULL DEFAULT '',
    `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
    `listorder` int(8) unsigned NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY parent_id(`parent_id`),
    UNIQUE KEY uname(`uname`)
)ENGINE=InnoDB auto_increment=1 DEFAULT CHARSET=utf8;


/* 商户表 */
CREATE TABLE `o2o_bis`(
    `id` int unsigned NOT NULL auto_increment,
    `name` VARCHAR(64) NOT NULL DEFAULT '',
    `email` VARCHAR(64) NOT NULL DEFAULT '',
    `logo` VARCHAR(255) NOT NULL DEFAULT '',
    `licence_logo` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT NOT NULL DEFAULT '',
    `city_id` int unsigned NOT NULL DEFAULT 0,
    `city_path` VARCHAR(64) NOT NULL DEFAULT '',
    `bank_info` VARCHAR(32) NOT NULL DEFAULT '',
    `bank_name` VARCHAR(64) NOT NULL DEFAULT '',
    `bank_user` VARCHAR(64) NOT NULL DEFAULT '',
    `money` decimal(20,2) NOT NULL DEFAULT 0.00,
    `faren` VARCHAR(20) NOT NULL DEFAULT '',
    `faren_tel` VARCHAR(20) NOT NULL DEFAULT '',
    `listorder` int(8) unsigned NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY city_id(`city_id`),
    KEY name(`name`)
)ENGINE=InnoDB auto_increment=1 DEFAULT CHARSET=utf8;

/* 商户账号表 */
CREATE TABLE `o2o_bis_account`(
    `id` int unsigned NOT NULL auto_increment,
    `username` VARCHAR(64) NOT NULL DEFAULT '',
    `password` CHAR(32) NOT NULL DEFAULT '',
    `code` VARCHAR(10) NOT NULL DEFAULT '',
    `bis_id` int unsigned NOT NULL DEFAULT 0,
    `last_login_ip` VARCHAR(20) NOT NULL DEFAULT '',
    `last_login_time` int unsigned NOT NULL DEFAULT 0,
    `is_main` TINYINT(1) unsigned NOT NULL DEFAULT 0,
    `listorder` int(8) unsigned NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY bis_id(`bis_id`),
    KEY username(`username`)
)ENGINE=InnoDB auto_increment=1 DEFAULT CHARSET=utf8;

/* 商户门店表 */
CREATE TABLE `o2o_bis_location`(
    `id` int unsigned NOT NULL auto_increment,
    `name` VARCHAR(64) NOT NULL DEFAULT '',
    `logo` VARCHAR(255) NOT NULL DEFAULT '',
    `address` VARCHAR(255) NOT NULL DEFAULT '',
    `tel` VARCHAR(20) NOT NULL DEFAULT '',
    `contact` VARCHAR(20) NOT NULL DEFAULT '',
    `xpoint` VARCHAR(20) NOT NULL DEFAULT '',
    `ypoint` VARCHAR(20) NOT NULL DEFAULT '',
    `bis_id` int unsigned NOT NULL DEFAULT 0,
    `open_time` int unsigned NOT NULL DEFAULT 0,
    `content` TEXT NOT NULL DEFAULT '',
    `is_main` tinyint(1) unsigned NOT NULL DEFAULT 0,
    `api_address` VARCHAR(255) NOT NULL DEFAULT '',
    `city_id` int unsigned NOT NULL DEFAULT 0,
    `city_path` VARCHAR(64) NOT NULL DEFAULT '',
    `category_id` int unsigned NOT NULL DEFAULT 0,
    `category_path` VARCHAR(50) NOT NULL DEFAULT '',  
    `bank_info` VARCHAR(32) NOT NULL DEFAULT '',
    `listorder` int(8) unsigned NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY city_id(`city_id`),
    KEY bis_id(`bis_id`),
    KEY category_id(`category_id`),
    KEY name(`name`)
)ENGINE=InnoDB auto_increment=1 DEFAULT CHARSET=utf8;

-- 商品表
CREATE TABLE `o2o_deal`(
    `id` int unsigned NOT NULL auto_increment,
    `name` VARCHAR(100) NOT NULL DEFAULT '',
    `category_id` int NOT NULL DEFAULT 0,
    `se_category_id` int NOT NULL DEFAULT 0,
    `bis_id` int NOT NULL DEFAULT 0,
    `location_ids` VARCHAR(100) NOT NULL DEFAULT '',
    `image` VARCHAR(200) NOT NULL DEFAULT '',
    `description` TEXT NOT NULL,
    `start_time` int NOT NULL DEFAULT 0,
    `end_time` int NOT NULL DEFAULT 0,
    `origin_price` decimal(20,2) NOT NULL DEFAULT 0.00,
    `current_price` decimal(20,2) NOT NULL DEFAULT 0.00,
    `city_id` int NOT NULL DEFAULT 0,
    `buy_count` int NOT NULL DEFAULT 0,
    `total_count` int NOT NULL DEFAULT 0,
    `coupons_begin_time` int NOT NULL DEFAULT 0,
    `coupons_end_time` int NOT NULL DEFAULT 0,
    `xpoint` VARCHAR(20) NOT NULL DEFAULT '',
    `ypoint` VARCHAR(20) NOT NULL DEFAULT '',
    `bis_account_id` int NOT NULL DEFAULT 0,
    `balance_price` decimal(20,2) NOT NULL DEFAULT 0.00,
    `notes` TEXT NOT NULL,
    `listorder` int(8) unsigned NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY category_id(`category_id`),
    KEY se_category_id(`se_category_id`),
    KEY city_id(`city_id`),
    KEY start_time(`start_time`),
    KEY end_time(`end_time`),
    KEY create_time(`create_time`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 用户表
CREATE TABLE `o2o_user`(
    `id` int unsigned NOT NULL auto_increment,
    `username` VARCHAR(20) NOT NULL DEFAULT '',
    `password` char(32) NOT NULL DEFAULT '',
    `code` VARCHAR(10) NOT NULL DEFAULT '',
    `last_login_time` int unsigned NOT NULL DEFAULT 0,
    `last_login_ip` VARCHAR(20) NOT NULL DEFAULT '',
    `email` VARCHAR(32) NOT NULL DEFAULT '',
    `mobile` VARCHAR(20) NOT NULL DEFAULT '',
    `listorder` int(8) unsigned NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY username(`username`),
    UNIQUE KEY email(`email`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 推荐位表
CREATE TABLE `o2o_featured`(
    `id` int unsigned NOT NULL auto_increment,
    `type` TINYINT(1) NOT NULL DEFAULT 0,
    `title` VARCHAR(32) NOT NULL DEFAULT '',
    `image` VARCHAR(255) NOT NULL DEFAULT '',
    `description` VARCHAR(255) NOT NULL DEFAULT '',
    `url` VARCHAR(255) NOT NULL DEFAULT '',
    `listorder` int(8) unsigned NOT NULL DEFAULT 0,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 订单表
CREATE TABLE `o2o_order`(
    `id` int unsigned NOT NULL auto_increment,
    `out_trade_no` varchar(100) NOT NULL DEFAULT '',
    `transaction_id` varchar(100) NOT NULL DEFAULT '',
    `user_id` int NOT NULL DEFAULT 0,
    `username` varchar(50) NOT NULL DEFAULT '',
    `pay_time` varchar(20) NOT NULL DEFAULT '',
    `payment_id` tinyint(1) NOT NULL DEFAULT 1,
    `deal_id` int NOT NULL DEFAULT 0,
    `deal_count` int NOT NULL DEFAULT 0,
    `pay_status` tinyint(1) NOT NULL DEFAULT 1,
    `total_price` decimal(20,2) NOT NULL DEFAULT 0.00,
    `pay_amount` decimal(20,2) NOT NULL DEFAULT 0.00,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `referer` varchar(255) NOT NULL DEFAULT '',
    `create_time` INT unsigned NOT NULL DEFAULT 0,
    `update_time` INT unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
