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
