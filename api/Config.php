<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

return [
    'page_access_token' => '<YOUR_PAGE_TOKEN>',
    'verification_token' => '<YOUR_VERIFICATION_TOKEN>',
    'prefix' => '', // e.g: use '!' if you want to use commands like '!help', otherwise set it to blank
    'case_sensitive' => false, // By default, all messages will be converted to lowercase before checking for commands
    'database' => [
        'host' => 'localhost',
        'dbname' => 'famephp',
        'username' => 'root',
        'password' => ''
    ],
    'DEBUG' => true
];
?>