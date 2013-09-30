<?php

namespace LIS4368\Controller;

use LIS4368\CoreController\PagesAndAssets;

/**
 * Course Resources Controller
 */
class Resources extends PagesAndAssets
{
    protected function loadRoutes()
    {
        $this->addRoute('/resources',        'index');
        $this->addRoute('/resources/{name}', 'getContent');
    }

    // --------------------------------------------------------------

    public function index()
    {
        $loader = $this->getLibrary('content');
        $data   = array('modules' => $loader->getYamlItem('modules/modules.yml'));
        
        return $this->render('pages/resources', $data);
    }

    // --------------------------------------------------------------

    protected function getTemplateName()
    {
        return 'pages/resource';
    }

}

/* EOF: Resources.php */