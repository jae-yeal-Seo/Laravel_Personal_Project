<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-center text-gray-800 leading-tight">
              자유롭게 나의 고민을 적어보세요
            </h2>
        </template>


        <div class="py-12">
            <div class="w-3/5 mx-auto sm:px-6 lg:px-8">
             <div>
                
                     <hash-tags @submitHashTags="submitHashTags" ></hash-tags>
                     <my-worry @submitMyWorry="submitMyWorry"/>
                     <button @click="submitWorry" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white mt-2 py-2 px-4 border border-blue-500 hover:border-transparent rounded">걱정제출</button>

                 
            </div>
        </div>
        </div>
    </app-layout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import HashTags from '@/Pages/WriteWorry/HashTags.vue'
    import MyWorry from '@/Pages/MyWorry.vue'

    export default {
        components: {
            AppLayout,
            Welcome,
            HashTags,
            MyWorry
        },
       
        data(){
            return{
            finalHashTags:[],
            finalTitle:"",
            finalContent:"",

            }
           

        },
        methods:{
        submitWorry(){
            this.emitter.emit("submitWorry");
            axios.post('/createWorry',{
                title : this.finalTitle,
                content : this.finalContent,
                worryHashTags : this.finalHashTags,
            })
            .then(res => {
                console.log(res)
            })
            .catch(err => alert(err));

            axios.get('/getworryresolution',{
                    finalHashTags : this.finalHashTags,
            })
            .then(res => console.log(res))
            .catch(err => console.log(err));
            
        },
        submitMyWorry(myworry){
            this.finalTitle = myworry.title;
            this.finalContent = myworry.content;
        },
        submitHashTags(tags){
            this.finalHashTags=tags.tags
        },
        },
    }
</script>
