<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Xin lỗi, bạn chưa đăng nhập để thực hiện chức năng này') }}
        </div>

        <div>
            <a href="{{ route('dashboard') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                {{ __('Quay lại trang bảng điều khiển') }}
            </a>
        </div>
    </x-auth-card>
</x-guest-layout>