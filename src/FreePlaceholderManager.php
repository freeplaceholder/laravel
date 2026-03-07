<?php

namespace FreePlaceholder;

class FreePlaceholderManager
{
    protected string $baseUrl;

    public function __construct(string $baseUrl = 'https://freeplaceholder.com')
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function avatarUrl(string $name, array $options = []): string
    {
        return $this->buildAvatarUrl($name, $options);
    }

    public function renderAvatarDirective(
        string $name,
        int $size = 128,
        string $format = 'svg',
        string $bg = '',
        string $gradient = '',
        string $from = '',
        string $via = '',
        string $to = '',
        string $textColor = '',
        string $fontWeight = '',
        string $textDecoration = 'none',
        string $letterSpacing = '',
        int $opacity = 100,
        bool $grayscale = false,
        int $blur = 0,
        int $brightness = 100,
        int $contrast = 100,
        int $hueRotate = 0,
        bool $invert = false,
        int $saturate = 100,
        bool $sepia = false,
        int $border = 0,
        string $borderColor = '',
        string $borderStyle = 'solid',
        string $rounded = '0',
        string $class = '',
        string $alt = '',
        string $id = '',
    ): string {
        $url = $this->buildAvatarUrl($name, array_filter([
            'size' => $size,
            'format' => $format,
            'bg' => $bg,
            'gradient' => $gradient ?: null,
            'from' => $from ?: null,
            'via' => $via ?: null,
            'to' => $to ?: null,
            'text-color' => $textColor,
            'font-weight' => $fontWeight,
            'text-decoration' => $textDecoration !== 'none' ? $textDecoration : null,
            'letter-spacing' => $letterSpacing ?: null,
            'opacity' => $opacity !== 100 ? $opacity : null,
            'grayscale' => $grayscale ?: null,
            'blur' => $blur > 0 ? $blur : null,
            'brightness' => $brightness !== 100 ? $brightness : null,
            'contrast' => $contrast !== 100 ? $contrast : null,
            'hue-rotate' => $hueRotate > 0 ? $hueRotate : null,
            'invert' => $invert ?: null,
            'saturate' => $saturate !== 100 ? $saturate : null,
            'sepia' => $sepia ?: null,
            'border' => $border > 0 ? $border : null,
            'border-color' => $borderColor,
            'border-style' => $borderStyle !== 'solid' ? $borderStyle : null,
            'rounded' => $rounded !== '0' && $rounded !== 'none' ? $rounded : null,
        ]));

        $altText = e($alt ?: $name);
        $attrs = '';

        if ($class) {
            $attrs .= ' class="' . e($class) . '"';
        }

        if ($id) {
            $attrs .= ' id="' . e($id) . '"';
        }

        return "<img src=\"{$url}\" alt=\"{$altText}\" width=\"{$size}\" height=\"{$size}\"{$attrs} />";
    }

    public function renderPlaceholderDirective(
        int $width = 300,
        int $height = 300,
        string $format = 'svg',
        string $bg = '',
        string $gradient = '',
        string $from = '',
        string $via = '',
        string $to = '',
        string $textColor = '',
        string $text = '',
        ?int $textSize = null,
        string $fontWeight = '',
        string $textAlign = 'center',
        string $textTransform = 'none',
        string $textDecoration = 'none',
        string $letterSpacing = '',
        int $opacity = 100,
        bool $grayscale = false,
        int $blur = 0,
        int $brightness = 100,
        int $contrast = 100,
        int $hueRotate = 0,
        bool $invert = false,
        int $saturate = 100,
        bool $sepia = false,
        int $border = 0,
        string $borderColor = '',
        string $borderStyle = 'solid',
        string $rounded = '0',
        string $class = '',
        string $alt = '',
        string $id = '',
    ): string {
        $url = $this->buildPlaceholderUrl($width, $height, array_filter([
            'format' => $format,
            'bg' => $bg,
            'gradient' => $gradient ?: null,
            'from' => $from ?: null,
            'via' => $via ?: null,
            'to' => $to ?: null,
            'text-color' => $textColor,
            'text' => $text,
            'text-size' => $textSize,
            'font-weight' => $fontWeight,
            'text-align' => $textAlign !== 'center' ? $textAlign : null,
            'text-transform' => $textTransform !== 'none' ? $textTransform : null,
            'text-decoration' => $textDecoration !== 'none' ? $textDecoration : null,
            'letter-spacing' => $letterSpacing ?: null,
            'opacity' => $opacity !== 100 ? $opacity : null,
            'grayscale' => $grayscale ?: null,
            'blur' => $blur > 0 ? $blur : null,
            'brightness' => $brightness !== 100 ? $brightness : null,
            'contrast' => $contrast !== 100 ? $contrast : null,
            'hue-rotate' => $hueRotate > 0 ? $hueRotate : null,
            'invert' => $invert ?: null,
            'saturate' => $saturate !== 100 ? $saturate : null,
            'sepia' => $sepia ?: null,
            'border' => $border > 0 ? $border : null,
            'border-color' => $borderColor,
            'border-style' => $borderStyle !== 'solid' ? $borderStyle : null,
            'rounded' => $rounded !== '0' && $rounded !== 'none' ? $rounded : null,
        ]));

        $altText = e($alt ?: "{$width}×{$height} placeholder");
        $attrs = '';

        if ($class) {
            $attrs .= ' class="' . e($class) . '"';
        }

        if ($id) {
            $attrs .= ' id="' . e($id) . '"';
        }

        return "<img src=\"{$url}\" alt=\"{$altText}\"{$attrs} />";
    }

