<?php

namespace LIS4368\Controller;

use LIS4368\CoreController\PagesAndAssets;

/**
 * Course Calendar Controller
 */
class Calendar extends PagesAndAssets
{
    protected function loadRoutes()
    {
        $this->addRoute('/calendar', 'index');
    }

    // --------------------------------------------------------------

    public function index()
    {
        $loader = $this->getLibrary('content');
        $data   = array('modules' => $loader->getYamlItem('modules/modules.yml'));
        return $this->render('pages/calendar', $data);
    }
}

/* EOF: Calendar.php */