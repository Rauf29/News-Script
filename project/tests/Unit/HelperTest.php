<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    // ---- slug_create() ----

    public function test_slug_create_replaces_spaces_with_hyphens()
    {
        $this->assertEquals('hello-world', slug_create('hello world'));
    }

    public function test_slug_create_trims_whitespace()
    {
        $this->assertEquals('hello-world', slug_create('  hello world  '));
    }

    public function test_slug_create_collapses_multiple_spaces()
    {
        $this->assertEquals('hello-world', slug_create('hello   world'));
    }

    public function test_slug_create_preserves_existing_hyphens()
    {
        $this->assertEquals('hello-world-test', slug_create('hello-world test'));
    }

    public function test_slug_create_handles_unicode_characters()
    {
        $this->assertEquals('héllo-wörld', slug_create('héllo wörld'));
    }

    public function test_slug_create_handles_empty_string()
    {
        $this->assertEquals('', slug_create(''));
    }

    public function test_slug_create_handles_only_whitespace()
    {
        $this->assertEquals('', slug_create('   '));
    }

    public function test_slug_create_handles_single_word()
    {
        $this->assertEquals('hello', slug_create('hello'));
    }

    public function test_slug_create_handles_tabs_and_newlines()
    {
        $this->assertEquals('hello-world', slug_create("hello\tworld"));
    }

    public function test_slug_create_handles_leading_trailing_hyphens()
    {
        $this->assertEquals('hello-world', slug_create(' hello world '));
    }

    // ---- convertUtf8() ----

    public function test_convertUtf8_returns_same_for_utf8_string()
    {
        $this->assertSame('hello', convertUtf8('hello'));
    }

    public function test_convertUtf8_handles_utf8_characters()
    {
        $input = 'Hëllö Wörld 中文 日本語';
        $this->assertSame($input, convertUtf8($input));
    }

    public function test_convertUtf8_converts_non_utf8_to_utf8()
    {
        $nonUtf8 = "\xE9\x74\xE9"; // ISO-8859-1 bytes that are invalid UTF-8
        $result = convertUtf8($nonUtf8);
        $this->assertNotNull($result);
        $this->assertIsString($result);
    }

    public function test_convertUtf8_handles_empty_string()
    {
        $this->assertSame('', convertUtf8(''));
    }

    public function test_convertUtf8_preserves_numeric_string()
    {
        $this->assertSame('12345', convertUtf8('12345'));
    }

    public function test_convertUtf8_preserves_special_characters()
    {
        $input = '!@#$%^&*()_+-=[]{}|;:,.<>?';
        $this->assertSame($input, convertUtf8($input));
    }

    // ---- function existence checks ----

    public function test_slug_create_function_exists()
    {
        $this->assertTrue(function_exists('slug_create'));
    }

    public function test_convertUtf8_function_exists()
    {
        $this->assertTrue(function_exists('convertUtf8'));
    }

    public function test_advertisement_function_exists()
    {
        $this->assertTrue(function_exists('advertisement'));
    }

    public function test_sidebar_banner_function_exists()
    {
        $this->assertTrue(function_exists('sidebar_banner'));
    }

    public function test_sponsor_banner_function_exists()
    {
        $this->assertTrue(function_exists('sponsor_banner'));
    }

    public function test_header_ads_function_exists()
    {
        $this->assertTrue(function_exists('header_ads'));
    }

    public function test_d_logo_function_exists()
    {
        $this->assertTrue(function_exists('d_logo'));
    }
}
