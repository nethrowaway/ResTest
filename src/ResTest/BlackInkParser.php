<?php
namespace ResTest;

class BlackInkParser
{
    const BLACKINK_URL = 'https://www.black-ink.org/';
    protected $metadataHelper;
    private $totalSize = 0;

    public function __construct($metadataHelper)
    {
        $this->metadataHelper = $metadataHelper;
    }

    public function parseLinksInCategory($categoryName)
    {
        $urls = $this->findUrlsInCategory($categoryName);
        $results = $this->parseUrls($urls);
        $response = [
            'results' => $results,
            'total' => number_format($this->totalSize/1024, 1) . 'kb'
        ];
        return json_encode($response);
    }

    private function findUrlsInCategory($categoryName)
    {
        // load the website with DOMDocument
        $doc = new \DOMDocument();
        if (!$doc->loadHTMLFile(self::BLACKINK_URL)) {
            throw new Exception('Website not loaded: ' . self::BLACKINK_URL);
        }

        // use xpath to naviagte HTML and parse content
        $xpath = new \DomXpath($doc);
        $urls = [];
        $count=0;
        foreach ($xpath->query('//article') as $article) {
            foreach ($xpath->query('.//a[@rel="tag"]', $article) as $tag) {
                if (strtolower($tag->nodeValue) == strtolower($categoryName)) {
                    // we now know this article is in the correct category
                    // find all links within this article
                    foreach ($xpath->query('.//div[@class="entry-summary"]//a', $article) as $link) {
                        $urls[] = $link->getAttribute('href');
                    }
                }
            }
        }

        return $urls;
    }

    private function parseUrls($urls)
    {
        $response = NULL;
        foreach ($urls as $url) {
            $metadata = $this->metadataHelper->getMetadataFromUrl($url);
            // if no metadata is available, the url errored out for some reason
            // possible improvement would be to add better error reporting
            if ($metadata) {
                $size = $this->metadataHelper->getContentLengthFromUrl($url);
                $this->totalSize += $size;
                $response[] = [
                    'url' => $url,
                    'title' => $metadata['title'],
                    'description' => $metadata['description'],
                    'keywords' => $metadata['keywords'],
                    'filesize' => number_format($size/1024, 1) . 'kb'
                ];
            }
        }

        return $response;
    }

}