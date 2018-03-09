<?php
/**
 * @brief stopforumspam, an antispam filter plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('DC_RC_PATH')) {return;}

$__autoload['dcFilterStopForumSpam'] = dirname(__FILE__) . '/class.dc.filter.stopforumspam.php';
$core->spamfilters[]                 = 'dcFilterStopForumSpam';
