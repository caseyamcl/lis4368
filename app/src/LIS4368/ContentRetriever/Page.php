<?php

namespace LIS4368\ContentRetriever;

/**
 * Page loader
 */
class Page
{
    /**
     * @var ContentMap $contentMap
     */
    private $contentMap;

    /**
     * @var string
     */
    private $pageFile = 'content.html.twig';

    /**
     * @var string
     */
    private $metaFile = 'meta.yml';
   
    // --------------------------------------------------------------

    /**
     * Constructor
     *
     * @param contentMap $contentMap
     */
    public function __construct(ContentMap $contentMap)
    {
        $this->contentMap = $contentMap;
    }

    // --------------------------------------------------------------

    /**
     * Change the default filename from content.html.twig to something else
     *
     * @param string $fileName
     */
    public function setPageFileName($fileName)
    {
        $this->pageFile = $fileName;
    }

    // --------------------------------------------------------------

    /**
     * Get the content
     *
     * @param  string  $path      Path to content
     * @param  string  $pageFile  The filename of the content page (or null for default)
     * @return string|null  Null if no content found
     */
    public function getContent($path, $pageFile = null)
    {
        $fullpath = rtrim($path, '/') . '/'  . ($pageFile ?: $this->pageFile);
        return $this->contentMap->getItem($fullpath) ?: null;
    }
    
    // -------------------------------------------------------------- 

    /**
     * Get if a page exists
     *
     * @param  string  $path      Path to content
     * @param  string  $pageFile  The filename of the content page (or null for default)
     * @return boolean
     */
    public function pageExists($path, $pageFile = null)
    {
        $fullpath = rtrim($path, '/') . '/' . ($pageFile ?: $this->pageFile);
        return (boolean) $this->contentMap->checkItemExists($fullpath);
    }

    // -------------------------------------------------------------- 

    /**
     * Get the meta for this content
     *
     * @param  string      $path
     * @return array|null  Empty array if no meta; null if content doesn't exist
     */
    public function getMeta($path)
    {
        $fullpath = rtrim($path, '/') . '/'  . $this->metaFile;
        $yaml = $this->contentMap->getYamlItem($fullpath);

        if ($yaml) {
            return $yaml;
        }
        else {
            return ($this->pageExists($path)) ? array() : null;
        }
    }
}

/* EOF: Page.php */