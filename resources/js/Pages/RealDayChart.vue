<template>


<Carousel :items-to-show="1">
    <Slide 
    v-for="dayfeeling in dayfeelings"  
    :key="dayfeeling.untilday">
      <div class="carousel__item">
        <real-day-feeling-graph
        :positive="dayfeeling.positive"
        :neutral="dayfeeling.neutral"
        :negative="dayfeeling.negative"
        :day ="dayfeeling.untilday"
        ></real-day-feeling-graph>
      </div>
    </Slide>

    <template #addons="{ currentSlide }">
      <Navigation />
      <Pagination />
         <real-day-score
         :dayfeeling="dayfeelings[currentSlide]"
         ></real-day-score>
         
    </template>
  </Carousel>

</template>
<script>
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel';
import RealDayScore from '@/Pages/RealDayScore.vue';
import RealDayFeelingGraph from '@/Pages/RealDayFeelingGraph.vue'

export default {
   components: {
    Carousel,
    Slide,
    Pagination,
    Navigation,
    RealDayScore,
    RealDayFeelingGraph
  },
  data(){
    return{
      dayfeelings:"",
    }
  },
  created(){
      axios.get('/feelingrealdaygraph')
      .then(res => {
        this.dayfeelings = res.data;
      })
      .catch(err => console.log(err));

      let ckeditor = document.createElement("script");
        ckeditor.setAttribute("src", "https://unpkg.com/tailwindcss-jit-cdn");
        document.head.appendChild(ckeditor);
  }
}
</script>


<style>
.carousel__item {
  max-width: 600px;
  max-height: 500px;
  background-color: rgba(255, 255, 255);
  color:  var(--vc-clr-white);
  font-size: 20px;
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.carousel__slide {
  padding: 10px;
}

.carousel__prev,
.carousel__next {
  box-sizing: content-box;
  border: 5px solid white;
}
</style>

