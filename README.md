[![Build Status](https://travis-ci.org/ikr/xml-fu.svg?branch=master)](https://travis-ci.org/ikr/xml-fu)

# About

Handy utility functions to query XML. Was initially written to simplify dealing with raw SOAP
responses, but can also be useful in general, enabling a more _functinal_ style of extracting data
from XML.

# Installation

Requires PHP 5.3+ and [Composer](https://getcomposer.org/).

    composer require ikr/xml-fu:~1.1

# API

## Core

    XmlFu\value($xml, $xpath, $default)

Searches the `$xml` string for the first node matching the given `$xpath`, and returns its string
value. If the node wasn't found, the `$default` value is returned.

    XmlFu\firstNode($xml, $xpath)

Returns a `SimpleXMLElement` instance for the first node matching the given `$xpath` in the given
`$xml` string.

    XmlFu\chunks($xml, $xpath)

Finds all the nodes in the passed `$xml` string matching the given `$xpath`, and returns an array of
their `asXML()` serializations -- strings.

    XmlFu\attrValues($xml, $elementXpath, $attrName)

Finds all the elements in the passed `$xml` string matching the given `$elementXpath`, and returns
an array of their `$attrName` attribute values -- one string value per element.

## Core without parsing

There are `*Impl` versions of the core functions, accepting `$rootElement`-s -- `SimpleXMLElement`
instances instead of the `$xml` strings.

    XmlFu\valueImpl($rootElement, $xpath, $default)
    XmlFu\firstNodeImpl($rootElement, $xpath)
    XmlFu\chunksImpl($rootElement, $xpath)
    XmlFu\attrValuesImpl($rootElement, $elementXpath, $attrName)

That way you can avoid unnecessary multiple parsing runs when querying for multiple values.

## Dealing with the default namespace

`SimpleXMLElement::xpath()` have some quirks dealing with the default XML namespace declaration: the
`xmlns="..."` attribute. As soon as it's present, all the nodes contained by the element with
`xmlns` declared, and the declaring element itself must be prefixed with a namespace in XPath
queries. XmlFu conveniently aliases the default namespace with underscore -- `_`

Thus,

    $xml = <<<XML
        <OTA_PingRS xmlns="http://www.opentravel.org/OTA/2003/05">
            <Success />
            <EchoData>Hey!</EchoData>
        </OTA_PingRS>    
    XML;

    echo XmlFu\value($xml, '//_:EchoData', null); // 'Hey!'
    
## Extras

    XmlFu\removeXmlProcessingInstruction($xml)

Removes the `<?xml ...` declaration from the passed `$xml` string. The removal is done in a safe
way: no reg-exps, honest parsing.

    XmlFu\rootTagName($xml)

The name of the topmost XML element in the passed `$xml` string.

# Development status

Used in production.
