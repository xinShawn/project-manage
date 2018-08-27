<template>
  <main id='loginIndex'>
    <template v-if="$store.getters.isInit">
      need login
    </template>
    <template v-else>
      need init
    </template>
  </main>
</template>

<script>
import login from './login'
import init from './init'
import UrlUtil from './../../utils/UtlUtil'
import ApiReturnModel from '../../models/ApiReturnModel'

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
  methods: {
    /**
     * 请求查看是否已经初始化了管理员账号
     */
    requestIsInitAdmin () {
      this.axios.post(UrlUtil.getBaseUrl() + '/user/is-init-admin-user', {}).then((response) => {
        let ret = new ApiReturnModel(response)
        console.log(ret.code)
      }).catch((e) => {
        console.error(e)
      })
    }
  }
}
</script>

<style scoped>

</style>
