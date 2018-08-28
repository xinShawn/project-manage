<template>
  <div id="app">
    <template v-if="$store.state.auth.isLogin">
      <v-nav></v-nav>
      <keep-alive>
        <router-view></router-view>
      </keep-alive>
      </template>
    <template v-else>
      <v-login></v-login>
    </template>
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
