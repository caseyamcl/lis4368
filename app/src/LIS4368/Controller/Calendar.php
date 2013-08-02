<?php

namespace LIS4368\Controller;

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