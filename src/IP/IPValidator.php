<?php

namespace Anax\IP;

/**
 * Filter and format text content.
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 * @SuppressWarnings(PHPMD.StaticAccess)
*/
class IPValidator
{
    /**
     * @var array $filters Supported filters with method names of
     *                     their respective handler.
     */
//     private $filters = [
//         "bbcode"    => "bbcode2html",
//         "link"      => "makeClickable",
//         "markdown"  => "markdown",
//         "nl2br"     => "nl2br",
//         "esc"       => "htmlentities",
//         "strip"     => "striptags",
//     ];

    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function validateIPv4($inputIP)
    {
        $valid = false;

        if (filter_var($inputIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function validateIPv6($inputIP)
    {
        $valid = false;

        if (filter_var($inputIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function checkDomain($inputIP)
    {
        $result = false;
        $domain = null;

        $validIP = $this->validateIPv4($inputIP);
        if ($validIP) {
            $domain = gethostbyaddr($inputIP);
        }
        if ($domain != $inputIP) {
            $result = $domain;
        }

        return $result;
    }

//     /**
//      * Call each filter on the text and return the processed text.
//      *
//      * @param string $text   The text to filter.
//      * @param array  $filter Array of filters to use.
//      *
//      * @return string with the formatted text.
//      */
//     public function parse($text, $filter)
//     {
//         foreach ($filter as $key) {
//             $handler = $this->filters[$key];
//             $text = $this->$handler($text);
//         }
//         return $text;
//     }
//
//
//
//     /**
//      * Helper, BBCode formatting converting to HTML.
//      *
//      * @param string $text The text to be converted.
//      *
//      * @return string the formatted text.
//      */
//     public function bbcode2html($text)
//     {
//         $search = [
//             '/\[b\](.*?)\[\/b\]/is',
//             '/\[i\](.*?)\[\/i\]/is',
//             '/\[u\](.*?)\[\/u\]/is',
//             '/\[img\](https?.*?)\[\/img\]/is',
//             '/\[url\](https?.*?)\[\/url\]/is',
//             '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
//         ];
//
//         $replace = [
//             '<strong>$1</strong>',
//             '<em>$1</em>',
//             '<u>$1</u>',
//             '<img src="$1" />',
//             '<a href="$1">$1</a>',
//             '<a href="$1">$2</a>'
//         ];
//
//         return preg_replace($search, $replace, $text);
//     }
//
//
//
//     /**
//      * Make clickable links from URLs in text.
//      *
//      * @param string $text The text that should be formatted.
//      *
//      * @return string with formatted anchors.
//      */
//     public function makeClickable($text)
//     {
//         return preg_replace_callback(
//             '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
//             function ($matches) {
//                 return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";
//             },
//             $text
//         );
//     }
//
//
//
//     /**
//      * Format text according to Markdown syntax.
//      *
//      * @param string $text The text that should be formatted.
//      *
//      * @return string as the formatted html text.
//      */
//     public function markdown($text)
//     {
//         return MarkdownExtra::defaultTransform($text);
//     }
//
//
//
//     /**
//      * For convenience access to nl2br formatting of text.
//      *
//      * @param string $text The text that should be formatted.
//      *
//      * @return string the formatted text.
//      */
//     public function nl2br($text)
//     {
//         return nl2br($text);
//     }
//
//     /**
//      * For convenience access to htmlentities formatting of text.
//      *
//      * @param string $text The text that should be formatted.
//      *
//      * @return string the formatted text.
//      */
//     public function htmlentities($text)
//     {
//         return htmlentities($text);
//     }
//
//     /**
//      * For convenience access to strip_tags formatting of text.
//      *
//      * @param string $text The text that should be formatted.
//      *
//      * @return string the formatted text.
//      */
//     public function striptags($text)
//     {
//         return strip_tags($text, "<html><body><b><br><em><hr>"
//         . "<i><li><ol><p><s><span><table><tr><td><u><ul><a><h1>"
//         ."<h2><h3><h4><blockquote><strong><thead><tbody><img>");
//     }
}
