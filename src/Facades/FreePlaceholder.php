<?php

namespace FreePlaceholder\Facades;

use FreePlaceholder\FreePlaceholderManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string avatarUrl(string $name, array $options = [])
 * @method static string url(int $width, int $height, array $options = [])
 *
 * @see \FreePlaceholder\FreePlaceholderManager
 */
class FreePlaceholder extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FreePlaceholderManager::class;
    }
}
