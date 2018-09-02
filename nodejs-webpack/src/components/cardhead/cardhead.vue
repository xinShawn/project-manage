<template>
  <el-row>
    <el-col :span="23">
      <h2>{{title}}</h2>
    </el-col>
    <el-col :span="1" class="more">
      <el-dropdown>
        <el-button class="el-dropdown-link" icon="el-icon-more-outline"></el-button>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item>刷新</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </el-col>
  </el-row>
</template>

<script>
export default {
  props: {
    title: String
  }
}
</script>

<style lang="scss" scoped>
.el-row {
  text-align: left;
}
h2 {
  font-size: 14px;
  margin: 0;
}
.more {
  text-align: center;
  button {
    border: none;
  }
}
</style>
