<template>

<Carousel :items-to-show="1">
    <Slide 
    v-for="monthfeeling in monthfeelings"  
    :key="monthfeeling.untilmonth">
      <div class="carousel__item">
        <real-month-feeling-graph
        :positive="monthfeeling.positive"
        :neutral="monthfeeling.neutral"
        :negative="monthfeeling.negative"
        :month ="monthfeeling.untilmonth"
        ></real-month-feeling-graph>
      </div>
    </Slide>

    <template #addons="{ currentSlide }">
      <Navigation />
      <Pagination />
         <real-month-score
         :monthfeeling="monthfeelings[currentSlide]"
         ></real-month-score>
         
    </template>
  </Carousel>


</template>
<script>
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel';
import RealMonthFeelingGraph from '@/Pages/RealMonthFeelingGraph.vue'
import RealMonthScore from '@/Pages/RealMonthScore.vue';

export default {
    components:{
        Carousel,
         Slide,
        Pagination,
        Navigation,
        RealMonthFeelingGraph,
        RealMonthScore
    },
   data(){
       return{
           monthfeelings:"",
       }
   },

   created(){
       axios.get('/feelingrealmonthgraph')
       .then(res => {
           this.monthfeelings = res.data;
       })
       .catch(err => console.log(err));
   }
}
</script>
