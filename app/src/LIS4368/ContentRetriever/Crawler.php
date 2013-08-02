<?php

namespace LIS4368\ContentRetriever;
use DirectoryIterator, SplFileInfo, DateTime;

/**
 * Crawls the filesystem and gets sets of metadata for content items
 *
 * Not recursive (optionally fix by changing to RecursiveDirectoryIterator)
 */
class Crawler
{
    /**
     * @var ContentMap $contentMap
     */
    private $contentMap;

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
     * Get Items
     *
     * Crawl the desired path and return the metadata for items
     *
     * @param string $path
     * @param string $sortBy        Or null, for no sorting
     * @param string $metaFileName  Default is meta.yml
     * @return array                Keys are path, values are metadata array
     */
    public function getItems($path, $sortBy = null, $metaFileName = 'meta.yml')
    {
        $iterator = new DirectoryIterator($this->contentMap->resolvePath($path));

        //Output...
        $items = array();

        //Crawl...
        foreach ($iterator as $file) {

            //If directory, process...
            if ($file->isDir()) {
                $itemPath = $this->getPath($file);
                $info     = $this->getInfo($itemPath, $metaFileName);

                //Add...
                if ($info) {
                    $items[$itemPath] = $info;
                }
            }
        }

        //Sort..
        return ($sortBy)
            ? $this->sort($items, $sortBy)
            : $items;
    }

    // --------------------------------------------------------------

    /**
     * Find out the relative path for a file
     *
     * @param  string $file
     * @return string
     */
    private function getPath(SplFileInfo $file)
    {
        $basepath = $this->contentMap->getBasePath();
        return substr($file->getPathname(), strlen($basepath));
    }

    // --------------------------------------------------------------

    /**
     * Get the info for a content item based off its path
     *
     * @param string $path
     * @param string $metaFileName
     * @return array|null  Null if no meta found at that path
     */
    private function getInfo($path, $metaFileName)
    {
        $path = $path . '/' . $metaFileName;
        return $this->contentMap->getYamlItem($path); 
    }

    // --------------------------------------------------------------

    /**
     * Sort the items
     *
     * @param array  $items
     * @param string $sortBy  The field to sort by (can also have ASC or DESC)
     */
    private function sort($items, $sortBy)
    {
        //Sort by has order?
        if (strpos($sortBy, ' ')) {
            list($sortBy, $sortOrder) = explode(' ', $sortBy);
            $sortOrder = strtoupper($sortOrder);
        }
        else {
            $sortOrder = 'ASC';
        }

        //Callback function
        $callback = function($a, $b) use ($sortBy) {

            //Isset?
            if (isset($a[$sortBy]) && ! isset($b[$sortBy])) {
                return -1;
            }
            elseif ( ! isset($a[$sortBy]) && isset($b[$sortBy])) {
                return 1;
            }
            elseif ( ! isset($a[$sortBy]) && ! isset($b[$sortBy])) {
                return 0;
            }

            //Normal
            if ($a[$sortBy] == $b[$sortBy]) {
                return 0;
            }
            else {
                return ($a[$sortBy] > $b[$sortBy]) ? 1 : -1;
            }
        };

        //Do the sort
        uasort($items, $callback);

        //Descending order?
        if ($sortOrder == 'DESC') {
            $items = array_reverse($items);
        }

        //Return 'em
        return $items;
    }
}

/* EOF: Crawler.php */