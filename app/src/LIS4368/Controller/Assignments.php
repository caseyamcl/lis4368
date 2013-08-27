<?php

namespace LIS4368\Controller;

use LIS4368\CoreController\PagesAndAssets;

/**
 * Course Assignments Controller
 */
class Assignments extends PagesAndAssets
{
    protected function loadRoutes()
    {
        $this->addRoute('/assignments', 'index');
    }

    // --------------------------------------------------------------

    public function index()
    {
        $data = array();
        return $this->render('pages/assignments', $data);
    }
}

/* EOF: Assignments.php */