<?php
/**
 * @brief stopForumSpam, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\stopForumSpam;

use dcCore;
use Dotclear\Plugin\antispam\SpamFilter;
use Exception;

class AntispamFilterStopForumSpam extends SpamFilter
{
    public $name    = 'Stop Forum Spam';
    public $has_gui = false;
    public $active  = false;

    protected function setInfo()
    {
        $this->description = __('Stop Forum Spam spam filter (see http://www.stopforumspam.com/)');
    }

    public function getStatusMessage($status, $comment_id)
    {
        return sprintf(__('Filtered by %s.'), $this->guiLink());
    }

    private function sfsInit()
    {
        return new StopForumSpam(dcCore::app()->blog->url);
    }

    public function isSpam($type, $author, $email, $site, $ip, $content, $post_id, &$status)
    {
        if (($sfs = $this->sfsInit()) === false) {
            return;
        }

        try {
            $c = $sfs->comment_check($email, $ip);
            if ($c) {
                $status = 'Filtered by Stop Forum Spam';

                return true;
            }
        } catch (Exception $e) {
            // If http or akismet is dead, we don't need to know it
        }
    }
}
