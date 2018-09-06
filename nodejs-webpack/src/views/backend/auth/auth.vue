<template>
  <main class="backend-auth">
    <el-tabs tab-position="right" style="padding: 0;margin: 0">
      <el-tab-pane label="用户">
        <backend-auth-user></backend-auth-user>
      </el-tab-pane>
    </el-tabs>
  </main>
</template>

<script>
  import user from "./user/user";
  
  export default {
    name: 'auth',
    components: {
      "backend-auth-user": user
    }
  }
</script>

<style scoped>
  .backend-auth {
    padding: 0;
  }
</style>
