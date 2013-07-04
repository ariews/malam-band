<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * @author  arie
 */

$b  = ORM::factory('band');

return array(
    'admin' => array(
        // ADMIN-BAND
        3 => array(
            'title'     => __('Artist'),
            'url'       => $b->admin_index_url_only(),
        ),
    ),

    'guest' => array(
        2 => array(
            'title'     => __('Artist'),
            'url'       => $b->index_url_only(),
        ),
    ),
);