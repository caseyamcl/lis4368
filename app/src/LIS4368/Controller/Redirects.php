<?php

namespace LIS4368\Controller;

use RuntimeException;

class Redirects extends ControllerAbstract
{
    /**
     * @var array  Keys are original path; values are new path
     */
    private $redirects;

    // --------------------------------------------------------------

    protected function init()
    {
        //Get the content mapper
        $content = $this->getLibrary('content');

        //Read redirects YAML file
        $redirects = $content->getYamlItem('redirects.yml');

        //Foreach redirect, add to the array
        if (is_array($redirects)) {

            foreach($redirects as $rd) {

                if ($rd['old']) {

                    $this->redirects[$rd['old']] = $rd['new'];
                    $this->addRoute($rd['old'], 'doRedirect');
                }
            }
        }
    }

    // --------------------------------------------------------------

    public function doRedirect()
    {
        //Get the requested path
        $path = $this->getPath();

        //Get the redirect path
        $redirectPath = $this->redirects[$path];

        //Do the redirect
        return $this->redirect($redirectPath);
    }
}

/* EOF: Redirects.php */