<template>
<div class="w-full flex justify-center items-center">
    <div class="container flex flex-col gap-4 mx-8">
        <label class="text-gray-500 font-semibold tracking-wider text-lg">{{month}}</label>
        <div class="bg-gray-100 mb-10 rounded-lg w-full h-auto py-4 flex flex-row justify-between divide-x divide-solid divide-gray-400">
            <div class="relative flex-1 flex flex-col gap-2 px-4">
                <label class="text-gray-800 text-base font-semibold tracking-wider">Positive</label>
                <label class="text-green-800 text-4xl font-bold">{{ positive }}</label>
            </div>
            <div class="relative flex-1 flex flex-col gap-2 px-4">
                <label class="text-gray-800 text-base font-semibold tracking-wider">Neutral</label>
                <label class="text-green-800 text-4xl font-bold">{{ neutral }}</label>
            </div>
            <div class="relative flex-1 flex flex-col gap-2 px-4">
                <label class="text-gray-800 text-base font-semibold tracking-wider">Negative</label>
                <label class="text-green-800 text-4xl font-bold">{{ negative }}</label>
            </div>
        </div>
    </div>
</div>
</template>
<script>

export default{
    data(){
        return{
           positive:"",  
           neutral:"",
           negative:"",
           month:"",
        }
    },
    props:['monthfeeling'],
    beforeUpdate(){
        this.positive = Math.round(this.monthfeeling.positive);
        this.neutral = Math.round(this.monthfeeling.neutral);
        this.negative = Math.round(this.monthfeeling.negative);
        this.month = this.monthfeeling.untilday
    }
}
</script>
