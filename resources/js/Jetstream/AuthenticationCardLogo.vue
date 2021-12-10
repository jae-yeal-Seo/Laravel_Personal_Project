<template>
    <Link :href="'/'">
        <img src="EmailLogo.png" style="width:120px; height:100px;" alt=""/>
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
    })
</script>
