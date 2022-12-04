<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<script>
export default {
    data() {
        return {
            app_name: import.meta.env.VITE_APP_NAME,
        }
    }
}
</script>

<template>
    <div class="h-full w-full">
        <div class="absolute bg-gradient-to-r top- from-[#5E72E4] to-[#825EE4] w-full h-[470px] z-0">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between">
                    <h1 class="text-white text-3xl font-bold mt-4">{{ app_name }}</h1>
                    <nav class="flex">
                        <Link :href="route('login')" class="flex mt-2 mr-6 text-white items-center">
                        <div class="flex-shrink-0 mr-2">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.8047 4.86201L13.6093 2.66668L15.138 1.13801C15.3987 0.877347 15.3987 0.456014 15.138 0.195347C14.8773 -0.0653193 14.456 -0.0653193 14.1953 0.195347L7.26733 7.12335C7.442 7.25935 7.612 7.40335 7.77133 7.56201C7.93067 7.72135 8.074 7.89135 8.21 8.06601L10.6667 5.60935L12.862 7.80468C12.992 7.93468 13.1627 8.00001 13.3333 8.00001C13.504 8.00001 13.6747 7.93468 13.8047 7.80468L15.8047 5.80468C16.0653 5.54401 16.0653 5.12268 15.8047 4.86201Z"
                                    fill="white" />
                                <path
                                    d="M4 15.3333C5.06867 15.3333 6.07267 14.9173 6.82867 14.162C7.58467 13.4067 8 12.402 8 11.3333C8 10.2647 7.584 9.26068 6.82867 8.50468C6.07333 7.74868 5.06867 7.33334 4 7.33334C2.93133 7.33334 1.92733 7.74934 1.17133 8.50468C0.415333 9.26001 0 10.2647 0 11.3333C0 12.402 0.416 13.406 1.17133 14.162C1.92667 14.918 2.93133 15.3333 4 15.3333Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <p class="text-lg font-bold">Login</p>
                        </Link>
                        <Link :href="route('register')" class="flex mt-2 text-white items-center">
                        <div class="flex-shrink-0 mr-2">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8 0C3.58867 0 0 3.58867 0 8C0 12.4113 3.58867 16 8 16C12.4113 16 16 12.4113 16 8C16 3.58867 12.4113 0 8 0ZM5.33333 6.66667C5.33333 5.194 6.56267 4 8 4C9.43733 4 10.6667 5.194 10.6667 6.66667V7.33333C10.6667 8.806 9.43733 10 8 10C6.56267 10 5.33333 8.806 5.33333 7.33333V6.66667ZM3.73267 13.116C4.89 14.0827 6.378 14.6667 8 14.6667C9.622 14.6667 11.11 14.0827 12.2673 13.116C11.708 12.0607 10.6113 11.3333 9.33333 11.3333H6.66667C5.38867 11.3333 4.292 12.0607 3.73267 13.116Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <p class="text-lg font-bold">Register</p>
                        </Link>
                    </nav>
                </div>
                <main class="">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
