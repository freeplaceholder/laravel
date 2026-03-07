<?php

use FreePlaceholder\Views\Components\Avatar;
use FreePlaceholder\Views\Components\Placeholder;

describe('Placeholder Blade Component', function () {
    it('generates correct src URL', function () {
        $component = new Placeholder(width: 600, height: 400);
        expect($component->src)->toBe('https://freeplaceholder.com/600x400');
    });

    it('generates placeholder SVG with transparent fill when no bg', function () {
        $component = new Placeholder(width: 100, height: 100);
        expect($component->placeholderSvg)->toContain('data:image/svg+xml,');
        expect($component->placeholderSvg)->toContain('fill%3D%22transparent%22');
    });

    it('generates placeholder SVG with bg color', function () {
        $component = new Placeholder(width: 100, height: 100, bg: 'ff0000');
        expect($component->placeholderSvg)->toContain('%23ff0000');
    });

    it('includes gradient params in src URL', function () {
        $component = new Placeholder(
            width: 100, height: 100,
            gradient: 'to-r', from: '3b82f6', via: '8b5cf6', to: 'ec4899',
        );
        expect($component->src)->toContain('gradient=to-r');
        expect($component->src)->toContain('from=3b82f6');
        expect($component->src)->toContain('via=8b5cf6');
        expect($component->src)->toContain('to=ec4899');
    });

    it('includes text params', function () {
        $component = new Placeholder(
            width: 200, height: 100,
            text: 'Hello', textColor: 'ffffff', textSize: 24,
        );
        expect($component->src)->toContain('text=Hello');
        expect($component->src)->toContain('text-color=ffffff');
        expect($component->src)->toContain('text-size=24');
    });

    it('includes filter params', function () {
        $component = new Placeholder(
            width: 100, height: 100,
            blur: 5, brightness: 120, contrast: 80,
            grayscale: true, invert: true, sepia: true, saturate: 200,
            opacity: 50, hueRotate: 90,
        );
        expect($component->src)->toContain('blur=5');
        expect($component->src)->toContain('brightness=120');
        expect($component->src)->toContain('contrast=80');
        expect($component->src)->toContain('grayscale=true');
        expect($component->src)->toContain('invert=true');
        expect($component->src)->toContain('sepia=true');
        expect($component->src)->toContain('saturate=200');
        expect($component->src)->toContain('opacity=50');
        expect($component->src)->toContain('hue-rotate=90');
    });

    it('includes border params', function () {
        $component = new Placeholder(
            width: 100, height: 100,
            border: 2, borderColor: 'ff0000', borderStyle: 'dashed', rounded: 'lg',
        );
        expect($component->src)->toContain('border=2');
        expect($component->src)->toContain('border-color=ff0000');
        expect($component->src)->toContain('border-style=dashed');
        expect($component->src)->toContain('rounded=lg');
    });

    it('omits defaults like text-align center', function () {
        $component = new Placeholder(width: 100, height: 100, textAlign: 'center');
        expect($component->src)->not->toContain('text-align');
    });

    it('includes text-align when not center', function () {
        $component = new Placeholder(width: 100, height: 100, textAlign: 'left');
        expect($component->src)->toContain('text-align=left');
    });

    it('includes text-transform when not none', function () {
        $component = new Placeholder(width: 100, height: 100, textTransform: 'uppercase');
        expect($component->src)->toContain('text-transform=uppercase');
    });

    it('includes text-decoration when not none', function () {
        $component = new Placeholder(width: 100, height: 100, textDecoration: 'underline');
        expect($component->src)->toContain('text-decoration=underline');
    });

    it('includes letter-spacing', function () {
        $component = new Placeholder(width: 100, height: 100, letterSpacing: 'wide');
        expect($component->src)->toContain('letter-spacing=wide');
    });

    it('includes font-weight', function () {
        $component = new Placeholder(width: 100, height: 100, fontWeight: 'bold');
        expect($component->src)->toContain('font-weight=bold');
    });

    it('appends format extension for non-svg', function () {
        $component = new Placeholder(width: 100, height: 100, format: 'png');
        expect($component->src)->toContain('/100x100.png');
    });

    it('does not set rounded for none', function () {
        $component = new Placeholder(width: 100, height: 100, rounded: 'none');
        expect($component->src)->not->toContain('rounded');
    });
});

