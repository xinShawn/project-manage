<template>
  <main>
    <article>
      <el-row>
        <el-col :span="16">
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>{{ $t('project overview') }}</span>
              <el-button style="float: right; padding: 3px 0" type="text" @click="showAddProjectDialog">{{ $t("create project") }}</el-button>
            </div>
            <div class="text item">
              <el-table :data="table.data" v-loading="table.loading" size="mini">
                <el-table-column prop="id" label="ID" width="60"></el-table-column>
                <el-table-column prop="name" :label="$t('project name')"></el-table-column>
                <el-table-column prop="remark" :label="$t('remark')"></el-table-column>
              </el-table>
            </div>
          </el-card>
        </el-col>
      </el-row>
    </article>
  
    <footer>
      <el-dialog :title="$t('create project')" :visible.sync="form.dialog">
        <el-form :model="form">
          <el-form-item :label="$t('project name')" :label-width="form.labelWidth">
            <el-input v-model="form.data.name" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$t('remark')" :label-width="form.labelWidth">
            <el-input v-model="form.data.remark" type="textarea" autocomplete="off"></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="hideAddProjectDialog">{{ $t("cancel") }}</el-button>
          <el-button type="primary" @click="submitAdd">{{ $t("ensure") }}</el-button>
        </div>
      </el-dialog>
    </footer>
  </main>
</template>

<script>
  import HttpUtil from "../../utils/HttpUtil";
  import NotifyUtil from "../../utils/NotifyUtil";

  export default {
    name: 'ProjectHome',
    data() {
      return {
        view: {
        
        },
        
        /**
         * 添加项目相关的数据封装
         */
        form: {
          lock: true,
          dialog: false,
          labelWidth: "100px",
          data: {
            name: "",
            remark: "",
          }
        },
        
        /**
         * 表格相关的数据封装
         */
        table: {
          loading: false,
          data: []
        }
      }
    },
    created() {
      this.requestTable();
    },
    methods: {
      /**
       * 请求表格数据
       */
      requestTable() {
        this.table.loading = true;
        
        HttpUtil.axiosPost("project/get-table", {}, (apiReturn) => {
          if (apiReturn.code > 0) {
            this.table.data = Object.assign(apiReturn.data);
          }
          this.table.loading = false;
        }, (error) => {
          console.error(error);
          this.table.loading = false;
        });
      },
  
      /**
       * 显示添加项目的弹窗
       */
      showAddProjectDialog() {
        this.form.lock = false;
        this.form.dialog = true;
      },
  
      /**
       * 隐藏添加项目的弹窗
       */
      hideAddProjectDialog() {
        this.form.dialog = false;
      },
  
      /**
       * 提交添加项目的数据
       */
      submitAdd() {
        HttpUtil.axiosPost("project/add", this.form.data, (apiReturn) => {
          if (apiReturn.code > 0) {
            NotifyUtil.success(apiReturn.message);
          } else {
            NotifyUtil.error(apiReturn.message);
          }
        }, (error) => {
          console.error(error);
          NotifyUtil.error(this.$t("Request timeout"));
        }, 5000);
      }
    }
  }
</script>

<style scoped>

</style>
