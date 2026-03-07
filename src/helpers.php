<?php

use FreePlaceholder\FreePlaceholderManager;

if (! function_exists('avatar_url')) {
    function avatar_url(string $name, array $options = []): string
    {
        return app(FreePlaceholderManager::class)->avatarUrl($name, $options);
    }
}

if (! function_exists('placeholder_url')) {
    function placeholder_url(int $width = 300, int $height = 300, array $options = []): string
    {
        return app(FreePlaceholderManager::class)->url($width, $height, $options);
    }
}
