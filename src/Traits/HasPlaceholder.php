<?php

namespace FreePlaceholder\Traits;

use FreePlaceholder\FreePlaceholderManager;

trait HasPlaceholder
{
    public function avatarUrl(array $overrides = []): string
    {
        $manager = app(FreePlaceholderManager::class);
        $name = $this->getPlaceholderText();
        $options = array_merge($this->placeholderOptions(), $overrides);

        return $manager->avatarUrl($name ?: '?', $options);
    }

    public function getAvatarAttribute(): string
    {
        return $this->avatarUrl();
    }

    public function getPlaceholderAttribute(): string
    {
        return $this->placeholderUrl();
    }

    public function placeholderUrl(array $overrides = []): string
    {
        $manager = app(FreePlaceholderManager::class);
        $options = array_merge($this->placeholderOptions(), $overrides);

        $text = $this->getPlaceholderText();
        if ($text) {
            $options['text'] = $text;
        }

        $width = $options['width'] ?? 300;
        $height = $options['height'] ?? 300;

        unset($options['width'], $options['height']);

        return $manager->url($width, $height, $options);
    }

    protected function getPlaceholderText(): ?string
    {
        $field = $this->placeholderTextField();
        $value = $this->getAttribute($field);

        return $value ? (string) $value : null;
    }

    protected function placeholderOptions(): array
    {
        return [];
    }

    protected function placeholderTextField(): string
    {
        return 'name';
    }
}
