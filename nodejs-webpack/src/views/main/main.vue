<template>
  <main>
    <h2>这是首页内容</h2>
  </main>
</template>

<script>
import UrlUtil from './../../utils/UtlUtil'

export default {
  data: function () {
    return {}
  },
  created: function () {
    this.testAjax()
  },
  methods: {
    testAjax () {
      this.axios({
        url: UrlUtil.getBaseUrl() + '/test/test'
      }).then((res) => {
        console.log(res)
      }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>

<style>
</style>
