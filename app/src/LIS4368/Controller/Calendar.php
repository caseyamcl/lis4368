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
        $loader  = $this->getLibrary('content');
        $assign  = $this->getLibrary('assignments');

        $modules = $loader->getYamlItem('modules/modules.yml');
        foreach($modules as $mk => $module) {
            if (isset($module['assignments'])) {
                foreach($module['assignments'] as $ak => $as) {
                    $modules[$mk]['assignments'][$ak] = $assign->getAssignment($as['slug']);
                }
            }
        }

        $data   = array('modules' => $modules);
        return $this->render('pages/calendar', $data);
    }
}

/* EOF: Calendar.php */