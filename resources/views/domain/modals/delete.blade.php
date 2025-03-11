<!-- Delete Modal -->
<div id="delete-modal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900/20 backdrop-blur-[2px]">
    <div class="relative w-full max-w-[420px] max-h-full mx-auto mt-[15vh]">
        <!-- Modal content -->
        <div class="relative bg-white rounded-xl shadow-lg animate-in zoom-in-95 duration-200 ring-1 ring-gray-950/5">
            <!-- Modal header -->
            <div class="flex items-center justify-between px-4 py-4 border-b border-gray-100">
                <h3 class="text-base font-medium text-gray-900">
                    {{ __('Xóa tên miền') }}
                </h3>
                <button type="button"
                    class="text-gray-400 hover:text-gray-500 rounded-lg w-8 h-8 inline-flex items-center justify-center transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                    data-modal-hide="delete-modal">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ __('Đóng') }}</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="px-6 py-5">
                <div class="mx-auto mb-5 flex items-center justify-center w-12 h-12 rounded-full bg-red-50/75">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="mb-1 text-[15px] leading-6 text-gray-600 text-center">
                    {{ __('Bạn có chắc chắn muốn xóa tên miền') }}
                </p>
                <p class="text-[15px] leading-6 font-medium text-gray-900 text-center break-all" id="domain-in-title">
                </p>
                <input type="hidden" id="domain-in-hidden">
            </div>

            <!-- Modal footer -->
            <div class="px-6 py-4 bg-gray-50/75 rounded-b-xl border-t border-gray-100">
                <div class="flex justify-end gap-3">
                    <button type="button" data-modal-hide="delete-modal"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded-lg border border-gray-200 transition-colors"
                        data-bs-dismiss="modal">
                        {{ __('Hủy') }}
                    </button>
                    <button type="button" onclick="removeDomain()"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded-lg transition-colors"
                        data-bs-dismiss="modal">
                        {{ __('Xóa') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
