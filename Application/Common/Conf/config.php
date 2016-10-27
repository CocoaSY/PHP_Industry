<?php

include("DBConf.php");
include("IntegralConf.php");
include("IndexConf.php");
include("TestConf.php");

$dbConf = DBConfig();
$integralConf = IntegralConfig();
$indexConf = IndexConfig();

$testConf = TestConfig();

return array_merge($dbConf,$integralConf,$indexConf,$testConf);