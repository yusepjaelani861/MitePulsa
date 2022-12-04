<script setup>

</script>

<script>
export default { 
    props: ['title' , 'value', 'color', 'icon', 'weeklyPerformance'],
    data() {
        return {
            //
        }
    },
    methods: {
        convertRupiah(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    }
}
</script>

<template>
    <div class="bg-white text-slate-900 rounded-lg shadow-sm mx-4" style="background-color: {{ color }};">
        <div class="flex justify-between p-4">
            <div class="">
                <p class="text-2xl font-semibold">{{ value }}</p>
                <h1 class="text-lg font-semibold">{{ title }}</h1>
                <p class="text-sm text-left text-green-500 font-bold mt-2">{{ weeklyPerformance }} from last week</p>
            </div>
            <div>
                <svg v-if="icon == ''" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z"
                        fill="#F5365C" />
                    <path
                        d="M20.4286 25.5714V30.7143H17.8571V25.5714H20.4286ZM24.2857 20.4286V30.7143H21.7143V20.4286H24.2857ZM34.5714 32V33.2857H14V17.8571H15.2857V32H34.5714ZM28.1429 23V30.7143H25.5714V23H28.1429ZM32 19.1429V30.7143H29.4286V19.1429H32Z"
                        fill="white" />
                </svg>
                <img v-else :src="icon" class="w-12 h-12" />
            </div>
        </div>
    </div>
</template>