<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-center text-gray-800 leading-tight">
              일기쓰듯 솔직하게 적어보세요
            </h2>
        </template>


        <div class="py-12">
            <div class="w-4/5 mx-auto sm:px-6 lg:px-8">
             <div>
                
                     <hash-tags @submitHashTags="submitHashTags" ></hash-tags>
                     <my-worry @submitMyWorry="submitMyWorry"/>
                     <button @click="[submitWorry(), postcontent()]" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white mt-2 py-2 px-4 border border-blue-500 hover:border-transparent rounded">고민제출</button>
                    <worry-resolution :userName="userName" :resolutions="resolutions"></worry-resolution>
                 
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
    import WorryResolution from '@/Pages/WorryResolution.vue'
    import Swal from 'sweetalert2'


    export default {
        components: {
            AppLayout,
            Welcome,
            HashTags,
            MyWorry,
            WorryResolution
        },
       
        data(){
            return{
            finalHashTags:[],
            finalTitle:"",
            finalContent:"",
            resolutions:[],
            userName:"",
            statement:"",
            state:"",
            iconstate:"",
            arraynum:[],
            worryid:0,
            positive:0,
            negative:0,
            neutral:0,
            }
        },
        props:['user'],
        methods:{
        submitWorry(){
            this.emitter.emit("submitWorry");
            axios.post('/createWorry',{
                title : this.finalTitle,
                content : this.finalContent,
                worryHashTags : this.finalHashTags,
            })
            .then(res => {
                console.log(res.data);
                this.resolutions = res.data[0];
                this.worryid = res.data[1];
            })
            .catch(err => alert(err));
        },
        postcontent(){
            axios.post('/checkmyfeeling',{
                content:this.finalContent,
            })
            .then(res => {
                    console.log(res);
                    var resdata = res.data.replace('status_code:200 ','');
                    console.log(resdata);
                    var jsonresdata = JSON.parse(resdata);
                    var obj = jsonresdata.document.confidence;
                    var array = Object.entries(obj);
                    var arraynum = new Array();
                    for(var step = 0 ; step < array.length ; step++){
                        arraynum.push(array[step][1]);
                    }
                    this.arraynum = arraynum;
                    this.positive = arraynum[0];
                    this.negative = arraynum[1];
                    this.neutral = arraynum[2];
                    let max = 0;
                    var statenum = 0;
                    for ( var i = 0; i< arraynum.length; i++){
                        if(arraynum[i] > max ){
                            max = arraynum[i];
                            console.log(max);
                            statenum = i;
                        }
                    };
                    
                    console.log(statenum);
                    if("positive" == array[statenum][0]){
                        this.statement = "좋은 일이네요!"
                        this.state = "긍정"
                         this.iconstate = "success"

                    }
                    if("neutral" == array[statenum][0]){
                        this.statement = "그저 그런 하루~"
                        this.state = "평범"
                         this.iconstate = "success"
                    }
                    if("negative" == array[statenum][0]){
                        this.statement = "감정정화를 통해 내일은 힘차게!"
                        this.state = "부정"
                        this.iconstate = "warning"
                    }
                    Swal.fire({
            title: this.state,
            text: this.statement,
            icon : "success"
          
          

        });
        axios.post('/postmyfeeling',{
            positive : this.positive,
            negative : this.negative,
            neutral : this.neutral,
            worryid : this.worryid,
            title : this.finalTitle,
        })
        .then(res => console.log(res))
        .catch(err => console.log(err));
            })
            .catch(err => console.log(err))
      
        
        },
       
           
        
        submitMyWorry(myworry){
            this.finalTitle = myworry.title;
            this.finalContent = myworry.content;
        },
        submitHashTags(tags){
            this.finalHashTags=tags.tags
        },
        },
        mounted(){
            this.userName = this.user.name;
        }
    }
</script>
