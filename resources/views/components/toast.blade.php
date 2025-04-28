<div
    x-data="{ 
        toasts: [],
        add(toast) {
            this.toasts.push({
                id: Date.now(),
                message: toast.message,
                type: toast.type || 'info',
                autoDismiss: toast.autoDismiss !== undefined ? toast.autoDismiss : true
            });
        },
        remove(id) {
            this.toasts = this.toasts.filter(toast => toast.id !== id);
        }
    }"
    @notify.window="add($event.detail)"
    class="fixed bottom-6 right-6 z-50 space-y-4 w-full max-w-xs sm:max-w-sm"
    style="pointer-events: none;"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-data="{ show: false }"
            x-init="() => {
                setTimeout(() => { show = true }, 100);
                if (toast.autoDismiss) {
                    setTimeout(() => { show = false }, 5000);
                }
            }"
            @click="show = false"
            x-show="show"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-10 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transform ease-in duration-200 transition"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-10 opacity-0"
            @transitionend.leave="remove(toast.id)"
            :class="{
                'bg-green-100 border-l-4 border-green-500 text-green-700': toast.type === 'success',
                'bg-red-100 border-l-4 border-red-500 text-red-700': toast.type === 'error',
                'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700': toast.type === 'warning',
                'bg-blue-100 border-l-4 border-blue-500 text-blue-700': toast.type === 'info'
            }"
            class="p-4 rounded-2xl shadow-xl flex items-start gap-3 cursor-pointer pointer-events-auto"
        >
            <div class="flex-shrink-0">
                <template x-if="toast.type === 'success'">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M5.93 5.93a10 10 0 0112.14 0m1.41 1.41a10 10 0 010 12.14m-1.41 1.41a10 10 0 01-12.14 0m-1.41-1.41a10 10 0 010-12.14"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'info'">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m0-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z"></path>
                    </svg>
                </template>
            </div>
            <div class="flex-1 text-sm font-medium" x-text="toast.message"></div>
            <button @click.stop="show = false" class="ml-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </template>
</div>
