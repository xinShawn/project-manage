<template>
  <main>
    <h2>这是首页内容</h2>
  </main>
</template>

<script>
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
        url: '/api/test/test'
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
