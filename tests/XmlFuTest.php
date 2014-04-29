<?php

class XmlFuTest extends PHPUnit_Framework_TestCase {
    public function testValueReturnsTheDefaultForUnapplicableXpath() {
        $this->assertSame(
            'le default', XmlFu\value(self::xml(), '//that-isnt-there/@really', 'le default'));
    }

    public function testValueReturnsTheFirstMatchingNodesTextAsAString() {
        $this->assertSame('5', XmlFu\value(self::xml(), '/books/book/@rating', 0));
    }

    public function testValueCanDealWithTheDefaultXmlNamespaceDesignatedWithAnUnderscorePrefix() {
        $xml = new \SimpleXMLElement(self::xml());
        $xml['xmlns'] = 'http://tempuri.org/';

        $this->assertSame(
            'Structure and Interpretation of Computer Programs',
            XmlFu\value($xml->asXML(), '/_:books/_:book/_:title', '')
        );
    }

    public function testFirstNodeWorks() {
        $book = XmlFu\firstNode(self::xml(), '//book[@rating = "4"]');
        $this->assertSame('Clean Coder', strval($book->title));
    }

    public function testFirstNodeImplWorks() {
        $book = XmlFu\firstNodeImpl(new \SimpleXMLElement(self::xml()), '//book[@rating = "4"]');
        $this->assertSame('Clean Coder', strval($book->title));
    }

    public function testChunksWorks()
    {
        $this->assertSame(
            array('<year>1984</year>', '<year>1996</year>'),
            XmlFu\chunks(self::xml(), '//book[@rating = "5"]/publication-years/year')
        );
    }

    public function testChunksImplWorks()
    {
        $this->assertSame(
            array('<year>1984</year>', '<year>1996</year>'),

            XmlFu\chunksImpl(
                new \SimpleXMLElement(self::xml()),
                '//book[@rating = "5"]/publication-years/year'
            )
        );
    }

//--------------------------------------------------------------------------------------------------

    private static function xml() {
        return <<<XML
<books>
    <book rating="5">
        <title>Structure and Interpretation of Computer Programs</title>

        <publication-years>
            <year>1984</year>
            <year>1996</year>
        </publication-years>
    </book>

    <book rating="5">
        <title>Refactoring: Improving the Design of Existing Code</title>
    </book>

    <book rating="4">
        <title>Clean Coder</title>
    </book>
</books>
XML;
    }
}