<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-center text-gray-800 leading-tight">
              나의 글이 누군가에겐 큰 도움이 됩니다.
            </h2>
        </template>


        <div class="py-12">
            <div class="w-4/5 mx-auto sm:px-6 lg:px-8">
             <div>
                
                     <resolution-hash-tags @submitResolutionHashTags="submitResolutionHashTags" ></resolution-hash-tags>
                     <my-resolution @submitMyResolution="submitMyResolution"/>
                     <button @click="submitResolution" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white mt-2 py-2 px-4 border border-blue-500 hover:border-transparent rounded">도와주기</button>

                 
            </div>
        </div>
        </div>
    </app-layout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import ResolutionHashTags from '@/Pages/ResolutionHashTags.vue'
    import MyResolution from '@/Pages/MyResolution.vue'

    export default {
        components: {
            AppLayout,
            Welcome,
            ResolutionHashTags,
            MyResolution
        },
       

            data(){
            return{
            finalHashTags:[],
            finalTitle:"",
            finalContent:"",
            }
           

        },
        methods:{
        submitResolution(){
            this.emitter.emit("submitResolution");
            axios.post('/createResolution',{
                title : this.finalTitle,
                content : this.finalContent,
                ResolutionHashTags : this.finalHashTags,
            })
            .then(res => console.log(res))
            .catch(err => alert(err));

        
        },
        submitMyResolution(myresolution){
            this.finalTitle = myresolution.title;
            this.finalContent = myresolution.content;
        },
        submitResolutionHashTags(tags){
            this.finalHashTags=tags.tags
        },
        },
    }
</script>
