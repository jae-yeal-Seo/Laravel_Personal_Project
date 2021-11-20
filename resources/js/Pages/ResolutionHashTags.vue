<template>
<div>
<p style="font-size:15px" class="font-black">걱정키워드적기</p>
  <div class="comp_hashtag" @click="setHashtags" ref="group">
    <p class="help" v-if="helpVisible">{{ defaultPlaceholder }}</p>

    <!-- Hashtags -->
    <div class="tags" v-if="!helpVisible">
      <input
        type="text"
        class="fake"
        ref="fake"
        @keydown.backspace.prevent="deleteTag(focusIndex)"
        @keydown.delete.prevent="deleteTag(focusIndex)"
      />
      <span
        class="tag"
        v-for="(row, index) in tags"
        :key="index"
        :class="{ active: row.select }"
        @click="selectTag(index)"
        >{{ row.value }}</span
      >
    </div>
    <!--// Hashtags -->

    <div class="inp" v-show="!helpVisible">
      <input id="iinp"
        type="text"
        ref="input"
        v-model.trim="value"
        @focus="initSelect"
        @keydown.space.prevent="addHashTags"
        @keydown.enter.prevent="addHashTags"
        @keydown.backspace="initErrorMsg"
        @keydown.delete="initErrorMsg"
        placeholder="태그입력"
      />
    </div>
</div>

    <transition
      enter-active-class="animate__animated animate__fadeInDown animate__faster"
      leave-active-class="animate__animated animate__fadeOut"
    >
      <p class="noti" v-if="this.errorMsg">{{ errorMsg }}</p>
    </transition>
  </div>
</template>

<script>

export default {
  name: "Hashtags",
  props: ["placeholder"],
  data() {
    return {
      defaultPlaceholder: this.placeholder
        ? this.placeholder
        : "#걱정키워드 #특수문자제외",
      errorMsg: null,
      focusIndex: null,
      helpVisible: true,
      tags: [],
      value: "",
    };
  },
  methods: {
    submitResolutionHashTags(){
      this.$emit("submitResolutionHashTags",{
        tags : this.tags,
      });
    },
    setVisible() {
      return (this.helpVisible = false);
    },
    async setHashtags() {
      if (this.tags.length > 0) {
        return;
      }

      const result = await this.setVisible();

      if (!result) this.$refs.input.focus();
    },

    addTag() {
      this.tags.push({ value: this.value, select: false });
      return true;
    },
    unselectTag() {
      this.tags.forEach((tag) => (tag.select = false));
    },
    selectTag(idx) {
      if (this.tags.some((tag) => tag.select)) {
        this.unselectTag();
      }

      this.tags[idx].select = !this.tags[idx].select;

      if (!this.tags[idx].select) {
        this.initSelectIndex();
        return;
      }

      this.$refs.fake.focus();
      this.focusIndex = idx;
    },
    deleteTag(idx) {
      if (idx === null) {
        return;
      }

      this.initSelectIndex();
      this.tags.splice(idx, 1);
    },

    initSelect() {
      if (!this.tags.some((tag) => tag.select)) {
        return;
      }

      this.unselectTag();
      this.initSelectIndex();
    },
    initSelectIndex() {
      this.focusIndex = null;
    },
    initErrorMsg() {
      this.errorMsg = null;
    },
    validate() {
      if (this.tags.some((tag) => tag.value === this.value)) {
        return "중복된 단어를 입력하셨습니다.";
      }

      const regex = /[~!@#$%^&*()+|<>?:{},.="':;/-]/;
      if (regex.test(this.value)) {
        return "특수문자는 태그로 등록할 수 없습니다.";
      }

      return false;
    },
    async addHashTags(event) {
      // CASE 공백
      if (event.target.value === "") {
        this.initErrorMsg();
        event.target.focus();
        return;
      }
      // CASE 유효성(중복,특문)
      const resultMsg = await this.validate();
      if (resultMsg) {
        this.errorMsg = resultMsg;
        this.$refs.input.focus();
        return;
      }

      await this.addTag();

      this.errorMsg = null;
      this.value = null;
      this.$refs.input.focus();
    },
  },
  mounted() {
      this.emitter.on("submitResolution",  ()=>this.submitResolutionHashTags());
    },
  created(){
    
  }
};
</script>

<style lang="scss" scoped>
.comp_hashtag {
  position: relative;
  width: 100%;
  padding: 10px 5px 3px 3px;
  border: 1px solid #ddd;
  border-radius: 4px;
  min-height: 50px;
  margin: 10px auto;
  text-align: left;
  box-sizing: border-box;

  .noti {
    position: absolute;
    left: 0;
    top: 100%;
    font-size: 12px;
    margin-top: 5px;
    padding: 0 5px;
    border-radius: 4px;
    border: 1px solid #ea2136;
    color: #ea2136;
    text-align: left;
    line-height: 2;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }

  .help {
    padding: 0;
    margin: 0;
    line-height: 30px;
    font-weight: 900;
    font-size: 14px;
    color: #6b7280;
    vertical-align: top;
  }

  .tags {
    position: relative;
    overflow: hidden;
    display: inline-block;
    vertical-align: top;
    margin-bottom: -6px;

    .fake {
      position: absolute;
      width: 1px;
      height: 1px;
      left: -1px;
      right: -1px;
      padding: 0;
      border: 0;
      outline: none;
      -webkit-appearance: none;
      -webkit-text-size-adjust: none;
    }
    .tag {
      display: inline-block;
      position: relative;
      margin: 0 5px 6px 0;
      padding: 0 5px;
      line-height: 30px;
      border-radius: 5px;
      background-color: #eee;
      vertical-align: top;
      word-wrap: break-word;
      word-break: break-all;
      font-size: 13px;
      text-align: left;
      &:hover:after {
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        border: 1px solid #aaa;
        content: "";
        border-radius: 5px;
      }

      &:before {
        display: inline;
        content: "#";
      }

      &.active {
        background-color: #656565;
        color: #fff;
        &:hover:after {
          display: none;
        }
      }
    }
  }



  #iinp{
    width:70px;
    border-radius:5px;
    border:3px solid black;
    font-size:12px;
  }

  .inp {
    display: inline-block;
    overflow: hidden;
    height: 30px;
    width: 150px;
    vertical-align: top;
    font-family: "Noto Sans KR", "Malgun Gothic", "굴림", Gulim, "돋움", Dotum,
      Sans-serif;

    &:before {
      display: inline;
      position: relative;
      top: -1px;
      content: "#";
      color: #3e3e3e;
      margin-right: 2px;
      vertical-align: top;
      line-height: 30px;
    }

    input {
      width: 135px;
      height: 28px;
      vertical-align: top;
      color: #3e3e3e;
      -webkit-appearance: none;
      -webkit-text-size-adjust: none;
      padding: 0;
      border: 0;
      outline: none;
      vertical-align: top;
      font-family: "Noto Sans KR", "Malgun Gothic", "굴림", Gulim, "돋움", Dotum,
        Sans-serif;
    }
  }
}
</style>
