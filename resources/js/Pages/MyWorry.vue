<template>
    <div class="h-full">
        <label for="about" class="block text-sm font-black"> 고민제목 </label>
        <div class="md:w-full">
            <input
                class="
                    font-black
                    bg-white-200
                    appearance-none
                    border-2 border-gray-200
                    rounded
                    w-full
                    py-2
                    px-4
                    text-black-500
                    leading-tight
                    focus:outline-none focus:bg-white focus:border-purple-500
                "
                v-model="title"
                id="inline-full-name"
                type="text"
                placeholder="고민제목"
            />
        </div>
        <label for="about" class="block text-sm font-black">고민적기 </label>
        <div class="mt-1">
            <textarea
                v-model="content"
                id="content"
                name="content"
                rows="3"
                class="
                    font-black
                    shadow-sm
                    focus:ring-indigo-500
                    resize-none
                    focus:border-indigo-500
                    mt-1
                    block
                    w-full
                    sm:text-sm
                    border border-gray-300
                    rounded-md
                "
                placeholder="고민을 자유롭게 적어보세요"
            ></textarea>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            content: "",
            title: "",
        };
    },
    methods: {
        submitMyWorry() {
            this.$emit("submitMyWorry", {
                title : this.title,
                content : this.content,
            });
        },
    },
    mounted() {
      this.emitter.on("submitWorry", ()=> this.submitMyWorry());
    },
};
</script>
