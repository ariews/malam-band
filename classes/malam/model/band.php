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
     * Enable gallery fot this content
     *
     * @var bool
     */
    protected $_gallery_enable  = TRUE;

    /**
     * "Has many" relationships
     * @var array
     */
    protected $_has_many        = array(
        'genres'         => array(
            'model'         => 'tag',
            'through'       => 'relationship_tags',
            'foreign_key'   => 'object_id',
            'far_key'       => 'tag_id',
            'polymorph'     => TRUE,
            'type'          => 'band'
        ),
        'ringtones'     => array(
            'model'         => 'ringtone',
        ),
    );

    protected $_is_direct_call  = FALSE;

    protected $_featured_enable = TRUE;

    protected $_has_hierarchy   = FALSE;

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

    public function create_or_update(array $data)
    {
        if ($this->tag_enable())
        {
            $genres = ORM::Get_Or_Create_Tag(Arr::get($data, 'join_tags'), 'tag');
        }

        $result = $this->values($data)->save();

        if ($result->saved() && $this->tag_enable() && ! empty($genres))
        {
            $result->remove('genres');
            $this->add('genres', $genres);
        }

        return $result;
    }

    public function __get($column)
    {
        $return = parent::__get($column);

        if ($column == 'ringtones')
        {
            if ($return instanceof Model_Ringtone)
            {
                /* @var $return Model_Ringtone */
                $return->set_band($this);
            }
        }

        return $return;
    }

    protected function prepare_menu()
    {
        $menu = array(
            array(
                'title' => __(ORM::capitalize_title($this->object_name())),
                'url'   => $this->admin_index_url_only(),
            ),
            array(
                'title' => __($this->loaded() ? 'Update' : 'Add'),
                'url'   => $this->loaded()
                            ? $this->admin_update_url_only()
                            : $this->admin_create_url_only()
            ),
        );

        if ($this->loaded())
        {
            $menu[] = array(
                'title' => __('Galleries'),
                'url'   => $this->galleries->admin_index_url_only(),
            );

            $menu[] = array(
                'title' => __('Ringtones'),
                'url'   => $this->ringtones->admin_index_url_only(),
            );
        }

        $this->_admin_menu = $menu;
    }
}
