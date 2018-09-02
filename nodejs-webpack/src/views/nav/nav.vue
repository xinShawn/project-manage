<template>
  <main v-if="$store.getters.isLogin">
    <el-header>
      <h1>后台管理系统</h1>
      <!-- 导航菜单 -->
      <el-menu :default-active="activeName" class="nav" mode="horizontal" background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">
        <el-menu-item :index="item.link" :key="index" v-for="(item, index) in links">
          <router-link :to="item.link">{{item.name}}</router-link>
        </el-menu-item>
      </el-menu>
      <!-- 搜索框 -->
      <el-form class="search">
        <el-select size="mini" popper-class="options" class="search-select" v-model="searchOption">
          <el-option v-for="(item, index) in searchs" :key="index" :label="item" :value="item">
          </el-option>
        </el-select>
        <el-input class="search-content" size="mini" placeholder="搜索的内容"></el-input>
        <el-button size="mini" type="info">搜索</el-button>
      </el-form>
      <!-- 用户名 -->
    </el-header>
  </main>
</template>

<script>
export default {
  data() {
    return {
      // 导航名称与路由地址
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
      }],
      // 搜索的选项列表
      searchs: [
        'Bug', '任务', '项目', '用户', '发布', '测试单'
      ],
      searchOption: '任务'
    }
  },
  created () {
  },
  computed: {
    activeName () {
      return this.$route.name
    }
  },
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
    .search {
      float: right;
      font-size: 0;
      margin-top: 16px;
      .search-select {
        width: 100px;
      }
      .search-content {
        width: 140px;
      }
      &>* {
        display: inline-block;
      }
      * {
        border-radius: 0;
      }
    }
  }
</style>
<style lang="scss">
  .el-input__inner {
    border: none;
    border: {
      radius: 0;
      right: 1px #545C64 solid;
    }
  }
  .search-content {
    .el-input__inner {
      border: none;
      &::placeholder {
        color: #ffffff;
      }
    }
  }
  .options {
    .el-select-dropdown__item {
      font-size: 12px;
    }
  }
</style>
