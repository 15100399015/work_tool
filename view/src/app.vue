<template>
  <div style="width:890px;margin:0 auto">
    <div>
      <el-button type="primary" @click="addItem">添加</el-button>
    </div>
    <div>
      <el-row v-for="(item, index) in wxList" :key="index" :gutter="20">
        <br />
        <el-col :span="6">
          <el-input placeholder="微信号" v-model="item.wx" clearable></el-input>
        </el-col>
        <el-col :span="6">
          <el-input placeholder="名字" v-model="item.name" clearable></el-input>
        </el-col>
        <el-col :span="8">
          <el-popover placement="top-start" trigger="hover">
            <el-image style="width: 180px;" v-show="item.qr_url" :src="item.qr_url" fit="cover"></el-image>
            <el-input placeholder="二维码地址" slot="reference" v-model="item.qr_url" :disabled="true"></el-input>
          </el-popover>
        </el-col>
        <el-col :span="2">
          <el-upload
            action="up_qr.php"
            accept="image/*"
            :multiple="false"
            :show-file-list="false"
            :on-success="onSuccess(index)"
            :on-error="onError"
            :on-progress="onProgress"
            :http-request="DiyUpRequest"
          >
            <el-button type="primary">上传</el-button>
          </el-upload>
        </el-col>
        <el-col :span="2">
          <el-button type="danger" @click="delItem(index)">删除</el-button>
        </el-col>
      </el-row>
    </div>
    <br />
    <div>
      <el-button type="primary" @click="submit">提交</el-button>
    </div>
  </div>
</template>

<script>
import Cookie from "js-cookie";
export default {
  name: "App",
  data() {
    return {
      loading: null,
      wxList: [
        {
          wx: "",
          name: "",
          qr_url: "",
        },
      ],
    };
  },

  created() {
    this.getWx();
  },
  methods: {
    // 获取微信
    getWx() {
      this.$axios
        .get("get_original.php")
        .then((res) => {
          if (res.data instanceof Array) return (this.wxList = res.data);
          if (res.data instanceof String) {
            try {
              let wl = JSON.parse(res.data);
              if (wl instanceof Array) {
                return (this.wxList = wl);
              } else new Error();
            } catch (error) {
              console.log(error);
            }
          }
        })
        .catch((err) => {
          this.$message.error(err.response.data);
        });
    },
    // 删除一个项目
    delItem(index) {
      if (this.wxList.length <= 1) {
        return this.$message({
          message: "必须有一个",
          type: "warning",
        });
      }
      this.wxList.splice(index, 1);
    },
    // 添加一个项目
    addItem() {
      this.wxList.push({ wx: "", name: "", qr_url: "" });
    },
    // 提交更改
    submit() {
      // 过滤
      let filterStrRes = JSON.stringify(this.wxList.filter((item) => item.wx));
      // 更新微信
      let formData = new FormData();
      formData.append("weixin", filterStrRes);
      this.$axios
        .post("set_original.php", formData)
        .then(() => {
          this.$message({
            message: "更新成功",
            type: "success",
          });
          this.getWx();
        })
        .catch((err) => {
          this.$message.error(err.response.data);
        });
    },
    // 上传成功
    onSuccess(index) {
      return (res) => {
        this.loading.close();
        let url = res.data;
        this.wxList[index].qr_url = url;
        this.$message({
          message: "上传成功",
          type: "success",
        });
      };
    },
    // 上传失败
    onError(err) {
      this.loading.close();
      this.$message.error(err.response.data);
    },
    // 上传时候
    onProgress() {
      this.loading = this.$loading({
        lock: true,
        text: "上传中，请稍后",
      });
    },
    // 上传方法
    DiyUpRequest({ action, file, filename, onError, onProgress, onSuccess }) {
      onProgress("");
      let formData = new FormData(); //new一个formData事件
      formData.append(filename, file); //将file属性添加到formData里 //此时formData就是我们要向后台传的参数了
      this.$axios.post(action, formData).then(onSuccess, onError);
    },
  },
  mounted() {
    // 检查是否存在cookie
    // 如果不存在则写入cookie
    if (!Cookie.get("_userlogin")) {
      Cookie.set("_userlogin", "true", { expires: 7 });
    }
  },
};
</script>

<style>
</style>
