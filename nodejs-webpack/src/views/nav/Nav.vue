<template>
  <main class="nav" v-if="$store.getters.isLogin">
    <el-row>
      <el-col :sm="5">
        <div class="title">{{ $t("backend manage system") }}</div>
      </el-col>
      <el-col :sm="14">
        <el-menu :default-active="activeName" class="nav" mode="horizontal" background-color="#409EFF" text-color="white" active-text-color="#ffd04b">
          <el-menu-item style="padding: 0" v-for="(item, index) in links" :index="item.link" :key="index">
            <router-link class="router-link" :to="item.link">{{ item.name }}</router-link>
          </el-menu-item>
        </el-menu>
      </el-col>
      <el-col class="tool-bar" :sm="5">
        <el-button @click="logout" size="mini" type="danger">{{ $t("logout") }}</el-button>
      </el-col>
    </el-row>
  </main>
</template>

<script>
import HttpUtil from "../../utils/HttpUtil";

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
    /**
     * 自动计算当前活跃的页签
     * @return {string}
     */
    activeName () {
      let activeName = "";
      let pathArray = this.$route.path.split("/");
      if (pathArray.length > 1) {
        activeName = "/" + pathArray[1];
      }
      return activeName;
    }
  },
}
</script>

<style lang="scss" scoped>
  main {
    height: auto;
  }
  
  .nav {
    padding: 0;
    color: white;
    background-color: #409EFF;
  }
  
  .nav > * {
    line-height: 60px;
  }
  
  .title {
    width: 100%;
    text-align: center;
    font-size: 24px;
  }
  
  .tool-bar {
    padding: 0 20px;
    text-align: right;
  }
  
  .router-link {
    display: inline-block;
    padding: 0 20px;
    height: 60px;
  }
</style>
