<template>
  <div>
    <div>
      <el-input
        type="textarea"
        :rows="28"
        placeholder="请输入关键词"
        v-model="textarea"
      >
      </el-input>
    </div>
    <div style="margin-top: 15px">
      <el-button type="primary" @click="handleSubmit">提交</el-button>
    </div>
  </div>
</template>

<script>
export default {
  // probability 为纪律值
  // fill 预先填充数据
  props: ["probability", "fill"],
  data() {
    return {
      textarea: "",
    };
  },
  watch: {
    fill(value) {
      this.textarea = value;
    },
  },
  methods: {
    handleSubmit() {
      this.$emit("handleSubmit", this.probability, this.textarea);
    },
  },
};
</script>

<style>
</style>