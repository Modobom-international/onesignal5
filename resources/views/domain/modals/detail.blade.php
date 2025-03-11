<div id="detail-modal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('Chi tiết tên miền') }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="detail-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ __('Đóng') }}</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('Tên miền') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900" id="domain-modal"></dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('Tài khoản đăng nhập') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900" id="admin_username-modal"></dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('Mật khẩu đăng nhập') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900" id="admin_password-modal"></dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('Ngày tạo') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900" id="created_at-modal"></dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('Người quản lý') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900" id="email-modal"></dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('Máy chủ') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900" id="server-modal"></dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('Trạng thái') }}</dt>
                        <dd class="mt-1">
                            <span id="status-modal"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                            </span>
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center justify-end p-4 border-t border-gray-200">
                <button type="button" data-modal-hide="detail-modal"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-indigo-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                    data-bs-dismiss="modal">
                    {{ __('Đóng') }}
                </button>
            </div>
        </div>
    </div>
</div>
