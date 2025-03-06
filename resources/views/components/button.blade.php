@props([
'variant' => 'default',
'size' => 'default',
'asChild' => false,
'href' => false,
'disabled' => false,
'srText' => '',
'iconOnly' => false,
'pill' => false,
'squared' => false
])

@php

$baseClasses = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0';

switch ($variant) {
case 'default':
$variantClasses = 'bg-primary text-primary-foreground shadow hover:bg-primary/90';
break;
case 'destructive':
$variantClasses = 'bg-destructive text-destructive-foreground shadow-sm hover:bg-destructive/90';
break;
case 'outline':
$variantClasses = 'border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground';
break;
case 'secondary':
$variantClasses = 'bg-secondary text-secondary-foreground shadow-sm hover:bg-secondary/80';
break;
case 'ghost':
$variantClasses = 'hover:bg-accent hover:text-accent-foreground';
break;
case 'link':
$variantClasses = 'text-primary underline-offset-4 hover:underline';
break;
default:
$variantClasses = 'bg-primary text-primary-foreground shadow hover:bg-primary/90';
}

switch ($size) {
case 'default':
$sizeClasses = 'h-9 px-4 py-2';
break;
case 'sm':
$sizeClasses = 'h-8 rounded-md px-3 text-xs';
break;
case 'lg':
$sizeClasses = 'h-10 rounded-md px-8';
break;
case 'icon':
$sizeClasses = 'h-9 w-9';
break;
default:
$sizeClasses = 'h-9 px-4 py-2';
}

$classes = $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses;

if(!$squared && !$pill){
$classes .= ' rounded-md';
} else if ($pill) {
$classes .= ' rounded-full';

}

@endphp

@if ($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    @if($srText)
    <span class="sr-only">{{ $srText }}</span>
    @endif
</a>
@else
<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes, 'disabled' => $disabled]) }}>
    {{ $slot }}
    @if($srText)
    <span class="sr-only">{{ $srText }}</span>
    @endif
</button>
@endif
