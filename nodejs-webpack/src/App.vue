<template>
  <div id="app">
    <template v-if="true">
      <v-nav></v-nav>
      <keep-alive>
        <router-view></router-view>
      </keep-alive>
      </template>
    <template v-else>
    </template>
  </div>
</template>

<script>
import nav from './views/nav/nav'

export default {
  name: 'App',
  components: {
    'v-nav': nav
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
  text-align: center;
  a {
    text-decoration: none;
  }
}
</style>
