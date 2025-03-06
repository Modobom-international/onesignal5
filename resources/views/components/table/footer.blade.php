@props(['class' => ''])

<tfoot {{ $attributes->merge(['class' => 'border-t bg-muted/50 font-medium [&>tr]:last:border-b-0 ' . $class]) }}>
    {{ $slot }}
</tfoot>