    public function url(int $width, int $height, array $options = []): string
    {
        return $this->buildPlaceholderUrl($width, $height, $options);
    }

    protected function buildAvatarUrl(string $name, array $options = []): string
    {
        $defaults = config('freeplaceholder.avatar_defaults', []);
        $options = array_merge($defaults, $options);

        $encodedName = rawurlencode($name);
        $format = $options['format'] ?? 'svg';

        $path = "/avatar/{$encodedName}";

        if ($format !== 'svg') {
            $path .= ".{$format}";
        }

        $params = [];

        $size = $options['size'] ?? null;
        if ($size !== null && $size !== 128) {
            $params['size'] = $size;
        }

        $this->addCommonParams($params, $options);
        $this->addFilterParams($params, $options);
        $this->addBorderParams($params, $options);

        if (! empty($options['text-decoration']) && $options['text-decoration'] !== 'none') {
            $params['text-decoration'] = $options['text-decoration'];
        }

        if (! empty($options['letter-spacing'])) {
            $params['letter-spacing'] = $options['letter-spacing'];
        }

        if (! empty($options['rounded']) && $options['rounded'] !== '0' && $options['rounded'] !== 'none') {
            $params['rounded'] = $options['rounded'];
        }

        $query = ! empty($params) ? '?' . http_build_query($params) : '';

        return "{$this->baseUrl}{$path}{$query}";
    }

    protected function buildPlaceholderUrl(int $width, int $height, array $options = []): string
    {
        $defaults = config('freeplaceholder.defaults', []);
        $options = array_merge($defaults, $options);

        $format = $options['format'] ?? 'svg';

        $path = "/{$width}x{$height}";

        if ($format !== 'svg') {
            $path .= ".{$format}";
        }

        $params = [];

        $this->addCommonParams($params, $options);

        if (! empty($options['text'])) {
            $params['text'] = $options['text'];
        }

        if (isset($options['text-size'])) {
            $params['text-size'] = $options['text-size'];
        }

        if (! empty($options['text-align']) && $options['text-align'] !== 'center') {
            $params['text-align'] = $options['text-align'];
        }

        if (! empty($options['text-transform']) && $options['text-transform'] !== 'none') {
            $params['text-transform'] = $options['text-transform'];
        }

        if (! empty($options['text-decoration']) && $options['text-decoration'] !== 'none') {
            $params['text-decoration'] = $options['text-decoration'];
        }

        if (! empty($options['letter-spacing'])) {
            $params['letter-spacing'] = $options['letter-spacing'];
        }

        $this->addFilterParams($params, $options);
        $this->addBorderParams($params, $options);

        if (! empty($options['rounded']) && $options['rounded'] !== '0' && $options['rounded'] !== 'none') {
            $params['rounded'] = $options['rounded'];
        }

        $query = ! empty($params) ? '?' . http_build_query($params) : '';

        return "{$this->baseUrl}{$path}{$query}";
    }

    private function addBorderParams(array &$params, array $options): void
    {
        if (! empty($options['border']) && $options['border'] > 0) {
            $params['border'] = $options['border'];
        }

        if (! empty($options['border-color'])) {
            $params['border-color'] = $options['border-color'];
        }

        if (! empty($options['border-style']) && $options['border-style'] !== 'solid') {
            $params['border-style'] = $options['border-style'];
        }
    }

    private function addCommonParams(array &$params, array $options): void
    {
        if (! empty($options['bg'])) {
            $params['bg'] = $options['bg'];
        }

        if (! empty($options['gradient'])) {
            $params['gradient'] = $options['gradient'];
        }

        if (! empty($options['from'])) {
            $params['from'] = $options['from'];
        }

        if (! empty($options['via'])) {
            $params['via'] = $options['via'];
        }

        if (! empty($options['to'])) {
            $params['to'] = $options['to'];
        }

        if (! empty($options['text-color'])) {
            $params['text-color'] = $options['text-color'];
        }

        if (! empty($options['font-weight'])) {
            $params['font-weight'] = $options['font-weight'];
        }

        if (isset($options['opacity']) && $options['opacity'] !== 100) {
            $params['opacity'] = $options['opacity'];
        }
    }

    private function addFilterParams(array &$params, array $options): void
    {
        if (! empty($options['grayscale'])) {
            $params['grayscale'] = 'true';
        }

        if (! empty($options['blur']) && $options['blur'] > 0) {
            $params['blur'] = $options['blur'];
        }

        if (isset($options['brightness']) && $options['brightness'] !== 100) {
            $params['brightness'] = $options['brightness'];
        }

        if (isset($options['contrast']) && $options['contrast'] !== 100) {
            $params['contrast'] = $options['contrast'];
        }

        if (! empty($options['hue-rotate']) && $options['hue-rotate'] > 0) {
            $params['hue-rotate'] = $options['hue-rotate'];
        }

        if (! empty($options['invert'])) {
            $params['invert'] = 'true';
        }

        if (isset($options['saturate']) && $options['saturate'] !== 100) {
            $params['saturate'] = $options['saturate'];
        }

        if (! empty($options['sepia'])) {
            $params['sepia'] = 'true';
        }
    }
}
