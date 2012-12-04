<?php

/*
 * This file is part of the SearchEngineCrawler package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 * This work is licensed under a [Creative Commons Attribution-NonCommercial 3.0 Unported License](http://creativecommons.org/licenses/by-nc/3.0/).
 */

namespace SearchEngineCrawler\Engine\Google;

use SearchEngineCrawler\Engine\AbstractEngine;
use SearchEngineCrawler\ResultSet\ResultSet;
use SearchEngineCrawler\ResultSet\Link\ResultSet as LinkSet;
use SearchEngineCrawler\ResultSet\Metadata\ResultSet as MetadataSet;
use SearchEngineCrawler\ResultSet\Page\Container as PageContainer;
use Zend\Stdlib\Exception;

class Video extends AbstractEngine
{
    /**
     * Get links of page results
     * @param $page number of the page
     * @param $options
     * @return PageContainer
     */
    protected function crawlPage($page, array $options = array())
    {
        // create container
        $linkSet = new LinkSet();
        $metadataSet = new MetadataSet();
        $pageContainer = new PageContainer($page);

        // crawl the page
        $crawler = $this->getCrawler();
        $crawler->crawl('googlevideo', $options);
        $source = $crawler->getSource();

        // get links, video only by default
        if(!isset($options['links'])) {
            $options['links'] = array('video');
        }
        foreach($options['links'] as $link) {
            $link = $this->getLink($link);
            $link->source($source)->detect();
            $result = $link->getResults();
            $linkSet->merge($result);
        }
        $linkSet->sort();
        $pageContainer->setLinks($linkSet);

        // get metadatas
        if(isset($options['metadatas'])) {
            foreach($options['metadatas'] as $metadata) {
                $metadata = $this->getMetadata($metadata);
                $metadata->source($source)->find();
                $metadataSet->addMetadata($metadata);
            }
        }
        $pageContainer->setMetadatas($metadataSet);
        return $pageContainer;
    }
}
