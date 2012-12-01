<?php

namespace SearchEngineCrawler\Engine\Link\Google\Web;

use SearchEngineCrawler\Engine\Link\AbstractLink;
use SearchEngineCrawler\Engine\Link\Features;

class Product extends AbstractLink implements Features\NodeLinkProviderInterface,
    Features\NodeLinkAnchorProviderInterface
{
    /**
     * Result class container
     * @var string
     */
    protected $resultClass = 'SearchEngineCrawler\ResultSet\Link\Result\Product';

    /**
     * Get the node list, each node contains
     * the ad & line number
     * @return Zend\Dom\NodeList
     */
    public function getNodeList()
    {
        return $this->xpath('//div[@id="ires"]//li[@id="productbox"]//td[@class="pcr"]/div');
    }

    /**
     * Check if a node is valid, if the node match with the type required
     * If node is valid, return the node
     * @param \DOMElement $node node to validate
     * @return null|\DOMElement
     */
    public function validateNode(\DOMElement $node)
    {
        $nodePath = $node->getNodePath();
        $nodePath .= '/a';
        return $this->xpath($nodePath)->current();
    }

    /**
     * Get the link
     * @param \DOMElement $node
     * @return integer the line number
     */
    public function getNodeLink(\DOMElement $node)
    {
        $node = $this->validateNode($node);
        return $node->getAttribute('href');
    }

    /**
     * Get the link anchor
     * @param \DOMElement $node
     * @return integer the line number
     */
    public function getNodeLinkAnchor(\DOMElement $node)
    {
        $node = $this->validateNode($node);
        return $node->textContent;
    }
}
