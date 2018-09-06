<template>
  <main>
    <el-tabs tab-position="right" style="padding: 0;margin: 0">
      <el-tab-pane label="权限">
        <auth></auth>
      </el-tab-pane>
      <el-tab-pane label="日志">
      </el-tab-pane>
      <el-tab-pane label="设置">
      </el-tab-pane>
      <el-tab-pane label="工具">
      </el-tab-pane>
    </el-tabs>
  </main>
</template>

<script>
  import auth from "./auth/auth"
  
  export default {
    name: "backend",
    components: {
      auth
    },
    data() {
      return {
      
      };
    },
    created() {
    
    },
    methods: {
    
    }
  }
</script>

<style>
</style>
