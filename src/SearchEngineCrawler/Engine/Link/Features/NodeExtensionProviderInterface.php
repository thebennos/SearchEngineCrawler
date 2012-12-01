<?php

namespace SearchEngineCrawler\Engine\Link\Features;

interface NodeExtensionProviderInterface
{
    /**
     * Get extension from a link
     * @param \DOMElement $node
     * @return Extension
     */
    public function getExtension(\DOMElement $node);
}