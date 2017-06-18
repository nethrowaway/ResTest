<?php

use PHPUnit\Framework\TestCase;

use ResTest\Helpers\Metadata;

/**
 * @covers Metadata
 */
class MetadataTest extends TestCase
{
    protected function setUp()
    {
        // set error level to suppress warnings about non valid tags
        $internalErrors = libxml_use_internal_errors(true);
    }

    public function providerGetMetadataFromUrl()
    {
        return [
            'testSite' => [
                'input' => [
                    'url' => 'http://www.nick-edwards.co.uk/'
                ],
                'output' => [
                  'title' => 'Nick Edwards | Web Developer',
                  'description' => 'The Web Design and Development portfolio of Nick Edwards. A web developer, mainly working with PHP.',
                  'keywords' => 'Nicholas Edwards, Nick Edwards, NDE Designs, ndedesigns, tsdesigns, twistedspikes, website, web design, web development, PHP, javascript, html, css, server side'
                ]
            ]
        ];
    }

    /**
     * @dataProvider providerGetMetadataFromUrl
     **/
    public function testGetMetadataFromUrl($input, $output)
    {
    	$metadata = new Metadata();
        $this->assertEquals(
            $output,
            $metadata->getMetadataFromUrl($input['url'])
        );
    }

    public function providerGetContentLengthFromUrl()
    {
        return [
            'testSite' => [
                'input' => [
                    'url' => 'http://www.nick-edwards.co.uk/'
                ],
                'output' => 17830
            ]
        ];
    }

    /**
     * @dataProvider providerGetContentLengthFromUrl
     **/
    public function testGetContentLengthFromUrl($input, $output)
    {
    	$metadata = new Metadata();
        $this->assertEquals(
            $output,
            $metadata->getContentLengthFromUrl($input['url'])
        );
    }
}