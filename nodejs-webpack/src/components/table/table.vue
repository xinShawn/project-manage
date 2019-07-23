<template>
  <el-table
    :data="tableData"
    style="width: 100%; text-align: left;"
    :default-sort = "{prop: 'date', order: 'descending'}" >
    <!-- 只需遍历第一个元素中的键值 -->
    <el-table-column v-for="(value, key, index) in tableData[0]"
      :key="index"
      :prop="key"
      :label="tableHead[index]"
      sortable>
    </el-table-column>
  </el-table>
</template>

<script>
export default {
  props: {
    tableData: Array, // 表格体的数据数组
    tableHead: Array // 表格头部的数组数组
  },
  methods: {}
}
</script>

<style lang="scss" scoped>
</style>
