<template>
  <main id='loginIndex'>
    <template v-if="$store.state.auth.isInit">
      need login
    </template>
    <template v-else>
      <v-init-page></v-init-page>
    </template>
  </main>
</template>

<script>
import login from './login'
import init from './init'
import ApiReturnModel from '../../models/ApiReturnModel';

/**
 * 登录的主页
 */
export default {
  name: 'index',
  components: {
    'v-login-page': login,
    'v-init-page': init
  },
  data: () => {
    return {
    }
  },
  created: function () {
    this.requestIsInitAdmin()
  },
  mounted: function () {
  },
  methods: {
    /**
     * 请求查看是否已经初始化了管理员账号
     */
    requestIsInitAdmin () {
      this.$store.dispatch("setIsInitAdmin");
      
      console.log(this.$store.state);
    }
  }
}
</script>

<style scoped>

</style>
