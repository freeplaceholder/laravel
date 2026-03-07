<?php

namespace FreePlaceholder\Views\Components;

use FreePlaceholder\FreePlaceholderManager;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    public string $src;

    public string $placeholderSvg;

    public function __construct(
        public string $name,
        public string $bg = '',
        public string $gradient = '',
        public string $from = '',
        public string $via = '',
        public string $to = '',
        public int $blur = 0,
        public int $border = 0,
        public string $borderColor = '',
        public string $borderStyle = 'solid',
        public int $brightness = 100,
        public int $contrast = 100,
        public string $fontWeight = '',
        public string $format = 'svg',
        public bool $grayscale = false,
        public int $hueRotate = 0,
        public bool $invert = false,
        public bool $lazy = true,
        public string $letterSpacing = '',
        public int $opacity = 100,
        public string $rounded = '0',
        public int $saturate = 100,
        public bool $sepia = false,
        public int $size = 128,
        public string $textColor = '',
        public string $textDecoration = 'none',
    ) {
        $manager = app(FreePlaceholderManager::class);

        $this->src = $manager->avatarUrl($name, array_filter([
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

        $fill = $bg ? "#{$bg}" : 'transparent';
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '"><rect width="100%" height="100%" fill="' . $fill . '"/></svg>';
        $this->placeholderSvg = 'data:image/svg+xml,' . rawurlencode($svg);
    }

    public function render(): View
    {
        return view('freeplaceholder::components.avatar');
    }
}
