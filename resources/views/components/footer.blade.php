{{-- Footer positioned within content area --}}
<footer class="relative w-full bg-background border-t border-border">
    <div class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <div class="text-sm text-muted-foreground">
                © {{ date('Y') }} {{ __('Modobom.inc') }}. {{ __('All rights reserved') }}.
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-muted-foreground ">{{ __('Made with') }}</span>
                <x-heroicon-s-heart class="w-4 h-4 text-red-500" />
                <span class="text-sm text-muted-foreground ">{{ __('by Modobom') }}</span>
            </div>
        </div>
    </div>
</footer>
