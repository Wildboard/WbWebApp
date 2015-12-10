<?php defined('SYSPATH') or die('No direct script access.');
return array
(
    'default' => array(
        'type'       => 'mysql',
        'connection' => array(
            'hostname'   => 'db.wildboard.net',
            'username'   => 'wildboard',
            'password'   => 'kaban2013',
            'persistent' => FALSE,
            'database'   => 'oc',
            ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'profiling'    => (Kohana::$environment===Kohana::DEVELOPMENT)? TRUE:FALSE,
     ),
);