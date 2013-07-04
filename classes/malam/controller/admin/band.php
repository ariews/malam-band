<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * @author  arie
 */

abstract class Malam_Controller_Admin_Band extends Controller_Abstract_Bigcontent
{
    /**
     * Band
     *
     * @var Model_News
     */
    protected $model            = 'band';

    public function action_index()
    {
        $this->title('Artist index');
    }

    public function action_create()
    {
        $this->title('Create Artist');
    }

    public function action_update()
    {
        $this->title('Update Artist');
    }

    public function action_delete()
    {
        $this->title('Delete Artist');
    }
}