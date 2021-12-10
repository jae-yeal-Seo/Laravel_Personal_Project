<template>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-2">
    <worry-resolution-item
    v-for="(resolution) in resolutions"
                :key="resolution.id"
                :userName="userName"
                :resolution_id="resolution.id"
                :resolution_content="resolution.content"
                :title="resolution.title"
    >
    </worry-resolution-item>
    </div>
</template>
<script>
import WorryResolutionItem from '@/Pages/WorryResolutionItem'

export default{
    props:['resolutions','userName'],
    components: {
        WorryResolutionItem
    }

}
</script>
