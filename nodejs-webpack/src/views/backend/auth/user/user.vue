<template>
  <main style="padding: 1px">
    <section>
      <!-- stripe 和 border 直接赋值，会报错。具体是因为给的值是 String 类型，不是 Boolean 类型-->
      <el-table :data="table.rows" size="mini" :stripe="true" :border="true">
        <el-table-column label="名字" prop="nickname" align="center">
        </el-table-column>
        <el-table-column label="真实姓名" prop="real_name" align="center">
        </el-table-column>
        <el-table-column label="登录账号" prop="account" align="center">
        </el-table-column>
        <el-table-column label="语言" prop="language" align="center">
        </el-table-column>
        <el-table-column label="上次登录时间" prop="last_login_time" align="center" :formatter="timeFormat">
        </el-table-column>
        <el-table-column label="上次登录ip" prop="last_login_ip" align="center">
        </el-table-column>
        <el-table-column label="操作" align="center">
          <template slot-scope="scope">
            <el-button type="primary" size="mini">修改</el-button>
            <el-button type="danger" size="mini">禁止登录</el-button>
          </template>
        </el-table-column>
      </el-table>
    </section>
  </main>
</template>

<script>
  import HttpUtil from "../../../../utils/HttpUtil";
  import TimeUtil from "../../../../utils/TimeUtil";
  import ApiReturnModel from "../../../../models/ApiReturnModel";

  export default {
    name: 'user',
    data () {
      return {
        /**
         * 表格
         */
        table: {
          /**
           * 数据
           */
          rows: [],
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
          rowNum: 10
        }
      }
    },
    created() {
      this.requestUserTable();
    },
    methods: {
      /**
       * 请求用户数据
       */
      requestUserTable() {
        this.axios.post(HttpUtil.getBaseUrl() + "/user/get-user-table").then((response) => {
          let apiReturn = ApiReturnModel.initByAxiosResponse(response);
          if (apiReturn.code > 0) {
            this.table.rows = Object.assign(apiReturn.data.rows);
            this.table.count =apiReturn.data.count;
          } else {
            // 服务器处理错误
            console.error(apiReturn);
          }
        }).catch((error) => {
          console.error(error);
        });
      },
    
      /**
       *
       * @param row
       * @param column
       * @return {String}
       */
      timeFormat(row, column) {
        let lastLoginTime = row.last_login_time;
      
        return TimeUtil.timestampToDate(lastLoginTime);
      }
    }
  }
</script>

<style scoped>

</style>
