<template>
  <div id="app">
    <Nav></Nav>
    <keep-alive>
      <router-view></router-view>
    </keep-alive>
  </div>
</template>

<script>
import Nav from './views/nav/Nav'

export default {
  name: 'App',
  components: {
    Nav,
  },
  data () {
    return {
      /**
       * 是否跳转到登录页面
       */
      isJumpToLoginPage: false
    }
  },
  created() {
    this.$store.dispatch("checkLogin", (needLogin) => {
      if (needLogin) {
        this.isJumpToLoginPage = true;
      }
    });
  },
  mounted() {
  },
  computed: {
    /**
     * 获取登录状态
     */
    isLogin () {
      return this.$store.state.auth.loginStatus;
    },
  },
  watch: {
    /**
     * 监听登录状态，一旦不是登录状态则跳转到登录页面
     * @param val
     */
    isLogin(val) {
      if (!val) {
        this.$router.push("/login");
      }
    },
  
    /**
     * 是否需要跳转到登陆页面
     * @param val
     */
    isJumpToLoginPage (val) {
      if (val) {
        this.$router.push("/login");
      }
    },
  }
}
</script>

<style lang="scss">
  body {
    background-color: #efefef;
  }
  
  html, body, main {
    margin: 0;
    padding: 0;
    height: 100%;
  }
  
  div, article, section, footer, nav, header {
    margin: 0;
    padding: 0;
  }
  
  #app {
    height: 100%;
    a {
      text-decoration: none;
    }
  }
</style>
