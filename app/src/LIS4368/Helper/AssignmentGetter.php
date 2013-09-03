<?php

namespace LIS4368\Helper;

use LIS4368\ContentRetriever\ContentMap;
use LIS4368\ContentRetriever\Crawler;
use LIS4368\ContentRetriever\Page;

/**
 * Compile assignment information for different controllers
 */
class AssignmentGetter
{
    private $content;

    private $crawler;

    private $pageLoader;

    private $assignList = false;

    public function __construct(ContentMap $content, Crawler $crawler, Page $pageLoader)
    {
        $this->content    = $content;
        $this->crawler    = $crawler;
        $this->pageLoader = $pageLoader;
    }

    public function getAssignmentList()
    {
        //Only do this once
        if ($this->assignList === false) {

            $modules = $this->content->getYamlItem('modules/modules.yml');
            $assigns = $this->crawler->getItems('assignments');

            foreach ($modules as $module) {
                
                if (isset($module['assignments'])) {
                    foreach((array) $module['assignments'] as $assign) {
                        
                        if ( ! isset($assigns['assignments/' . $assign['slug']])) {
                            throw new RuntimeException("Assignment not found: " . $assign['slug']);
                        }

                        $this->assignList[$assign['slug']] = array_merge(
                            array('overview' => $this->pageLoader->getContent('assignments/' . $assign['slug'])),
                            $assigns['assignments/' . $assign['slug']],
                            $assign
                        );
                    }
                }
            }
        }

        return $this->assignList;
    }

    public function getAssignment($slug)
    {
        return $this->assignList[$slug];
    }
}

/* EOF: AssignmentGetter.php */