<template>
  <main style="padding: 0">
    <el-row>
      <el-col :span="20">
        <keep-alive>
          <router-view></router-view>
        </keep-alive>
      </el-col>
      <el-col :span="4">
        <el-menu default-active="1-1" :collapse="false"
                 background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">
          <el-submenu index="1">
            <template v-for="item_1 in menu">
              <template slot="title">
                <i :class="item_1.icon"></i><span>{{ item_1.name }}</span>
              </template>
              <el-menu-item v-for="(item_2, index_2) in item_1.childes"
                            :key="index_2" :index="item_1.link + '_' + item_2.link"
                            @click="openRoute(item_1.link + '/' + item_2.link)">
                <i :class="item_2.icon"></i>{{ item_2.name }}
              </el-menu-item>
            </template>
          </el-submenu>
        </el-menu>
      </el-col>
    </el-row>
  </main>
</template>

<script>
  
  export default {
    name: "backend",
    data() {
      return {
        menu: [
          {name: "权限", link: "/backend", icon: "el-icon-setting", childes: [
            {name: "用户", icon: "el-icon-mobile-phone", link: "auth_user"}
          ]}
        ]
      };
    },
    created() {
    },
    mounted() {
    },
    methods: {
      openRoute(link) {
        this.$router.push(link);
      }
    }
  }
</script>

<style>
</style>
