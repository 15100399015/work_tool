<template>
  <div style="width:360px; margin:0 auto;">
    <h1 style="text-align:center">Liangx换号</h1>
    <el-form :model="loginForm" ref="loginForm" label-width="46px" class="demo-ruleForm">
      <el-form-item label="账号" prop="username">
        <el-input type="text" v-model="loginForm.username" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="密码" prop="password">
        <el-input type="password" v-model="loginForm.password" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="submitForm('loginForm')">提交</el-button>
        <el-button @click="resetForm('loginForm')">重置</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>


<script>
export default {
  data() {
    return {
      loginForm: {
        username: "",
        password: "",
      },
    };
  },
  methods: {
    submitForm() {
      if (this.loginForm.username === "admin") {
        if (this.loginForm.password === "123456") {
          this.$message({
            message: "登录成功",
            type: "success",
          });
          this.$emit("update:login", true);
        } else {
          this.$message.error("密码错误");
        }
      } else {
        this.$message.error("账号错误");
      }
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
  },
};
</script>