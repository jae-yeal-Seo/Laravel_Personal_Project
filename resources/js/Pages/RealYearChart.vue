<template>

<Carousel :items-to-show="1">
    <Slide 
    v-for="yearfeeling in yearfeelings"  
    :key="yearfeeling.untilyear">
      <div class="carousel__item">
        <real-year-feeling-graph
        :positive="yearfeeling.positive"
        :neutral="yearfeeling.neutral"
        :negative="yearfeeling.negative"
        :year ="yearfeeling.untilyear"
        ></real-year-feeling-graph>
      </div>
    </Slide>

    <template #addons="{ currentSlide }">
      <Navigation />
      <Pagination />
         <real-year-score
         :yearfeeling="yearfeelings[currentSlide]"
         ></real-year-score>
         
    </template>
  </Carousel>


</template>
<script>
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel';
import RealYearFeelingGraph from '@/Pages/RealYearFeelingGraph.vue'
import RealYearScore from '@/Pages/RealYearScore.vue';

export default {
    components:{
        Carousel,
         Slide,
        Pagination,
        Navigation,
        RealYearFeelingGraph,
        RealYearScore
    },
   data(){
       return{
           yearfeelings:"",
       }
   },

   created(){
       axios.get('/feelingrealyeargraph')
       .then(res => {
           this.yearfeelings = res.data;
       })
       .catch(err => console.log(err));
   }
}
</script>
