<template>
  <main id="loginIndex">

  </main>
</template>

<script>
  import login from './login'
  import init from './init'

  /**
   * 登录的主页
   */
  export default {
    name: "index",
    components: {
      'v-login-page': login,
      'v-init-page': init
    },
    data: () => {
      return {
        isInit: true
      }
    },
    created: function () {
      this.requestInitData()
    },
    methods: {
      /**
       * 是否已经初始化了管理员账号
       */
      requestInitData () {
        this.axios.post('/api')
      }
    }
  }
</script>

<style scoped>

</style>
