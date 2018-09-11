<template>
  <main>
    <!--主要内容-->
    <article>
      <el-button type="primary" icon="el-icon-circle-plus" size="mini" @click="showDialog">{{ $t("add mission") }}</el-button>
    </article>
    
    <!--隐藏弹窗-->
    <footer>
      
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
            <!--<el-input v-model="form.priority" :placeholder="$t('mission title')" auto-complete="off"></el-input>-->
          </el-form-item>
          <el-form-item :label="$t('end time')" :label-width="formLabelWidth">
            <el-date-picker  width="100%" type="datetime" value-format="yyyy-MM-dd" v-model="form.data.endTime" :placeholder="$t('end time')">
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
  import HttpUtil from "../../utils/HttpUtil";

  export default {
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
         * @type {{}}
         */
        form: {
          /**
           * @type {Boolean} 表单锁，防止多次点击提交了多次
           */
          lock: true,
          
          /**
           * 表单需要提交的数据
           */
          data: {
            title: "",
            priorityId: "",
            content: "",
            endTime: ""
          }
        }
      }
    },
    created() {
      this.requestPriorityRichOptions();
    },
    methods: {
      /**
       * 请求表格数据
       */
      requestTable() {
      
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
            that.$message.success(apiReturn.message);
            that.hideDialog();
          } else {
            that.$message.error(apiReturn.message);
          }
        }, (error) => {
          console.error(error);
          that.$message.error(this.$t("Request server exception"))
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

<style>
</style>
