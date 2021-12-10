<template>
<app-layout>
        <template #header>
            <h2 class="font-semibold text-center text-gray-800 leading-tight">
                나의 변화를 관찰해 봅시다
            </h2>
        </template>

        <div class="grid grid-cols-9 place-items-center h-16">
  <div></div>
  <div></div>
  <div></div>
<div>
<input type="radio" id="Day" value="Day" v-model="picked">
<label for="day" class="ml-5">일간</label>
</div>
<div>
<input class ="ml-5" type="radio" id="Month" value="Month" v-model="picked">
<label for="month" class="ml-5">월간</label>
</div>
<div>
<input class ="ml-5" type="radio" id="Year" value="Year" v-model="picked">
<label for="year" class="ml-5">연간</label>
</div>
<div></div>
<div></div>
  <div></div>
</div>

    <real-day-chart
    v-if="picked === 'Day'"
    ></real-day-chart>

    <real-month-chart
    v-if="picked === 'Month'"
    ></real-month-chart>

     <real-year-chart
    v-if="picked === 'Year'"
    ></real-year-chart>



</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import 'vue3-carousel/dist/carousel.css';
import RealDayChart from '@/Pages/RealDayChart.vue';
import RealMonthChart from '@/Pages/RealMonthChart.vue';
import RealYearChart from '@/Pages/RealYearChart.vue';

export default {
    components:{
    AppLayout,
    RealDayChart,
    RealMonthChart,
    RealYearChart
    },
    data(){
        return{
            picked:"Day",
        }
    }
}
</script>
