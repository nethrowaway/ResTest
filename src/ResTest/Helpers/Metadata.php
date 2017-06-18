<?php
namespace ResTest\Helpers;

class Metadata
{

    public function getMetadataFromUrl($url)
    {
        $doc = new \DOMDocument;
        if (!$doc->loadHTMLFile($url)) {
            return false;
        }

        // set a default title, so we don't get NULL returned in the API for this
        $title = 'Undefined';
        // find title from the dom document
        if ($docTitle = $doc->getElementsByTagName('title')) {
            $title = $docTitle[0]->nodeValue;
        }

        $metaTags = $doc->getElementsByTagName('meta');

        // set a defaults so theres no error later
        $description = $keywords = NULL;
        // find description meta tag
        foreach ($metaTags as $metaTag) {
            if (strtolower($metaTag->getAttribute('name')) == 'description') {
                // set description to the value of description meta tag
                $description = $metaTag->getAttribute('content');
            }
            if (strtolower($metaTag->getAttribute('name')) == 'keywords') {
                // set keywords to the value of keywords meta tag
                $keywords = $metaTag->getAttribute('content');
            }
        }

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords
        ];
    }
}