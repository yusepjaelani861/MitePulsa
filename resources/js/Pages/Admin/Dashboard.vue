<script setup>
import Card from '@/Components/Card.vue'
import Table from '@/Components/Table.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps(['pending_transaction', 'total_transaction', 'total_payout', 'balance'])
</script>

<script>
export default {
    data() {
        return {
            transaction: []
        }
    },
    methods: {
        convertRupiah(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
    },
    components: {
        Card,
        AdminLayout,
        Table,
    }
}
</script>

<template>
    <AdminLayout>
        <div class="grid grid-cols-4 mb-8">
            <Card title="Balance Server" :value="('Rp ' + convertRupiah(balance))" color="#5E72E4" icon=""
                weeklyPerformance="12.4%" />

            <Card title="Total Payout" :value="'Rp ' + convertRupiah(total_payout)" color="#5E72E4" icon=""
                weeklyPerformance="12.4%" />
                
            <Card title="Total Transaction" :value="total_transaction" color="#5E72E4" icon=""
                weeklyPerformance="12.4%" />

            <Card title="Pending Transaction" :value="pending_transaction" color="#5E72E4" icon=""
                weeklyPerformance="12.4%" />
        </div>

        <div id="table" class="w-full p-4">
            <div class="p-4 bg-white rounded-md text-slate-900 border shadow-sm">
                <h1 class="text-xl font-bold mb-4">Table Transactions</h1>
                <div class="h-[500px] overflow-auto">
                    <Table type="transaction" :transaction="transaction" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>