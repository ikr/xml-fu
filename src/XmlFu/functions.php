<?php

namespace XmlFu;

function value($xml, $xpath, $default) {
    return valueImpl(new \SimpleXMLElement($xml), $xpath, $default);
}

function valueImpl($rootElement, $xpath, $default) {
    $namespaces = $rootElement->getNamespaces(true);

    if (isset($namespaces[''])) {
        $rootElement->registerXPathNamespace('_', $namespaces['']);
    }

    $nodes = $rootElement->xpath($xpath);

    if ($nodes) {
        return strval($nodes[0]);
    }

    return $default;
}

function firstNode($xml, $xpath)
{
    return firstNodeImpl(new \SimpleXMLElement($xml), $xpath);
}

function firstNodeImpl($rootElement, $xpath) {
    $namespaces = $rootElement->getNamespaces(true);

    if (isset($namespaces[''])) {
        $rootElement->registerXPathNamespace('_', $namespaces['']);
    }

    $nodes = $rootElement->xpath($xpath);

    if ($nodes) {
        return $nodes[0];
    }
}

function chunks($xml, $xpath)
{
    return chunksImpl(new \SimpleXMLElement($xml), $xpath);
}

function chunksImpl($rootElement, $xpath)
{
    $namespaces = $rootElement->getNamespaces(true);
    $result = array();

    if (isset($namespaces[''])) {
        $rootElement->registerXPathNamespace('_', $namespaces['']);
    }

    foreach ($rootElement->xpath($xpath) as $element) {
        $result[] = $element->asXML();
    }

    return $result;
}

function attrValues($xml, $elementXpath, $attrName)
{
    return attrValuesImpl(new \SimpleXMLElement($xml), $elementXpath, $attrName);
}

function attrValuesImpl($rootElement, $elementXpath, $attrName)
{
    $namespaces = $rootElement->getNamespaces(true);
    $result = array();

    if (isset($namespaces[''])) {
        $rootElement->registerXPathNamespace('_', $namespaces['']);
    }

    foreach ($rootElement->xpath($elementXpath) as $element) {
        $result[] = strval($element[$attrName]);
    }

    return $result;
}

function removeXmlProcessingInstruction($xml) {
    $dom = new \DOMDocument;
    $dom->loadXML($xml);
    return $dom->saveXML($dom->documentElement);
}

function rootTagName($xml) {
    $document = new \DOMDocument;
    $document->loadXML($xml);
    return $document->documentElement->tagName;
}
