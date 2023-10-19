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

use Dotclear\App;
use Dotclear\Plugin\antispam\SpamFilter;
use Exception;

class AntispamFilterStopForumSpam extends SpamFilter
{
    /** @var string Filter name */
    public string $name = 'Stop Forum Spam';

    /** @var bool Filter has settings GUI? */
    public bool $has_gui = false;

    /** @var bool Is filter active? */
    public bool $active = false;

    /**
     * Sets the filter description.
     */
    protected function setInfo(): void
    {
        $this->description = __('Stop Forum Spam spam filter (see http://www.stopforumspam.com/)');
    }

    /**
     * This method returns filter status message. You can overload this method to
     * return a custom message. Message is shown in comment details and in
     * comments list.
     *
     * @param      string  $status      The status
     * @param      int     $comment_id  The comment identifier
     *
     * @return     string  The status message.
     */
    public function getStatusMessage(string $status, ?int $comment_id): string
    {
        return sprintf(__('Filtered by %s.'), $this->guiLink());
    }

    private function sfsInit(): StopForumSpam
    {
        return new StopForumSpam(App::blog()->url());
    }

    /**
     * This method should return if a comment is a spam or not. If it returns true
     * or false, execution of next filters will be stoped. If should return nothing
     * to let next filters apply.
     *
     * Your filter should also fill $status variable with its own information if
     * comment is a spam.
     *
     * @param      string  $type     The comment type (comment / trackback)
     * @param      string  $author   The comment author
     * @param      string  $email    The comment author email
     * @param      string  $site     The comment author site
     * @param      string  $ip       The comment author IP
     * @param      string  $content  The comment content
     * @param      int     $post_id  The comment post_id
     * @param      string  $status   The comment status
     */
    public function isSpam(string $type, ?string $author, ?string $email, ?string $site, ?string $ip, ?string $content, ?int $post_id, string &$status)
    {
        try {
            $sfs = $this->sfsInit();
            $c   = $sfs->comment_check($email, (string) $ip);
            if ($c) {
                $status = 'Filtered by Stop Forum Spam';

                return true;
            }
        } catch (Exception) {
            // If http or akismet is dead, we don't need to know it
        }
    }
}
