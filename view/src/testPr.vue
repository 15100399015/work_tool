<template>
  <div class="testBox">
    <div class="openTestBtn" @click="dialogVisible = true">
      <el-button icon="el-icon-edit" type="primary" circle></el-button>
    </div>
    <el-dialog
      title="触发测试"
      width="380px"
      :center="true"
      :destroy-on-close="true"
      :visible.sync="dialogVisible"
    >
      <div>
        <div class="input-line">
          <el-input v-model="input" placeholder="请输入关键字"></el-input>
          <el-button
            style="width: 126px"
            type="primary"
            :loading="loading"
            @click="handleTest"
            >测试</el-button
          >
        </div>
        <div>
          <p>概率信息：{{ prInfo }}</p>
          <p>结果：{{ result }}</p>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      testUrl: "http://localhost/verify.php",
      dialogVisible: false,
      loading: false,
      input: "",
      result: "",
      prInfo: "",
    };
  },
  methods: {
    handleTest() {
      if (this.input === "") return;
      this.fetchTestRes(this.input).then((data) => {
        if (data.existence) {
          this.prInfo = data.pr.join();
          let triggerPr = data.pr.sort((a, b) => a - b)[0];
          let randomNum = Math.floor(Math.random() * (1 - 100) + 100);
          if (triggerPr >= randomNum) {
            this.result = "执行";
          } else {
            this.result = "不执行";
          }
        } else {
          this.$message.error("词库中没有这个词哦");
        }
      });
    },
    fetchTestRes(token) {
      this.loading = true;
      return this.$axios({
        method: "GET",
        url: this.testUrl,
        params: { token },
      }).then(({ data }) => {
        this.loading = false;
        return data;
      });
    },
  },
};
</script>

<style>
.testBox {
  position: absolute;
}
.input-line {
  display: flex;
}
.openTestBtn {
  position: fixed;
  z-index: 100;
  top: 45%;
  left: 15px;
}
</style>