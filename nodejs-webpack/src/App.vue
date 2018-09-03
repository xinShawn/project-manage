<template>
  <div id="app">
      <v-nav></v-nav>
      <keep-alive>
        <router-view></router-view>
      </keep-alive>
  </div>
</template>

<script>
import nav from './views/nav/nav'

export default {
  name: 'App',
  components: {
    'v-nav': nav,
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
    let that = this;
    this.$store.dispatch("checkLogin", (needLogin) => {
      if (needLogin) {
        that.isJumpToLoginPage = true;
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
    }
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
    }
  }
}
</script>

<style lang="scss">
body {
  margin: 0;
  background-color: #efefef;
  min-width: 1024px;
}
#app {
  height: 100%;
  text-align: center;
  a {
    text-decoration: none;
  }
}
main {
  padding: 20px 10px;
}
</style>
