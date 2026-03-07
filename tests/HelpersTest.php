<?php

describe('helpers', function () {
    it('placeholder_url() returns a placeholder URL', function () {
        $url = placeholder_url(400, 300);
        expect($url)->toBe('https://freeplaceholder.com/400x300');
    });

    it('placeholder_url() uses default dimensions', function () {
        $url = placeholder_url();
        expect($url)->toBe('https://freeplaceholder.com/300x300');
    });

    it('placeholder_url() passes options', function () {
        $url = placeholder_url(100, 100, ['bg' => '3b82f6']);
        expect($url)->toContain('bg=3b82f6');
    });

    it('avatar_url() returns an avatar URL', function () {
        $url = avatar_url('Jane Doe');
        expect($url)->toBe('https://freeplaceholder.com/avatar/Jane%20Doe');
    });

    it('avatar_url() passes options', function () {
        $url = avatar_url('Test', ['size' => 64]);
        expect($url)->toContain('size=64');
    });
});
