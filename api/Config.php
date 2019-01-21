<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2019
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

return [
    'page_access_token' => '<YOUR_PAGE_TOKEN>',
    'verification_token' => '<YOUR_VERIFICATION_TOKEN>',
    'prefix' => '', // e.g: use '!' if you want to use commands like '!help', otherwise set it to blank
    'case_sensitive' => false, // By default, all messages will be converted to lowercase before parsing commands
    'database' => [
        'driver' => 'mysql_pdo', // Available drivers: mysql_pdo, sqlite
        'drivers' => [ // Specific driver settings
            'mysql_pdo' => [
                'host' => 'localhost',
                'dbname' => 'famephp',
                'username' => 'root',
                'password' => ''
            ],
            'sqlite' => [
                'db_location' => 'famephp.db' // Path to the database file
            ]
        ]

    ],
    'debug' => true
];
