<template>
  <div class="toolBox">
    <el-tabs v-model="activeName" type="card" @tab-click="getTokenByNowPr">
      <el-tab-pane
        v-for="item of prItems"
        :key="item.probability"
        :label="item.title"
        :name="item.probability"
      >
        <input-token
          :probability="item.probability"
          :fill="item.value"
          @handleSubmit="handleSubmit"
        />
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import InputToken from "./components/inputToken";
export default {
  name: "TokenManage",
  components: { InputToken },
  data() {
    return {
      fetchUrl: "http://localhost/get_token.php",
      updateUrl: "http://localhost/set_token.php",
      prItems: [
        {
          title: "100%机率",
          probability: "100",
          value: "",
        },
        {
          title: "80%机率",
          probability: "80",
          value: "",
        },
        {
          title: "60%机率",
          probability: "60",
          value: "",
        },
        {
          title: "50%机率",
          probability: "50",
          value: "",
        },
        {
          title: "40%机率",
          probability: "40",
          value: "",
        },
      ],
      activeName: "50",
    };
  },
  // 初始化请求
  created() {
    this.getTokenByNowPr();
  },
  methods: {
    getTokenByNowPr() {
      this.fetchTokenByProbability(this.activeName).then((data) => {
        for (let i = 0; i < this.prItems.length; i++) {
          const element = this.prItems[i];
          if (element.probability == this.activeName) {
            element.value = this.tokensToVal(data);
          }
        }
      });
    },
    // 处理提交事件
    handleSubmit(pr, value) {
      let tokenArray = this.valToTokenArray(value);
      console.log(tokenArray);
      this.updateToken(pr, tokenArray).then(() => {
        this.$message({
          message: "上传成功",
          type: "success",
        });
        this.getTokenByNowPr();
      });
    },
    valToTokenArray(value) {
      let tokenArray = value
        .replace(/ /g, "")
        .replace(/，/g, ",")
        .replace(/\r/g, "")
        .replace(/\n/g, "")
        .replace(/\r\n/g, "")
        .replace(/^,/g, "")
        .replace(/,$/g, "")
        .split(",");
      return [...new Set(tokenArray)];
    },
    tokensToVal(value) {
      return value.join(",\n");
    },
    // 获取词
    fetchTokenByProbability(pr) {
      console.log(pr);
      const loading = this.$loading({
        lock: true,
        text: "Loading",
      });
      return this.$axios({
        method: "GET",
        url: this.fetchUrl,
        params: { pr },
      }).then(async ({ data }) => {
        await this.sleep(600);
        loading.close();
        return data;
      });
    },
    // 上传词
    updateToken(pr, tokens) {
      console.log(tokens);
      const loading = this.$loading({
        lock: true,
        text: "Loading",
      });
      let formData = new FormData();
      formData.append("pr", pr);
      formData.append("tokens", tokens);
      return this.$axios({
        method: "POST",
        url: this.updateUrl,
        data: formData,
      }).then(async ({ data }) => {
        await this.sleep(600);
        loading.close();
        return data;
      });
    },
    sleep(time) {
      return new Promise((res) => setTimeout(res, time));
    },
  },
};
</script>


<style lang="css" scoped>
.toolBox {
  width: 890px;
  margin: 15px auto;
}
</style>