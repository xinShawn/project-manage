<template>
  <main style="padding: 1px">
    <!--主要内容-->
    <article>
      <el-row>
        <el-button type="primary" icon="el-icon-circle-plus" size="mini" @click="dialog.show = true">{{ $t("add user") }}</el-button>
      </el-row>
      
      <!-- stripe 和 border 直接赋值，会报错。具体是因为给的值是 String 类型，不是 Boolean 类型。因此需要绑定赋值-->
      <el-table :data="table.rows" size="mini" :stripe="true" :border="true">
        <el-table-column :label="$t('nickname')" prop="nickname" align="center">
        </el-table-column>
        <el-table-column :label="$t('real name')" prop="real_name" align="center">
        </el-table-column>
        <el-table-column :label="$t('account')" prop="account" align="center">
        </el-table-column>
        <el-table-column :label="$t('language')" prop="language" align="center">
        </el-table-column>
        <el-table-column :label="$t('last login time')" prop="last_login_time" align="center" :formatter="timeFormat">
        </el-table-column>
        <el-table-column :label="$t('last login ip')" prop="last_login_ip" align="center">
        </el-table-column>
        <el-table-column :label="$t('operate')" align="center">
          <template slot-scope="scope">
            {{ $t("developing") }}...
          </template>
        </el-table-column>
      </el-table>
    </article>
    
    <!--隐藏的内容-->
    <footer>
      <el-dialog :title="$t('add account')" :visible.sync="dialog.show">
        <el-form ref="form" :model="form">
          <el-form-item :label="$t('account')" :label-width="formLabelWidth">
            <el-input v-model="form.account" :placeholder="$t('input account please')" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$t('password')" :label-width="formLabelWidth">
            <el-input v-model="form.password" :placeholder="$t('input password please')" type="password" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$t('ensure')" :label-width="formLabelWidth">
            <el-input v-model="form.checkPassword" :placeholder="$t('ensure password please')" type="password" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$t('real name')" :label-width="formLabelWidth">
            <el-input v-model="form.real_name" :placeholder="$t('input real name please')" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$t('nickname')" :label-width="formLabelWidth">
            <el-input v-model="form.nickname" :placeholder="$t('input nickname please')" autocomplete="off"></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button>{{ $t("cancel") }}</el-button>
          <el-button type="primary" @click="submit">{{ $t("confirmation") }}</el-button>
        </div>
      </el-dialog>
    </footer>
  </main>
</template>

<script>
  import HttpUtil from "../../utils/HttpUtil";
  import TimeUtil from "../../utils/TimeUtil";
  import EncryptUtil from "../../utils/EncryptUtil";
  import NotifyUtil from "../../utils/NotifyUtil";
  
  export default {
    name: 'user',
    data() {
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
        },
        
        /**
         * 弹窗
         */
        dialog: {
          show: false
        },
        
        form: {
          account: "",
          password: "",
          checkPassword: "",
          real_name: "",
          nickname: ""
        },
  
        formLabelWidth: "80px"
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
        HttpUtil.axiosPost("/user/get-user-table", {}, (apiReturn) => {
          if (apiReturn.code > 0) {
            this.table.rows = Object.assign(apiReturn.data.rows);
            this.table.count = apiReturn.data.count;
          }
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
        
        return TimeUtil.timestampToDateTime(lastLoginTime);
      },
  
      /**
       * 提交数据
       */
      submit() {
        let submitData = Object.assign(this.form);
        if (submitData.password !== submitData.checkPassword) {
          NotifyUtil.warning(this.$t("The two passwords were different"));
          return;
        }
        delete submitData.checkPassword;
        submitData.password = EncryptUtil.md5(submitData.password);
        
        HttpUtil.axiosPost("/user/add-user", submitData, (apiReturn) => {
          if (apiReturn.code > 0) {
            this.dialog.show = false;
            this.requestUserTable();
    
            NotifyUtil.success(apiReturn.message);
          } else {
            NotifyUtil.error(apiReturn.message);
          }
        }, (error) => {
          console.error(error);
          NotifyUtil.error(this.$t("Request server exception"));
        });
      }
    }
  }
</script>

<style scoped>

</style>
