<?php
/**
 * Created by PhpStorm.
 * User: Kornel Błażek
 * Date: 12.02.2018
 * Time: 15:09
 */
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT',__DIR__);

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT);

require_once INCLUDES_PATH.DS.'Database.php';
require_once INCLUDES_PATH.DS.'DbObject.php';
require_once INCLUDES_PATH.DS.'User.php';
require_once INCLUDES_PATH.DS.'Session.php';
require_once INCLUDES_PATH.DS.'Admin.php';
require_once INCLUDES_PATH.DS.'Product.php';
require_once INCLUDES_PATH.DS.'Category.php';
require_once INCLUDES_PATH.DS.'Volume.php';
require_once INCLUDES_PATH.DS.'VolumesProduct.php';
require_once INCLUDES_PATH.DS.'Prices.php';
require_once INCLUDES_PATH.DS.'VolumesPrices.php';
require_once INCLUDES_PATH.DS.'Orders.php';
require_once INCLUDES_PATH.DS.'ProductsOrder.php';
require_once INCLUDES_PATH . DS . 'DiscountCodes.php';
require_once INCLUDES_PATH.DS.'DiscountCodesGroups.php';
require_once INCLUDES_PATH.DS.'CodesVolumes.php';