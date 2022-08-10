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
if (!defined('DC_RC_PATH')) {
    return;
}

class dcFilterStopForumSpam extends dcSpamFilter
{
    public $name    = 'Stop Forum Spam';
    public $has_gui = false;
    public $active  = false;

    public function __construct($core = null)
    {
        parent::__construct(dcCore::app());
    }

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
        return new stopForumSpam(dcCore::app()->blog->url);
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
        } # If http or akismet is dead, we don't need to know it
    }
}

class stopForumSpam extends netHttp
{
    protected $sfs_host = 'api.stopforumspam.org';
    protected $sfs_path = '/api';
    protected $timeout  = 3;
    protected $blog_url;

    public function __construct($blog_url)
    {
        parent::__construct($this->sfs_host, 80);
        $this->blog_url = $blog_url;
    }

    public function comment_check($email, $ip)
    {
        $data = [
            // We don't check email up to now, we will see later after some tests
            // 'email' => $email,
            'ip' => $ip, // Tested with '118.70.72.246' marked as spam (2015/11/28)
            'f'  => 'json',
        ];

        $this->host = $this->sfs_host;
        if (!$this->get($this->sfs_path, $data)) {
            throw new Exception('HTTP error: ' . $this->getError());    // @phpstan-ignore-line
        }

        $ret = $this->getContent();
        if ($ret) {
            $json = json_decode($ret);
            if ($json->success) {
                // Check ip only (agressive mode)
                if ((int) $json->ip->appears > 0) {
                    return true;
                }
            }
        }
        // return without any value, may be a spam, may be a ham, Stop Forum Spam doesn't know
    }
}
