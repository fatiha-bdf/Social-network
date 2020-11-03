#!/usr/bin/php
<?php
include_once('DB.php');
require 'database.php';

DB::query("CREATE DATABASE IF NOT EXISTS `camagru`", array());


DB::query("CREATE TABLE IF NOT EXISTS `users` (
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	`username` varchar(8) NOT NULL, 
	`email` varchar(255) NOT NULL, 
	`password` varchar(255) NOT NULL,
	`confirmed` varchar(11) NOT NULL,
	`allow_notif` varchar(11) NOT NULL
)", array());

DB::query("CREATE TABLE IF NOT EXISTS `gallery` ( 
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`img_name` varchar(255) NOT NULL, 
	`img_dir` varchar(255) NOT NULL, 
	`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`user_id` INT(11) NOT NULL, 
	`likes` INT(11) NOT NULL
)", array());

DB::query("CREATE TABLE IF NOT EXISTS `editor` ( 
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`img_name` varchar(255) NOT NULL, 
	`img_dir` varchar(255) NOT NULL, 
	`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`user_id` INT(11) NOT NULL
)", array());

DB::query("CREATE TABLE IF NOT EXISTS `comments` ( 
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`image` varchar(255) NOT NULL, 
	`body` text(255) NOT NULL, 
	`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`username` VARCHAR(250) NOT NULL, 
	`user_id` INT(11) NOT NULL 
)", array());

DB::query("CREATE TABLE IF NOT EXISTS `user_likes` ( 
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`img_name` varchar(255) NOT NULL, 
	`user_id` INT(11) NOT NULL
)", array());

DB::query("CREATE TABLE IF NOT EXISTS `login_tokens` ( 
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`token` varchar(64) NOT NULL, 
	`user_id` INT(11) NOT NULL 
)", array());

DB::query("CREATE TABLE IF NOT EXISTS `pass_tokens` ( 
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`token` varchar(64) NOT NULL, 
	`user_id` INT(11) NOT NULL 
)", array());

?>
