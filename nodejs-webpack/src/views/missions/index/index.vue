<template>
  <main>
    <!--主要内容-->
    <article>
      
      <el-button type="primary" icon="el-icon-circle-plus" @click="showDialog">{{ $t("add mission") }}</el-button>
      
      <el-table :data="table.data" style="width: 100%">
        <el-table-column prop="id" label="ID"></el-table-column>
        <el-table-column prop="" :label="$t('mission title')">
          <template slot-scope="props">
            {{ props.row.title }}
          </template>
        </el-table-column>
        <el-table-column prop="priority_name" :label="$t('priority')"></el-table-column>
        <el-table-column prop="status_name" :label="$t('status')"></el-table-column>
        <el-table-column prop="end_time" :label="$t('end time')"></el-table-column>
        <el-table-column :label="$t('operate')" align="center">
          <template slot-scope="scope">
            <el-button size="mini"></el-button>
          </template>
        </el-table-column>
      </el-table>
    
    </article>
    
    <!--隐藏弹窗-->
    <footer>
      
      <!--添加任务的弹窗-->
      <el-dialog :title="$t('add mission')" :visible.sync="isShowDialog">
        <el-form ref="form" :model="form.data">
          <el-form-item :label="$t('title')" :label-width="formLabelWidth">
            <el-input v-model="form.data.title" :placeholder="$t('mission title')" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$t('content')" :label-width="formLabelWidth">
            <el-input v-model="form.data.content" :placeholder="$t('mission content')" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$t('priority')" :label-width="formLabelWidth">
            <el-select v-model="form.data.priorityId" :placeholder="$t('select please')" value="">
              <el-option v-for="item in priorityList" :key="item.name" :label="item.name" :value="item.id">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('end time')" :label-width="formLabelWidth">
            <el-date-picker width="100%" type="datetime" value-format="yyyy-MM-dd" v-model="form.data.endTime"
                            :placeholder="$t('end time')">
            </el-date-picker>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="hideDialog">{{ $t("cancel") }}</el-button>
          <el-button type="primary" @click="submit">{{ $t("ensure") }}</el-button>
        </div>
      </el-dialog>
    
    </footer>
  </main>
</template>

<script>
  import HttpUtil from "../../../utils/HttpUtil";
  
  export default {
    name: 'index',
    data() {
      return {
        /**
         * 是否显示弹窗
         */
        isShowDialog: false,
        /**
         * 表格提示文字的宽度
         */
        formLabelWidth: "120px",
      
        /**
         * @type [] 优先级下拉框数据
         */
        priorityList: [],
      
        /**
         * @type {object} 表单数据封装
         */
        form: {
          /**
           * @type {Boolean} 表单锁，防止多次点击提交了多次
           */
          lock: true,
        
          /**
           * @type {object} 表单需要提交的数据
           */
          data: {
            title: "",
            priorityId: "",
            content: "",
            endTime: ""
          }
        },
      
        /**
         * @type {object} 表格数据封装
         */
        table: {
          page: 1,
          rows: 10,
          count: 0,
          data: []
        }
      }
    },
    created() {
      this.requestTable();
      this.requestPriorityRichOptions();
    },
    methods: {
      /**
       * 请求表格数据
       */
      requestTable() {
        let that = this;
      
        HttpUtil.axiosPost("/mission/get-mission-table", {}, (apiReturn) => {
          if (apiReturn.code > 0) {
            that.$set(that.table, "count", apiReturn.data.count);
            that.$set(that.table, "data", apiReturn.data.data);
          } else {
            console.error(apiReturn);
          }
        }, (error) => {
          console.error(error);
        }, 5000);
      },
    
      /**
       * 请求优先级的数据
       */
      requestPriorityRichOptions() {
        let that = this;
      
        HttpUtil.axiosPost("/mission/get-priority-rich-options", {}, (apiReturn) => {
          if (apiReturn.code > 0) {
            that.priorityList = Object.assign(apiReturn.data);
          } else {
            console.error(error);
          }
        }, (error) => {
          console.error(error);
        }, 5000);
      },
    
      /**
       * 隐藏弹窗
       */
      hideDialog() {
        this.isShowDialog = false;
      },
    
      /**
       * 显示弹窗
       */
      showDialog() {
        this.isShowDialog = true;
      },
    
      /**
       * 提交要修改的数据
       */
      submit() {
        let submitData = this.getSubmitData();
        let that = this;
      
        HttpUtil.axiosPost("/mission/add", submitData, (apiReturn) => {
          if (apiReturn.code > 0) {
            that.requestTable();
            that.$message.success(apiReturn.message);
            that.hideDialog();
          } else {
            that.$message.error(apiReturn.message);
          }
        }, (error) => {
          console.error(error);
          that.$message.error(that.$t("Request server exception"))
        }, 5000);
      },
    
      /**
       * 获取请求需要提交的数据
       * @return {any}
       */
      getSubmitData() {
        return Object.assign(this.form.data);
      }
    },
  }
</script>

<style scoped>

</style>
