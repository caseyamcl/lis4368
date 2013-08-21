<?php

namespace LIS4368\Controller;

use LIS4368\CoreController\ControllerAbstract;

/**
 * Calendar Controller
 */
class Front extends ControllerAbstract
{
    // --------------------------------------------------------------

    protected function init()
    {
        $this->addRoute('/', 'index');
    }

    // --------------------------------------------------------------

    public function index()
    {
        //View data array
        $data = array();

        //Render the view
        return $this->render('pages/front', $data);
    }

}

/* EOF: Front.php */