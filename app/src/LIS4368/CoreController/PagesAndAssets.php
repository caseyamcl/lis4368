<?php

namespace LIS4368\CoreController;

/**
 * Content Controller is the default controller for all content
 */
class PagesAndAssets extends ControllerAbstract
{
    /**
     * @var LIS4368\ContentRetriever\Page
     */
    protected $pageLoader;

    /**
     * @var LIS4368\ContentRetriever\Page
     */
    protected $assetLoader;

    // --------------------------------------------------------------
 
    /**
     * Initialize
     */
    public function init()
    {
        //Load routes
        $this->loadRoutes();

        //Load resources
        $this->pageLoader  = $this->getLibrary('pages');
        $this->assetLoader = $this->getLibrary('assets');  
    }

    // --------------------------------------------------------------

    /**
     * Load routes 
     *
     * Match all routes that aren't the front page or haven't already been defined by
     * other controllers.
     */
    protected function loadRoutes()
    {
        $this->routes->match('{url}', array($this, 'getContent'))->assert('url', '.+');
    }

    // --------------------------------------------------------------

    /** 
     * Get the template Name
     *
     * @return string
     */
    protected function getTemplateName()
    {
        return 'pages/general';
    }

    // --------------------------------------------------------------

    /**
     * Default route for everything
     */
    public function getContent()
    {
        //Get the page from the path
        $path = ltrim($this->getPath(), '/');

        //Is content a page?  Great - Load page
        if ($this->pageLoader->pageExists($path)) {
            return $this->renderPage($path);
        }

        //Is content an asset?  Stream that shtuff
        elseif ($this->assetLoader->assetExists($path)) {
            return $this->loadAsset($path);
        }

        //Else, 404
        else {
            return $this->abort(404, 'Content not found');
        }
    }

    // --------------------------------------------------------------

    /**
     * Load a page
     *
     * @param string $path
     * @param string $data
     * @param string $template
     */
    protected function renderPage($path, array $data = array())
    {
        $data = array_merge(array(
            'content'  => $this->getPageContent($path),
            'page_url' => $this->getCurrentUrl()
        ), $data);

        //Also get page data
        $data = array_merge($data, $this->getMeta($path));

        //Load it
        return $this->render($this->getTemplateName(), $data);
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
        $raw  = $this->pageLoader->getContent($path);
        $data = array('page_url' => $this->getCurrentUrl());

        if ($path) {
            return $this->renderString($raw, $data);
        }
        else {
            return null;
        }
    }

    // --------------------------------------------------------------

    /**
     * Get meta-data for the page
     *
     * Meant to be overridden depending on the page type
     *
     * @param  string 
     * @return array
     */
    protected function getMeta($path)
    {
        return $this->pageLoader->getMeta($path);
    }

    // --------------------------------------------------------------

    /**
     * Load an asset
     *
     * @param string $path
     */
    protected function loadAsset($path)
    {
        $assetLoader = $this->assetLoader;
        $callback = function() use ($assetLoader, $path) {
            $assetLoader->streamAsset($path);
        };

        $mime  = $this->assetLoader->getMime($path);
        return $this->stream($callback, $mime);
    }
}

/* EOF: General.php */