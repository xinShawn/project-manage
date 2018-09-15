<template>
  <main id="nav" v-if="$store.getters.isLogin">
    <el-header>
      <h1>{{ $t("backend manage system") }}</h1>
      <!-- 导航菜单 -->
      <el-menu :default-active="activeName" class="nav" mode="horizontal" background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">
        <el-menu-item :index="item.link" :key="index" v-for="(item, index) in links">
          <router-link :to="item.link">{{ item.name }}</router-link>
        </el-menu-item>
      </el-menu>
      <!-- 搜索框 -->
      <el-form class="search">
        <el-select size="mini" popper-class="options" class="search-select" v-model="searchOption" value="">
          <el-option v-for="(item, index) in searchs" :key="index" :label="item" :value="item">
          </el-option>
        </el-select>
        <el-input class="search-content" size="mini" :placeholder="$t('search content')"></el-input>
        <el-button size="mini" type="info">{{ $t("search") }}</el-button>
  
  
        <!--登出按钮-->
        <el-button size="mini" type="danger" @click="logout">{{ $t("logout") }}</el-button>
      </el-form>
      <!-- 用户名 -->
    </el-header>
  </main>
</template>

<script>
import HttpUtil from "../../utils/HttpUtil";
import ApiReturnModel from "../../models/ApiReturnModel";

export default {
  name: "Nav",
  data() {
    return {
      // 导航名称与路由地址
      links: [{
        name: this.$t('my site'),
        link: '/main'
      }, {
        name: this.$t('mission list'),
        link: '/mission'
      }, {
        name: this.$t('project manage'),
        link: '/project'
      }, {
        name: this.$t('backend manage'),
        link: '/backend'
      }],
      // 搜索的选项列表
      searchs: [
        this.$t('bug'), this.$t('mission'), this.$t('project'), this.$t('user'), this.$t('publish'), this.$t('test order')
      ],
      searchOption: this.$t('mission')
    }
  },
  created () {
  },
  methods: {
    /**
     * 登出annual执行的方法
     */
    logout () {
      HttpUtil.axiosPost("/user/logout", {}, (apiReturn) => {
        if (apiReturn.code > 0) {
          this.$store.commit("setNotLogin");
        }
      }, (error) => {
        console.error(error);
      });
    }
  },
  computed: {
    activeName () {
      return this.$route.name
    }
  },
}
</script>

<style lang="scss" scoped>
  #nav {
    padding: 0;
  }
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
  /*这里的属性修改会导致 App.vue 下所有的 el-input 的变化。应该寻找其他解决方案*/
  /*.el-input__inner {*/
    /*border: none;*/
    /*border: {*/
      /*radius: 0;*/
      /*right: 1px #545C64 solid;*/
    /*}*/
  /*}*/
  /*.search-content {*/
    /*.el-input__inner {*/
      /*border: none;*/
      /*&::placeholder {*/
        /*color: #ffffff;*/
      /*}*/
    /*}*/
  /*}*/
  /*.options {*/
    /*.el-select-dropdown__item {*/
      /*font-size: 12px;*/
    /*}*/
  /*}*/
</style>
