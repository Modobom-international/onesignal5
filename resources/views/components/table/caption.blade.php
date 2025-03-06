@props(['class' => ''])

<caption {{ $attributes->merge(['class' => 'mt-4 text-sm text-muted-foreground ' . $class]) }}>
    {{ $slot }}
</caption>
