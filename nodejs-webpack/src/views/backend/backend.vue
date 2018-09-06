<template>
  <main>
    <el-tabs tab-position="right" style="padding: 0;margin: 0" value="log">
      <el-tab-pane :label="$t('auth')">
        <auth></auth>
      </el-tab-pane>
      <el-tab-pane :label="$t('log')" name="log">
      </el-tab-pane>
      <el-tab-pane :label="$t('setting')">
      </el-tab-pane>
      <el-tab-pane :label="$t('tools')">
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
