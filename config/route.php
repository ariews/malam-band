<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * @author  arie
 */

/* Dashboard Prefix */
$DPRX = Kohana::$config->load('site.dashboard_prefix');

return array(
    // Band --------------------------------------------------------------------
    'band'                  => array(
        'uri_callback'      => 'bands/<action>(/<id>/<slug>)',
        'regex'             => array(
            'id'            => '\d+',
            'slug'          => '[a-zA-Z0-9-_]+',
            'action'        => 'read|index'
        ),
        'defaults'          => array(
            'controller'    => 'band',
            'action'        => 'index',
            'id'            => NULL,
            'slug'          => NULL,
        )
    ),

    'admin-band'            => array(
        'uri_callback'      => $DPRX.'bands/<action>(/<id>)',
        'regex'             => array(
            'action'        => 'index|create|delete|update|read',
            'id'            => '\d+',
        ),
        'defaults'          => array(
            'controller'    => 'band',
            'directory'     => 'admin',
            'action'        => 'index',
            'id'            => NULL,
        )
    ),
);