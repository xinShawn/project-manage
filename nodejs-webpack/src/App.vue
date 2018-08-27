<template>
  <div id="app">
    <!-- <router-view/> -->
    <v-nav></v-nav>
    <keep-alive>
      <router-view></router-view>
    </keep-alive>
  </div>
</template>

<script>
import nav from './components/nav/nav'

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