describe('Avatar Blade Component', function () {
    it('generates correct src URL', function () {
        $component = new Avatar(name: 'John Doe');
        expect($component->src)->toBe('https://freeplaceholder.com/avatar/John%20Doe');
    });

    it('generates placeholder SVG with transparent fill when no bg', function () {
        $component = new Avatar(name: 'Test');
        expect($component->placeholderSvg)->toContain('fill%3D%22transparent%22');
    });

    it('generates placeholder SVG with bg color', function () {
        $component = new Avatar(name: 'Test', bg: '10b981');
        expect($component->placeholderSvg)->toContain('%2310b981');
    });

    it('includes gradient params in src URL', function () {
        $component = new Avatar(
            name: 'Test',
            gradient: 'radial', from: 'ff0000', via: '00ff00', to: '0000ff',
        );
        expect($component->src)->toContain('gradient=radial');
        expect($component->src)->toContain('from=ff0000');
        expect($component->src)->toContain('via=00ff00');
        expect($component->src)->toContain('to=0000ff');
    });

    it('includes size when not default 128', function () {
        $component = new Avatar(name: 'Test', size: 64);
        expect($component->src)->toContain('size=64');
    });

    it('includes filter params', function () {
        $component = new Avatar(
            name: 'Test',
            blur: 3, brightness: 110, contrast: 90,
            grayscale: true, invert: true, sepia: true, saturate: 150,
            opacity: 80, hueRotate: 180,
        );
        expect($component->src)->toContain('blur=3');
        expect($component->src)->toContain('brightness=110');
        expect($component->src)->toContain('contrast=90');
        expect($component->src)->toContain('grayscale=true');
        expect($component->src)->toContain('invert=true');
        expect($component->src)->toContain('sepia=true');
        expect($component->src)->toContain('saturate=150');
        expect($component->src)->toContain('opacity=80');
        expect($component->src)->toContain('hue-rotate=180');
    });

    it('includes border params', function () {
        $component = new Avatar(
            name: 'Test',
            border: 1, borderColor: '000000', borderStyle: 'dotted', rounded: 'full',
        );
        expect($component->src)->toContain('border=1');
        expect($component->src)->toContain('border-color=000000');
        expect($component->src)->toContain('border-style=dotted');
        expect($component->src)->toContain('rounded=full');
    });

    it('includes text-decoration when not none', function () {
        $component = new Avatar(name: 'Test', textDecoration: 'underline');
        expect($component->src)->toContain('text-decoration=underline');
    });

    it('includes letter-spacing', function () {
        $component = new Avatar(name: 'Test', letterSpacing: 'tight');
        expect($component->src)->toContain('letter-spacing=tight');
    });

    it('includes font-weight', function () {
        $component = new Avatar(name: 'Test', fontWeight: 'semibold');
        expect($component->src)->toContain('font-weight=semibold');
    });

    it('includes text-color', function () {
        $component = new Avatar(name: 'Test', textColor: 'ffffff');
        expect($component->src)->toContain('text-color=ffffff');
    });

    it('appends format extension for non-svg', function () {
        $component = new Avatar(name: 'Test', format: 'png');
        expect($component->src)->toContain('.png');
    });

    it('does not set rounded for none', function () {
        $component = new Avatar(name: 'Test', rounded: 'none');
        expect($component->src)->not->toContain('rounded');
    });

    it('render() returns a view', function () {
        $component = new Avatar(name: 'Test');
        $view = $component->render();
        expect($view)->toBeInstanceOf(\Illuminate\Contracts\View\View::class);
    });
});

describe('Placeholder Blade Component render', function () {
    it('render() returns a view', function () {
        $component = new Placeholder(width: 300, height: 200);
        $view = $component->render();
        expect($view)->toBeInstanceOf(\Illuminate\Contracts\View\View::class);
    });
});
