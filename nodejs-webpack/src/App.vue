<template>
  <div id="app">
    <el-container>
      <!--顶部-->
      <el-header class="pm-header">
        <pm-nav></pm-nav>
      </el-header>

      <!--路由页面-->
      <el-main class="pm-main">
        <router-view/>
      </el-main>
    </el-container>
  </div>
</template>

<script>
  import PmNav from "./components/pm-nav";

  export default {
    name: "App",
    components: {
      "pm-nav": PmNav
    }
  }
</script>

<style>
  #app {
    margin: 0;
    padding: 0;
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
  }

  .pm-header {
    padding: 0;
  }
</style>
