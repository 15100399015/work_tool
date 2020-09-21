<template>
  <div>
    <Login v-if="!LogIn" :login.sync="LogIn" />
    <App v-else />
  </div>
</template>

<script>
import App from "./app";
import Login from "./login";
import Cookie from "js-cookie";

export default {
  components: { App, Login },
  data() {
    return {
      LogIn: false,
    };
  },
  mounted() {
    // 获取cookie，如果存在则说明之前登录过，直接跳到app
    if (Cookie.get("_userlogin")) this.LogIn = true;
  },
};
</script>

<style>
</style>