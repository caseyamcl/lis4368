<?php

namespace LIS4368\Controller;

use LIS4368\CoreController\ControllerAbstract;
/**
 * Syllabus Controller
 */
class Syllabus extends ControllerAbstract
{
    // --------------------------------------------------------------

    protected function init()
    {
        $this->addRoute('/syllabus', 'index');
    }

    // --------------------------------------------------------------

    public function index()
    {
        //View data array
        $data = array();

        //Render the view
        return $this->render('pages/syllabus', $data);
    }

}
/* EOF: Syllabus.php */