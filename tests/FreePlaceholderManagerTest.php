<?php

use FreePlaceholder\FreePlaceholderManager;

describe('FreePlaceholderManager', function () {
    beforeEach(function () {
        $this->manager = new FreePlaceholderManager('https://freeplaceholder.com');
    });

    describe('constructor', function () {
        it('trims trailing slashes from baseUrl', function () {
            $manager = new FreePlaceholderManager('https://example.com///');
            expect($manager->url(100, 100))->toStartWith('https://example.com/');
        });

        it('uses default base URL', function () {
            $manager = new FreePlaceholderManager();
            expect($manager->url(100, 100))->toStartWith('https://freeplaceholder.com/');
        });
    });

    describe('url()', function () {
        it('builds a basic placeholder URL', function () {
            expect($this->manager->url(600, 400))
                ->toBe('https://freeplaceholder.com/600x400');
        });

        it('appends format for non-svg', function () {
            expect($this->manager->url(100, 100, ['format' => 'png']))
                ->toContain('/100x100.png');
        });

        it('does not append format for svg', function () {
            expect($this->manager->url(100, 100, ['format' => 'svg']))
                ->not->toContain('.svg');
        });

        it('adds bg param', function () {
            expect($this->manager->url(100, 100, ['bg' => '3b82f6']))
                ->toContain('bg=3b82f6');
        });

        it('adds gradient params', function () {
            $url = $this->manager->url(100, 100, [
                'gradient' => 'to-r',
                'from' => '3b82f6',
                'via' => '8b5cf6',
                'to' => 'ec4899',
            ]);
            expect($url)->toContain('gradient=to-r');
            expect($url)->toContain('from=3b82f6');
            expect($url)->toContain('via=8b5cf6');
            expect($url)->toContain('to=ec4899');
        });

        it('adds text params', function () {
            $url = $this->manager->url(200, 100, [
                'text' => 'Hello',
                'text-color' => 'ffffff',
                'text-size' => 24,
                'font-weight' => 'bold',
            ]);
            expect($url)->toContain('text=Hello');
            expect($url)->toContain('text-color=ffffff');
            expect($url)->toContain('text-size=24');
            expect($url)->toContain('font-weight=bold');
        });

        it('adds text-align when not center', function () {
            expect($this->manager->url(100, 100, ['text-align' => 'left']))
                ->toContain('text-align=left');
        });

        it('omits text-align when center', function () {
            expect($this->manager->url(100, 100, ['text-align' => 'center']))
                ->not->toContain('text-align');
        });

        it('adds text-transform when not none', function () {
            expect($this->manager->url(100, 100, ['text-transform' => 'uppercase']))
                ->toContain('text-transform=uppercase');
        });

        it('adds text-decoration when not none', function () {
            expect($this->manager->url(100, 100, ['text-decoration' => 'underline']))
                ->toContain('text-decoration=underline');
        });

        it('adds letter-spacing', function () {
            expect($this->manager->url(100, 100, ['letter-spacing' => 'wide']))
                ->toContain('letter-spacing=wide');
        });

        it('adds opacity when not 100', function () {
            expect($this->manager->url(100, 100, ['opacity' => 80]))
                ->toContain('opacity=80');
        });

        it('omits opacity when 100', function () {
            expect($this->manager->url(100, 100, ['opacity' => 100]))
                ->not->toContain('opacity');
        });

        it('adds grayscale when true', function () {
            expect($this->manager->url(100, 100, ['grayscale' => true]))
                ->toContain('grayscale=true');
        });

        it('adds blur when > 0', function () {
            expect($this->manager->url(100, 100, ['blur' => 5]))
                ->toContain('blur=5');
        });

        it('adds brightness when not 100', function () {
            expect($this->manager->url(100, 100, ['brightness' => 120]))
                ->toContain('brightness=120');
        });

        it('adds contrast when not 100', function () {
            expect($this->manager->url(100, 100, ['contrast' => 80]))
                ->toContain('contrast=80');
        });

        it('adds hue-rotate when > 0', function () {
            expect($this->manager->url(100, 100, ['hue-rotate' => 90]))
                ->toContain('hue-rotate=90');
        });

        it('adds invert when true', function () {
            expect($this->manager->url(100, 100, ['invert' => true]))
                ->toContain('invert=true');
        });

        it('adds saturate when not 100', function () {
            expect($this->manager->url(100, 100, ['saturate' => 200]))
                ->toContain('saturate=200');
        });

        it('adds sepia when true', function () {
            expect($this->manager->url(100, 100, ['sepia' => true]))
                ->toContain('sepia=true');
        });

        it('adds border when > 0', function () {
            expect($this->manager->url(100, 100, ['border' => 2]))
                ->toContain('border=2');
        });

        it('adds border-color', function () {
            expect($this->manager->url(100, 100, ['border-color' => 'ff0000']))
                ->toContain('border-color=ff0000');
        });

        it('adds border-style when not solid', function () {
            expect($this->manager->url(100, 100, ['border-style' => 'dashed']))
                ->toContain('border-style=dashed');
        });

        it('adds rounded when not 0 or none', function () {
            expect($this->manager->url(100, 100, ['rounded' => 'lg']))
                ->toContain('rounded=lg');
        });

        it('omits rounded when none', function () {
            expect($this->manager->url(100, 100, ['rounded' => 'none']))
                ->not->toContain('rounded');
        });

        it('omits rounded when 0', function () {
            expect($this->manager->url(100, 100, ['rounded' => '0']))
                ->not->toContain('rounded');
        });

        it('returns no query string when no options', function () {
            expect($this->manager->url(100, 100))->not->toContain('?');
        });

        it('merges defaults from config', function () {
            config(['freeplaceholder.defaults' => ['bg' => 'default_bg']]);
            expect($this->manager->url(100, 100))->toContain('bg=default_bg');
            config(['freeplaceholder.defaults' => []]);
        });
    });

    describe('avatarUrl()', function () {
        it('builds a basic avatar URL', function () {
            expect($this->manager->avatarUrl('John Doe'))
                ->toBe('https://freeplaceholder.com/avatar/John%20Doe');
        });

        it('appends format for non-svg', function () {
            expect($this->manager->avatarUrl('Test', ['format' => 'png']))
                ->toContain('/avatar/Test.png');
        });

        it('adds size when not 128', function () {
            expect($this->manager->avatarUrl('Test', ['size' => 64]))
                ->toContain('size=64');
        });

        it('omits size when 128', function () {
            expect($this->manager->avatarUrl('Test', ['size' => 128]))
                ->not->toContain('size=');
        });

        it('adds bg param', function () {
            expect($this->manager->avatarUrl('Test', ['bg' => '10b981']))
                ->toContain('bg=10b981');
        });

        it('adds gradient params', function () {
            $url = $this->manager->avatarUrl('Test', [
                'gradient' => 'radial',
                'from' => 'ff0000',
                'via' => '00ff00',
                'to' => '0000ff',
            ]);
            expect($url)->toContain('gradient=radial');
            expect($url)->toContain('from=ff0000');
            expect($url)->toContain('via=00ff00');
            expect($url)->toContain('to=0000ff');
        });

        it('adds text-decoration when not none', function () {
            expect($this->manager->avatarUrl('Test', ['text-decoration' => 'underline']))
                ->toContain('text-decoration=underline');
        });

        it('adds letter-spacing', function () {
            expect($this->manager->avatarUrl('Test', ['letter-spacing' => 'tight']))
                ->toContain('letter-spacing=tight');
        });

        it('adds rounded when not 0 or none', function () {
            expect($this->manager->avatarUrl('Test', ['rounded' => 'full']))
                ->toContain('rounded=full');
        });

        it('omits rounded when 0', function () {
            expect($this->manager->avatarUrl('Test', ['rounded' => '0']))
                ->not->toContain('rounded');
        });

        it('omits rounded when none', function () {
            expect($this->manager->avatarUrl('Test', ['rounded' => 'none']))
                ->not->toContain('rounded');
        });

        it('merges defaults from config', function () {
            config(['freeplaceholder.avatar_defaults' => ['bg' => 'avatar_bg']]);
            expect($this->manager->avatarUrl('Test'))->toContain('bg=avatar_bg');
            config(['freeplaceholder.avatar_defaults' => []]);
        });

        it('returns no query string when no options', function () {
            expect($this->manager->avatarUrl('Test'))->not->toContain('?');
        });
    });

    describe('renderPlaceholderDirective()', function () {
        it('renders basic placeholder img tag', function () {
            $html = $this->manager->renderPlaceholderDirective();
            expect($html)->toContain('<img');
            expect($html)->toContain('src="https://freeplaceholder.com/300x300"');
            expect($html)->toContain('alt="300×300 placeholder"');
        });

        it('includes gradient in URL', function () {
            $html = $this->manager->renderPlaceholderDirective(
                width: 100, height: 100, gradient: 'to-r', from: '3b82f6', to: 'ec4899',
            );
            expect($html)->toContain('gradient=to-r');
            expect($html)->toContain('from=3b82f6');
            expect($html)->toContain('to=ec4899');
        });

        it('includes via in gradient URL', function () {
            $html = $this->manager->renderPlaceholderDirective(
                width: 100, height: 100, gradient: 'to-r', from: '3b82f6', via: '8b5cf6', to: 'ec4899',
            );
            expect($html)->toContain('via=8b5cf6');
        });

        it('adds class attribute when provided', function () {
            $html = $this->manager->renderPlaceholderDirective(class: 'my-img');
            expect($html)->toContain('class="my-img"');
        });

        it('adds id attribute when provided', function () {
            $html = $this->manager->renderPlaceholderDirective(id: 'img-1');
            expect($html)->toContain('id="img-1"');
        });

        it('uses custom alt text', function () {
            $html = $this->manager->renderPlaceholderDirective(alt: 'Custom alt');
            expect($html)->toContain('alt="Custom alt"');
        });

        it('does not include class or id when not provided', function () {
            $html = $this->manager->renderPlaceholderDirective();
            expect($html)->not->toContain('class=');
            expect($html)->not->toContain('id=');
        });
    });

    describe('renderAvatarDirective()', function () {
        it('renders basic avatar img tag', function () {
            $html = $this->manager->renderAvatarDirective('John Doe');
            expect($html)->toContain('<img');
            expect($html)->toContain('src="https://freeplaceholder.com/avatar/John%20Doe"');
            expect($html)->toContain('alt="John Doe"');
            expect($html)->toContain('width="128"');
            expect($html)->toContain('height="128"');
        });

        it('includes gradient in URL', function () {
            $html = $this->manager->renderAvatarDirective(
                name: 'Test', gradient: 'radial', from: 'ff0000', to: '0000ff',
            );
            expect($html)->toContain('gradient=radial');
            expect($html)->toContain('from=ff0000');
            expect($html)->toContain('to=0000ff');
        });

        it('includes via in gradient URL', function () {
            $html = $this->manager->renderAvatarDirective(
                name: 'Test', gradient: 'to-b', from: 'ff0000', via: '00ff00', to: '0000ff',
            );
            expect($html)->toContain('via=00ff00');
        });

        it('adds class attribute when provided', function () {
            $html = $this->manager->renderAvatarDirective('Test', class: 'rounded');
            expect($html)->toContain('class="rounded"');
        });

        it('adds id attribute when provided', function () {
            $html = $this->manager->renderAvatarDirective('Test', id: 'avatar-1');
            expect($html)->toContain('id="avatar-1"');
        });

        it('uses custom alt text', function () {
            $html = $this->manager->renderAvatarDirective('Test', alt: 'Profile photo');
            expect($html)->toContain('alt="Profile photo"');
        });

        it('does not include class or id when not provided', function () {
            $html = $this->manager->renderAvatarDirective('Test');
            expect($html)->not->toContain('class=');
            expect($html)->not->toContain('id=');
        });

        it('uses custom size', function () {
            $html = $this->manager->renderAvatarDirective('Test', size: 64);
            expect($html)->toContain('width="64"');
            expect($html)->toContain('height="64"');
        });
    });
});
