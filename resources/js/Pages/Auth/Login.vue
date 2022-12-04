<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';


</script>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        login() {
            axios.post('/auth/login', {
                email: this.email,
                password: this.password
            }).then((response) => {
                this.$inertia.visit('/admin/dashboard');
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    components: { GuestLayout }
}
</script>

<template>
    <GuestLayout>
        <div class="mt-4 text-center w-[435px] mx-auto mb-10">
            <h1 class="text-white text-5xl font-bold">Welcome!</h1>
            <p class="text-white text-lg mt-4 break-words">
                Use these awesome forms to login or create new account in
                your project for free.
            </p>
        </div>

        <div class="w-[540px] mx-auto">
            <div class="bg-gray-100 rounded-lg border shadow-sm p-4">
                <p class="text-sm text-center text-[#8898AA] mb-8">Sign up with</p>
                <div class="flex justify-center mb-4 border-b pb-8">
                    <button class="">
                        <img src="/images/google.png" alt="google" class="border rounded-lg" />
                    </button>
                </div>

                <div class="mt-4 p-4">
                    <p class="text-sm text-center text-[#8898AA] mb-8">Or sign in with credentials</p>
                    <label
                        class="p-3 flex items-center gap-1.5 cursor-text outline-gray-400 focus-within:outline focus-within:outline-2 focus-within:outline-gray-900 rounded-lg border mb-4 bg-white">
                        <span class="text-2xl text-gray-900 flex-shrink-0">
                            <svg width="18" height="14" viewBox="0 0 18 14" fill="none" class="mr-1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.1037 8.40001C9.79987 8.58762 9.43668 8.6812 9.06877 8.66667C8.70086 8.6812 8.33767 8.58762 8.03381 8.40001L0.197708 4.60001V11.3333C0.197708 12.4379 1.19064 13.3333 2.41547 13.3333H15.7221C16.9469 13.3333 17.9398 12.4379 17.9398 11.3333V4.60001L10.1037 8.40001Z"
                                    fill="#8898AA" />
                                <path
                                    d="M15.7221 0H2.41547C1.19063 0 0.197708 0.895431 0.197708 2V2.66667C0.196271 2.91116 0.33639 3.1386 0.567335 3.26667L8.69914 7.26667C8.81265 7.32056 8.94101 7.34371 9.06877 7.33333C9.19653 7.34371 9.32489 7.32056 9.4384 7.26667L17.5702 3.26667C17.8011 3.1386 17.9413 2.91116 17.9398 2.66667V2C17.9398 0.895431 16.9469 0 15.7221 0Z"
                                    fill="#8898AA" />
                            </svg>

                        </span>
                        <input id="email" placeholder="Email" v-model="email"
                            class="autofill:delay-[99999s] bg-transparent w-full border-0 focus:outline-none text-base font-normal text-gray-900 placeholder:text-gray-400" />
                    </label>

                    <label
                        class="p-1 flex items-center gap-1.5 cursor-text outline-gray-400 focus-within:outline focus-within:outline-2 focus-within:outline-gray-900 rounded-lg border mb-4 bg-white">
                        <span class="text-2xl text-gray-900 flex-shrink-0">
                            <svg width="18" height="19" viewBox="0 0 13 19" fill="none" class="ml-2"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.43517 7.40269C4.37405 6.91106 5.46117 6.625 6.62321 6.625C10.1388 6.625 12.9993 9.20459 12.9993 12.375C12.9993 15.5454 10.1388 18.125 6.62321 18.125C3.1076 18.125 0.247135 15.5454 0.247135 12.375C0.247135 10.9224 0.852065 9.59775 1.84115 8.58431V5.1875C1.84115 2.80916 3.98591 0.875 6.62321 0.875C9.26051 0.875 11.4053 2.80916 11.4053 5.1875H9.81125C9.81125 3.60194 8.38141 2.3125 6.62321 2.3125C4.86501 2.3125 3.43517 3.60194 3.43517 5.1875V7.40269ZM7.42022 15.25V13.6803C8.34555 13.3827 9.01424 12.5921 9.01424 11.6562C9.01424 10.4674 7.94146 9.5 6.62321 9.5C5.30496 9.5 4.23218 10.4674 4.23218 11.6562C4.23218 12.5921 4.90087 13.3827 5.8262 13.6803V15.25H7.42022Z"
                                    fill="#ADB5BD" />
                            </svg>
                        </span>
                        <input id="password" placeholder="Password" type="password" v-model="password"
                            class="autofill:delay-[99999s] -ml-2 bg-transparent w-full border-0 focus:outline-none text-base font-normal text-gray-900 placeholder:text-gray-400" />
                    </label>

                    <!-- remember me -->
                    <div class="flex items-center mb-4">
                        <input id="default-checkbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-[#8898AA]">
                            Remember password
                        </label>
                    </div>

                    <div class="flex justify-center">
                        <button @click="login"
                            class="p-4 bg-[#5E72E4] hover:bg-[#2640d1] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-white font-medium py-2 px-4 rounded-lg">
                            Sign in
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>