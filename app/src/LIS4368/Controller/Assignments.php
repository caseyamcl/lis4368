<?php

namespace LIS4368\Controller;

use LIS4368\CoreController\PagesAndAssets;
use RuntimeException;

/**
 * Course Assignments Controller
 */
class Assignments extends PagesAndAssets
{
    private $assignList;

    // --------------------------------------------------------------

    protected function loadRoutes()
    {
        $this->addRoute('/assignments', 'index');
        $this->addRoute('/assignments/{name}', 'getContent');
    }

    // --------------------------------------------------------------

    public function init()
    {
        parent::init();

        $this->assignList = $this->getLibrary('assignments')->getAssignmentList();
    }

    // --------------------------------------------------------------

    public function index()
    {

        //Setup data
        $data = array('assignments' => $this->assignList);
        return $this->render('pages/assignments', $data);
    }

    // --------------------------------------------------------------

    /** 
     * {@inheritdoc}
     */
    protected function getTemplateName()
    {
        return 'pages/assignment';
    }

    // --------------------------------------------------------------

    /**
     * Render the page using TWIG
     *
     * @param  string $path
     * @return string
     */
    protected function getPageContent($path)
    {
        $this->pageLoader->setPageFileName('overview.html.twig');
        return parent::getPageContent($path);
    }

    // --------------------------------------------------------------

    /** 
     * {@inheritdoc}
     */
    protected function renderPage($path, array $data = array())
    {
        //Get slug from path
        $segs = explode('/', $path);
        $slug = end($segs);

        //Not in assignment list? (404)
        if ( ! isset($this->assignList[$slug])) {
            return $this->abort(404, "Assignment not found.");
        }

        //Augment data
        $data = array_merge(array('due' => $this->assignList[$slug]['due']), $data);

        //Return parent
        return parent::renderPage($path, $data);
    }    
}

/* EOF: Assignments.php */