<script setup>
import axios from 'axios';
import { toHandlers } from 'vue';


</script>

<script>
export default {
    props: ['modal', 'product'],
    data() {
        return {
            number: ''
        }
    },
    methods: {
        buyProduct() {
            axios.post('/transaction/topup', {
                sku_code: this.product.buyer_sku_code,
                number: this.number
            })
                .then((response) => {
                    this.$inertia.visit('/admin/transactions');
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        startsWith(str, search, position) {
            return str.substr(!position || position < 0 ? 0 : +position, search.length) === search;
        }
    }
}
</script>

<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            :class="modal ? 'block' : 'hidden'" aria-modal="true">
            <div class="flex items end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                    <div class="bg-gray-50 w-full px-4 py-3">
                        <label class="block text-md font-medium text-gray-700 mb-4">
                            <span class="text-gray-900 font-bold">Name Product</span>
                            <input type="text" name="sku" :value="product.product_name" class="w-full rounded border-gray-200 border outline-gray-500 bg-white" disabled />
                        </label>

                        <label class="block text-md font-medium text-gray-700 mb-4">
                            <span class="text-gray-900 font-bold">Code Product</span>
                            <input type="text" name="sku" :value="product.buyer_sku_code" class="w-full rounded border-gray-200 border outline-gray-500 bg-white" disabled />
                        </label>

                        <label class="block text-md font-medium text-gray-700 mb-4">
                            <span class="text-gray-900 font-bold">Price</span>
                            <input type="number" name="sku" :value="product.price" class="w-full rounded border-gray-200 border outline-gray-500 bg-white" disabled />
                        </label>

                        <label class="block text-md font-medium text-gray-700 mb-4">
                            <span class="text-gray-900 font-bold">Number</span>
                            <input type="text" name="sku" class="w-full rounded border-gray-200 border outline-gray-500 bg-white" placeholder="Customer Number" v-model="number" required/>
                        </label>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="buyProduct"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                            Buy
                        </button>
                        <button type="button"
                            @click="modal = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
</template>