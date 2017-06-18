<?php

use PHPUnit\Framework\TestCase;

use ResTest\Helpers\Metadata;

use ResTest\BlackInkParser;

/**
 * @covers BlackInkParser
 */
class BlackInkParserTest extends TestCase
{
    protected function setUp()
    {
        // set error level to suppress warnings about non valid tags
        $internalErrors = libxml_use_internal_errors(true);
    }

    public function providerParseLinksInCategory()
    {
        return [
            'testSite' => [
                'input' => [
                    'category' => 'Digitalia',
                    'url' => dirname(__DIR__) . '/ResTest/mockData/blackInk.html',
                    'metadataMock' => [
                         'title' => 'mockTitile',
                         'description' => 'mockDescription',
                         'keywords' => 'mockKeywords'
                     ]
                ],
                'output' => '{"results":[{"url":"http:\\/\\/games.fire-hazard.net\\/blogposts\\/2016\\/7\\/29\\/how-we-work-energy","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"https:\\/\\/jsonfeed.org\\/2017\\/05\\/17\\/announcing_json_feed","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"https:\\/\\/medium.com\\/@nalsa\\/send-the-grandmother-to-the-library-4e80df44eb1e","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"https:\\/\\/github.com\\/Sopamo\\/vue-online","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"http:\\/\\/cornellsun.com\\/2017\\/01\\/03\\/the-james-bond-of-philanthropy-culminates-career-with-7m-donation-to-c-u\\/","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"http:\\/\\/www.salimvirani.com\\/facebook\\/","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"https:\\/\\/edwardtufte.github.io\\/tufte-css\\/","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"http:\\/\\/killingjokescript.tumblr.com\\/","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"https:\\/\\/quickleft.com\\/blog\\/making-your-app-work-offline-tips-and-cautionary-tales\\/","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"http:\\/\\/www.macrumors.com\\/2016\\/10\\/20\\/ibm-macs-less-expensive-than-pcs\\/","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"http:\\/\\/mjtsai.com\\/blog\\/2016\\/09\\/26\\/mac-terminal-tips\\/","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"http:\\/\\/www.standard.co.uk\\/news\\/london\\/revealed-apple-to-create-stunning-new-hq-at-battersea-power-station-a3356201.html","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"},{"url":"https:\\/\\/github.com\\/pascalopitz\\/beanstalk-dashboard-for-chrome","title":"mockTitile","description":"mockDescription","keywords":"mockKeywords","filesize":"1.0kb"}],"total":"12.7kb"}'
            ]
        ];
    }

    /**
     * @dataProvider providerParseLinksInCategory
     **/
    public function testParseLinksInCategory($input, $output)
    {
        $metadataHelper = $this->createMock(Metadata::class);
        $metadataHelper->method('getContentLengthFromUrl')
             ->willReturn(1000);
        $metadataHelper->method('getMetadataFromUrl')
             ->willReturn($input['metadataMock']);

        $blackInkParser = new BlackInkParser($metadataHelper, $input['url']);
        $this->assertEquals(
            $output,
            $blackInkParser->parseLinksInCategory($input['category'])
        );
    }
}