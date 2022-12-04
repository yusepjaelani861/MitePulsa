<script setup>
import Navbar from '@/Components/Navbar.vue';

</script>

<script>
export default {
    data() {
        return {
            app_name: import.meta.env.VITE_APP_NAME,
            dropdown: false,
        }
    }, 
    methods: {
        showDropdown() {
            this.dropdown = !this.dropdown;
        },
        logout() {
            this.$inertia.post('/auth/logout');
        }
    }
}
</script>

<template>
    <div class="flex font-sans bg-[#F8F9FE]">
        <div class="flex-shrink-0 h-screen bg-white">
            <div class="w-[250px] p-4">
                <h1 class="text-3xl text-center font-bold mt-2 mb-8">{{ app_name }}</h1>

                <Navbar />
            </div>
        </div>

        <div class="relative bg-gradient-to-r from-[#5E72E4] to-[#825EE4] w-full h-[380px] text-white p-4">
            <div class="flex justify-between p-4 mb-4 items-center">
                <h1 class="text-xl font-bold">
                    {{
                            route().current('admin.dashboard') ? 'Dashboard' :
                                route().current('admin.products') ? 'Products' :
                                    route().current('admin.transactions') ? 'Transactions' :
                                        route().current('admin.balances') ? 'Balances' :
                                            'Page Not Found'
                    }}
                </h1>
                <div class="flex items-center">
                    <button @click="showDropdown" class="flex items-center cursor-pointer">
                        <img src="https://ui-avatars.com/api/?name=YUSEP&background=0D8ABC&color=fff&size=128"
                            class="rounded-full flex-shr w-10 h-10">
                    </button>
                    <div id="dropdown-logout" class="absolute right-8 mt-24 bg-white rounded-md shadow-md p-1 w-32"
                        :class="dropdown ? 'block' : 'hidden'">
                        <ul class="text-slate font-medium">
                            <li @click="logout" class="p-2 hover:bg-gray-200 text-center text-slate-900 cursor-pointer">Logout</li>
                        </ul>
                    </div>
                </div>
            </div>

            <main class="w-full">
                <slot />
            </main>
            <footer class="text-center text-sm text-gray-500 p-4 mt-4">
                <p>2022 &copy; {{ app_name }}. All rights reserved.</p>
            </footer>
        </div>
    </div>
</template>