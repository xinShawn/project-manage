<template>
  <main>
    <el-table
      :data="table.data"
      style="width: 100%">
      <el-table-column type="expand">
        <template slot-scope="props">
          <el-form label-position="left" inline class="demo-table-expand">
            <el-form-item label="名字">
              <span>{{ props.row.name }}</span>
            </el-form-item>
          </el-form>
        </template>
      </el-table-column>
    </el-table>
  </main>
</template>

<script>
  export default {
    data () {
      return {
        /**
         * 表格
         */
        table: {
          /**
           * 数据
           */
          data: [{name: "one"}, {name: "two"}],
          /**
           * 数据条数
           */
          count: 0,
          /**
           * 当前页数
           */
          page: 1,
          /**
           * 每页数据行数
           */
          rows: 10
        }
      }
    },
    methods: {
    
    }
  }
</script>

<style>
</style>
