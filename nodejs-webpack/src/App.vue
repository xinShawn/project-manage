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
import login from './views/login/index'

export default {
  name: 'App',
  components: {
    'v-nav': nav,
    'v-login': login
  }
}
</script>

<style lang="scss">
body {
  margin: 0;
  background-color: #efefef;
  min-width: 1024px;
}
html, body, article, main {
  height: 100%;
}
#app {
  height: 100%;
  text-align: center;
  a {
    text-decoration: none;
  }
}
</style>
