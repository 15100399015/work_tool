<template>
  <div class="container">
    <h1 style="text-align: center">Lingx百度分词自动回传</h1>
    <br />
    <TestPr />
    <TokenManage />
  </div>
</template>

<script>
import TestPr from "./testPr";
import TokenManage from "./tokenManage";
export default {
  name: "App",
  components: { TokenManage, TestPr },
};
</script>


<style lang="css" scoped>
.container {
  position: relative;
}
</style>