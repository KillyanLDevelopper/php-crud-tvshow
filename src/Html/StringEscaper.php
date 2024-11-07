<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    public function escapeString(?string $string): string
    {
        $html = "";
        if ($string) {
            $html =  htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        return $html;
    }
    public function stripTagsAndTrim(?string $text): string
    {
        $res = "";
        if ($text !== null) {
            $res = strip_tags($text);
            $res = trim($res);
        }
        return $res;
    }
}
