<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * @author  arie
 */

abstract class Malam_Model_Band extends Model_Bigcontent
{
    /**
     * Admin route name
     * @var string
     */
    protected $_admin_route_name = 'admin-band';

    /**
     * Route name
     * @var string
     */
    protected $_route_name      = 'band';

    /**
     * "Has many" relationships
     * @var array
     */
    protected $_has_many        = array(
        'genre'         => array(
            'model'         => 'tag',
            'through'       => 'relationship_tags',
            'foreign_key'   => 'object_id',
            'far_key'       => 'tag_id',
            'polymorph'     => TRUE,
            'type'          => 'band'
        ),
    );

    protected $_is_direct_call  = FALSE;

    protected $_featured_enable = TRUE;

    public function to_paginate()
    {
        return Paginate::factory($this)
            ->sort('created_at', Paginate::SORT_DESC)
            ->columns(array($this->primary_key(), 'artist', 'content', 'state'))
            ->search_columns(array('title', 'content'));
    }

    public function get_field($field)
    {
        switch (strtolower($field)):
            case 'artist':
                return $this->admin_update_url($this->name());
                break;

            case 'content':
                return $this->content_as_featured_text();
                break;

            default :
                return parent::get_field($field);
                break;
        endswitch;
    }
}