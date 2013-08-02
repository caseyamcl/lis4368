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
     * Get the content
     *
     * @return string|null  Null if no content found
     */
    public function getContent($path)
    {
        $fullpath = rtrim($path, '/') . '/'  . $this->pageFile;
        return $this->contentMap->getItem($fullpath) ?: null;
    }
    
    // -------------------------------------------------------------- 

    public function pageExists($path)
    {
        $fullpath = rtrim($path, '/') . '/' . $this->pageFile;
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