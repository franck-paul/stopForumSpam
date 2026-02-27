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

use Dotclear\Helper\Network\HttpClient;
use Exception;

class StopForumSpam extends HttpClient
{
    protected string $sfs_host = 'api.stopforumspam.org';

    protected string $sfs_path = '/api';

    /**
     * @var        int
     */
    protected $timeout = 3;

    public function __construct(
        protected string $blog_url
    ) {
        parent::__construct($this->sfs_host, 80);
    }

    /**
     * Check a comment
     *
     * @param      mixed      $email  The email
     * @param      string     $ip     The IP address
     *
     * @throws     Exception
     */
    public function comment_check(mixed $email, string $ip): bool|null
    {
        $data = [
            // We don't check email up to now, we will see later after some tests
            // 'email' => $email,
            'ip' => $ip, // Tested with '118.70.72.246' marked as spam (2015/11/28)
            'f'  => 'json',
        ];

        $this->host = $this->sfs_host;
        if (!$this->get($this->sfs_path, $data)) {
            throw new Exception('HTTP error: ' . $this->getStatus());
        }

        $ret = $this->getContent();
        if ($ret) {
            $json = json_decode($ret, null, 512, JSON_THROW_ON_ERROR);

            // No need to check about response structure as this method is called inside a try catch

            if ($json->success && (int) $json->ip->appears > 0) {   // @phpstan-ignore-line don't bother with response structure here
                return true;
            }
        }

        // return without any value, may be a spam, may be a ham, Stop Forum Spam doesn't know
        return null;
    }
}
