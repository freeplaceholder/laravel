<?php

use FreePlaceholder\FreePlaceholderManager;
use FreePlaceholder\FreePlaceholderServiceProvider;
use Illuminate\Support\Facades\Blade;

describe('FreePlaceholderServiceProvider', function () {
    it('registers the FreePlaceholderManager singleton', function () {
        $manager = app(FreePlaceholderManager::class);
        expect($manager)->toBeInstanceOf(FreePlaceholderManager::class);
    });

    it('registers the same singleton instance', function () {
        $a = app(FreePlaceholderManager::class);
        $b = app(FreePlaceholderManager::class);
        expect($a)->toBe($b);
    });

    it('registers the placeholder Blade directive', function () {
        $customDirectives = Blade::getCustomDirectives();
        expect($customDirectives)->toHaveKey('placeholder');
    });

    it('registers the avatar Blade directive', function () {
        $customDirectives = Blade::getCustomDirectives();
        expect($customDirectives)->toHaveKey('avatar');
    });

    it('placeholder directive compiles to PHP', function () {
        $customDirectives = Blade::getCustomDirectives();
        $compiled = $customDirectives['placeholder']('300, 300');
        expect($compiled)->toContain('renderPlaceholderDirective');
        expect($compiled)->toContain('<?php echo');
    });

    it('avatar directive compiles to PHP', function () {
        $customDirectives = Blade::getCustomDirectives();
        $compiled = $customDirectives['avatar']('"John Doe"');
        expect($compiled)->toContain('renderAvatarDirective');
        expect($compiled)->toContain('<?php echo');
    });
});
