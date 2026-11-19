<?php

namespace App\Support;

use Stevebauman\Purify\Facades\Purify;

final class LokerContent
{
    public static function html($value): string
    {
        if (! filled($value)) {
            return '';
        }

        $value = html_entity_decode((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return Purify::clean($value);
    }

    public static function text($value): string
    {
        $html = preg_replace(
            '/<\/?(?:p|br|li|blockquote|h[1-6]|ul|ol)(?:\s[^>]*)?>/i',
            ' ',
            self::html($value)
        );
        $text = strip_tags((string) $html);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\xC2\xA0", ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim((string) $text);
    }
}
