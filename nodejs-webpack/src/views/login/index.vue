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
      // let thisVue = this
      // this.axios.post(UrlUtil.getBaseUrl() + '/user/is-init-admin-user', {}).then((response) => {
      //   let apiReturn = new ApiReturnModel(response)
      //   let isInit = apiReturn.data.isInitAdmin
      //   if (!isInit) {
      //     thisVue.$store.commit('setSysNotInit')
      //   }
      // }).catch((e) => {
      //   console.error(e)
      // })
    }
  }
}
</script>

<style scoped>

</style>
