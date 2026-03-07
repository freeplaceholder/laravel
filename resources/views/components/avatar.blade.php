<img
    src="{{ $src }}"
    alt="{{ $attributes->get('alt', $name) }}"
    width="{{ $size }}"
    height="{{ $size }}"
    @if($lazy) loading="lazy" style="background-image: url('{{ $placeholderSvg }}'); background-size: cover;{{ $attributes->get('style', '') }}" @else @if($attributes->get('style')) style="{{ $attributes->get('style') }}" @endif @endif
    {{ $attributes->except(['alt', 'style']) }}
/>
