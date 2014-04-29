[![Build Status](https://travis-ci.org/ikr/xml-fu.svg?branch=master)](https://travis-ci.org/ikr/xml-fu)

# About

Handy utility functions to query XML. Was initially written to simplify dealing with raw SOAP
responses, but can also be useful in general, enabling a more _functinal_ style of extracting data
from XML.

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

## Core without parsing

There are `*Impl` versions of the core functions, accepting `SimpleXMLElement` instances instead of
the `$xml` strings.

    XmlFu\valueImpl($rootElement, $xpath, $default)
    XmlFu\firstNodeImpl($rootElement, $xpath)
    XmlFu\chunksImpl($rootElement, $xpath)

That way you can avoid unnecessary multiple parsing runs when querying for multiple values.
    
## Extras

    XmlFu\removeXmlProcessingInstruction($xml)

Removes the `<?xml ...` declaration from the passed `$xml` string. The removal is done in a safe
way: no reg-exps, honest parsing.

    XmlFu\rootTagName($xml)

The name of the topmost XML element in the passed `$xml` string.

# Development status

Used in production.
