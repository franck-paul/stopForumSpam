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
$this->registerModule(
    'Stop Forum Spam',
    'Stop Forum Spam filter for antispam Dotclear plugin',
    'Franck Paul',
    '6.1',
    [
        'date'        => '2026-02-26T19:16:52+0100',
        'requires'    => [['core', '2.36']],
        'permissions' => 'My',
        'priority'    => 200,
        'type'        => 'plugin',

        'details'    => 'https://open-time.net/?q=stopForumSpam',
        'support'    => 'https://github.com/franck-paul/stopForumSpam',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/stopForumSpam/main/dcstore.xml',
        'license'    => 'gpl2',
    ]
);
