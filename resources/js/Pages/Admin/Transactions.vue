<script setup>
import Card from '@/Components/Card.vue';
import Table from '@/Components/Table.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps(['transactions', 'total_transaction', 'total_payment'])
</script>

<script>
export default {
    data() {
        return {
            transaction: []
        };
    },
    methods: {
        convertRupiah(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    },
    components: { AdminLayout, Card, Table }
}
</script>

<template>
    <AdminLayout>
        <div class="grid grid-cols-2 mb-8">
            <Card title="Total Transaction" :value="total_transaction" color="#5E72E4" icon=""
                weeklyPerformance="0%" />
            <Card title="Total Payout" :value="'Rp ' + convertRupiah(total_payment)" color="#5E72E4" icon=""
                weeklyPerformance="0%" />
        </div>

        <div id="table" class="w-full p-4">
            <div class="p-4 bg-white rounded-md text-slate-900 border shadow-sm">
                <h1 class="text-xl font-bold mb-4">Table Transactions</h1>
                <div class="h-[500px] overflow-auto">
                    <Table type="transaction" :transaction="transactions.data" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>