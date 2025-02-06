<?php
use Statistic\StatisticsManager;
use Config\Database;
require_once('/laragon/www/youdemy_mvc/vendor/autoload.php');
$database=new Database();
$db=$database->getConnection();
$stats = new StatisticsManager($db);
?>