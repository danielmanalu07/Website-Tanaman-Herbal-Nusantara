<?php
namespace App\Helpers;

use DOMDocument;

class TranslateHtmlContent
{
    function translateHtmlContent($html, $translator, $detectedLang, $targetLang)
    {
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

        $translator->setSource($detectedLang);
        $translator->setTarget($targetLang);

        $body = $dom->getElementsByTagName('body')->item(0);
        if ($body) {
            $this->translateDomTextNodes($body, $translator);
        }

        $translatedHtml = $dom->saveHTML($body);
        $translatedHtml = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $translatedHtml);
        return $translatedHtml;
    }

    function translateDomTextNodes($node, $translator)
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeType == XML_TEXT_NODE) {
                $text = trim($child->nodeValue);
                if (! empty($text)) {
                    try {
                        $translatedText   = $translator->translate($text);
                        $child->nodeValue = $translatedText;
                    } catch (\Exception $e) {
                        $child->nodeValue = $text;
                    }
                }
            } elseif ($child->hasChildNodes()) {
                $this->translateDomTextNodes($child, $translator);
            }
        }
    }

}
