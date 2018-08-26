<template>
  <el-header>
    <h1>后台管理系统</h1>
    <el-menu :default-active="activeName" class="nav" mode="horizontal" background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">
      <el-menu-item :index="item.link" :key="index" v-for="(item, index) in links">
        <router-link :to="item.link">{{item.name}}</router-link>
      </el-menu-item>
    </el-menu>
  </el-header>
</template>

<script>
export default {
  data: () => {
    return {
      links: [{
        name: '我的地盘',
        link: 'main'
      }, {
        name: '任务列表',
        link: 'missions'
      }, {
        name: '项目管理',
        link: 'projects'
      }, {
        name: '后台管理',
        link: 'backend'
      }]
    }
  },
  computed: {
    activeName () {
      return this.$route.name
    }
  }
}
</script>

<style lang="scss" scoped>
  header {
    $line-height: 60px;
    background-color: rgb(84, 92, 100);
    h1 {
      float: left;
      color: #ffffff;
      margin: 0;
      line-height: $line-height;
    }
    .nav {
      margin-left: 100px;
      float: left;
      li {
        padding: 0;
        a {
          display: inline-block;
          padding: 0 20px;
          line-height: $line-height;
          font-size: 16px;
        }
      }
    }
  }
</style>
