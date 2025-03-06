@props(['class' => '', 'selected' => false])

<tr {{ $attributes->merge([
    'class' => 'border-b transition-colors hover:bg-muted/50 ' .
    ($selected ? 'bg-muted ' : '') .
    $class
]) }}>
    {{ $slot }}
</tr>
