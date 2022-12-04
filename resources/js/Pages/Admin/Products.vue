<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Table from '@/Components/Table.vue';

defineProps(['products']);
</script>

<script>
export default {
    data() {
        return {
            transaction: []
        };
    },
    components: { AdminLayout }
}
</script>

<template>
    <AdminLayout>
        <div class="px-4">

            <div class="bg-white rounded-md border shadow-sm text-slate-900 p-4">
                <h1 class="text-xl font-bold mb-4">List Products</h1>
                <div class="h-[65vh] overflow-auto ">
                    <Table
                        type="product"
                        :transaction="products.data"
                        />
                </div>
                <!-- pagination -->
                <div class="flex justify-between items-center mt-4">
                    <div class="flex items-center text-sm">
                        <p class="mr-2">Showing</p>
                        <select class="border border-gray-300 rounded-md p-2 px-4">
                            <option>10</option>
                            <option>20</option>
                            <option>30</option>
                            <option>40</option>
                            <option>50</option>
                        </select>
                        <p class="ml-2">of 100 entries</p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>