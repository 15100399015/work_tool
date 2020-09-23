<template>
  <div class="registerBox">
    <div style="width:360px">
      <h1 style="text-align:center">Lingx换号</h1>
      <el-form :model="loginForm" ref="loginForm" label-width="46px">
        <el-form-item label="账号" prop="username">
          <el-input type="text" v-model="loginForm.username"></el-input>
        </el-form-item>
        <el-form-item label="密码" prop="password">
          <el-input type="password" v-model="loginForm.password" @keyup.enter.native="submitForm"></el-input>
        </el-form-item>
        <el-form-item>
          <el-checkbox v-model="recordslog">7天免登录</el-checkbox>
        </el-form-item>
        <el-form-item>
          <el-button @click="submitForm" type="primary">登录</el-button>
          <el-button @click="resetForm">重置</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
import Cookie from "js-cookie";
export default {
  data() {
    return {
      // 记录登录
      recordslog: true,
      // 表单项目
      loginForm: {
        username: "",
        password: "",
      },
      // 用户信息
      user: {
        username: "admin",
        password: "123456",
      },
    };
  },
  methods: {
    // 登录
    submitForm() {
      if (this.loginForm.username !== this.user.username)
        return this.$message.error("账号错误");
      if (this.loginForm.password !== this.user.password)
        return this.$message.error("密码错误");
      this.$message({
        message: "登录成功",
        type: "success",
      });
      if (this.recordslog) {
        Cookie.set("_userlogin", "true", {
          expires: 7,
        });
      } else {
        Cookie.remove("_userlogin");
      }
      this.$emit("update:login", true);
    },
    // 重置表单
    resetForm() {
      this.$refs.loginForm.resetFields();
    },
  },
};
</script>

<style lang="css" scoped>
.registerBox {
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>