<template>
  <div>
    <Login v-if="!LogIn" :login.sync="LogIn" />
    <App v-else />
  </div>
</template>

<script>
import App from "./app";
import Login from "./login";
export default {
  components: { App, Login },
  data() {
    return {
      LogIn: false,
    };
  },
};
</script>

<style>
</style>