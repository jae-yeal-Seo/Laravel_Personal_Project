<template>
 <!-- follow me on twitter @asad_codes -->

<main class="py-4">
  <div class="">
    <div class="block justify-center">
      <div class="w-full md:mx-2 mb-4 md:mb-0">
        <div class="bg-white rounded-lg overflow-hidden shadow relative">
          <div class=" h-auto px-2 py-2 md:h-40 border-4 border-light-blue-500 border-opacity-75">
            <a v-bind:href="url" class="block text-blue-500 hover:text-blue-600 font-semibold mb-2 text-lg md:text-base lg:text-lg">
              {{ title }}
            </a>
            <div class="text-gray-600 text-sm leading-relaxed block md:text-xs lg:text-sm">
              {{ userName }}
            </div>
          <div class='my-3 flex flex-wrap -m-1'>
                <span class="m-1 bg-gray-200 hover:bg-gray-300 rounded-full px-2 font-bold text-sm leading-loose cursor-pointer"
                v-for="(wrhashtag) in wrhashtags"
              :key="wrhashtag.id" >{{ wrhashtag.hashtag }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Does this resource worth a follow? -->
</template>
<script>
export default{
    data(){
      return{
        wrhashtags:[],
        url:'',
      }
    },
   
    props:['resolution_id','title','userName','resolution_content'],
    mounted(){
      axios.get('/worryresolutionHashTags/'+this.resolution_id)
      .then(response => this.wrhashtags = response.data)
      .catch(error => console.log(error));

      this.url = '/getresolution/'+this.resolution_id;
    },
    methods:{
     
    }
    
}
</script>
