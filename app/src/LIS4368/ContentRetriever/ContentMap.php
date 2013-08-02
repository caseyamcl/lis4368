<?php

namespace LIS4368\ContentRetriever;
use Symfony\Component\Yaml\Yaml;
use RuntimeException;

/**
 * Content Map Class
 */
class ContentMap
{
    /**
     * @var string
     */
    private $basepath;

    /**
     * @var Symfony\Component\Yaml\Yaml;
     */
    private $yamlParser;

    // --------------------------------------------------------------

    /**
     * Constructor
     *
     * @param string                      $basepath
     * @param Symfony\Component\Yaml\Yaml $parser
     */
    public function __construct($basepath, Yaml $parser)
    {
        if ( ! is_readable($basepath)) {
            throw new RuntimeException('Could not read basepath');
        }

        $this->basepath   = realpath($basepath) . DIRECTORY_SEPARATOR;
        $this->yamlParser = $parser;
    }

    // -------------------------------------------------------------- 

    /**
     * Get the basepath
     */
    public function getBasePath()
    {
        return $this->basepath;
    }

    // -------------------------------------------------------------- 

    /**
     * Check if item exists
     *
     * @param string $path
     * @return boolean
     */
    public function checkItemExists($path)
    {
        return (boolean) $this->resolvePath($path);
    }

    // -------------------------------------------------------------- 

    /**
     * Get an item
     *
     * @param string $path
     * @return string|boolean
     */
    public function getItem($path)
    {
        $fullpath = $this->resolvePath($path);
        return ($fullpath) ? file_get_contents($fullpath) : false;
    }

    // --------------------------------------------------------------

    /**
     * Get a YAML Item
     *
     * @param string $path
     * @return string|boolean
     */
    public function getYamlItem($path)
    {
        $rawYaml = $this->getItem($path);

        return ($rawYaml)
            ? $this->yamlParser->parse($rawYaml)
            : false;
    }

    // -------------------------------------------------------------- 

    /**
     * Stream an item.  To be used as a callback most of the time
     *
     * @param string $path
     * @return void  Will echo contents of item
     */
    public function streamItem($path)
    {
        $fullpath = $this->resolvePath($path);

        if ($fullpath) {
            readfile($fullpath);
        }
        else {
            echo '';
        }
    }

    // --------------------------------------------------------------

    /**
     * Resolve the full path of an item
     *
     * @param  string $path  Path to content
     * @return string|boolean
     */
    public function resolvePath($path)
    {
        $path = $this->basepath . trim($path, DIRECTORY_SEPARATOR);
        return (is_readable($path)) ? $path : false;
    }
}

/* EOF: Page.php */