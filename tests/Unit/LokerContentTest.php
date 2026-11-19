<?php

namespace Tests\Unit;

use App\Support\LokerContent;
use Tests\TestCase;

class LokerContentTest extends TestCase
{
    public function test_editor_entities_are_displayed_as_content(): void
    {
        $content = '<p>Riset &amp; analisis&nbsp;data</p>';
        $legacyContent = '<p>Riset &amp;amp; analisis&amp;nbsp;data</p>';

        $this->assertSame('Riset & analisis data', LokerContent::text($content));
        $this->assertSame('Riset & analisis data', LokerContent::text($legacyContent));
        $this->assertStringContainsString('&amp;', LokerContent::html($content));
        $this->assertStringNotContainsString('&nbsp;', LokerContent::html($content));
        $this->assertStringContainsString("\xC2\xA0", LokerContent::html($content));
    }

    public function test_unsafe_editor_markup_is_removed(): void
    {
        $content = '<p>Aman</p><script>alert(1)</script><p onclick="alert(2)">Teks</p>';

        $html = LokerContent::html($content);

        $this->assertStringNotContainsString('<script', $html);
        $this->assertStringNotContainsString('onclick', $html);
        $this->assertSame('Aman Teks', LokerContent::text($content));
    }
}
