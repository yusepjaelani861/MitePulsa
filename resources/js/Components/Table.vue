<script setup>
import Modal from './Modal.vue';


</script>

<script>
export default {
    props: ["type", "transaction"],
    data() {
        return {
            modal: false,
            product: {},
        };
    },
    methods: {
        convertRupiah(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        showModal(product) {
            this.modal = true
            this.product = product
        }
    },
    components: { Modal }
}
</script>

<template>
    <table v-if="type == 'product'" class="w-full text-center table-fixed">
        <thead class="bg-gray-200 text-slate-900">
            <tr class="">
                <th class="text-center py-2 w-20">No</th>
                <th class="text-center py-2">Code Product</th>
                <th class="text-center py-2">Name Product</th>
                <th class="text-center py-2">Price</th>
                <th class="text-center py-2">Action</th>
            </tr>
        </thead>
        <tbody class="overflow-y-auto w-full" style="height: 30vh;">
            <tr v-for="product in transaction" :key="product.id" class="border-b">
                <td class="py-2 w-20">{{ product.id }}</td>
                <td class="py-2">{{ product.buyer_sku_code }}</td>
                <td class="py-2">{{ product.product_name }}</td>
                <td class="py-2">Rp. {{ convertRupiah(product.price) }}</td>
                <td class="py-2">
                    <button @click="showModal(product)" class="bg-blue-500 text-white rounded-md px-2 py-1">Buy</button>
                </td>
            </tr>
        </tbody>
    </table>

    <table v-if="type == 'transaction'" class="w-full text-center table-fixed">
        <thead class="bg-gray-200 text-slate-900">
            <tr class="">
                <th class="text-center py-2">Ref</th>
                <th class="text-center py-2">Code Product</th>
                <th class="text-center py-2">Name Product</th>
                <th class="text-center py-2">Price</th>
                <th class="text-center py-2">Number</th>
                <th class="text-center py-2">Status</th>
            </tr>
        </thead>
        <tbody class="overflow-y-auto w-full" style="height: 30vh;">
            <tr v-for="transaksi in transaction" :key="transaksi.id" class="border-b">
                <td class="py-2">{{ transaksi.ref_id }}</td>
                <td class="py-2">{{ transaksi.product.buyer_sku_code }}</td>
                <td class="py-2">{{ transaksi.product.product_name }}</td>
                <td class="py-2">{{ convertRupiah(transaksi.product.price) }}</td>
                <td class="py-2">{{ transaksi.customer_no }}</td>
                <td class="py-2"><span class="text-green-600 font-bold">{{ transaksi.status }}</span></td>
            </tr>
        </tbody>
    </table>

    <Modal :modal="modal" :product="product" />
</template>