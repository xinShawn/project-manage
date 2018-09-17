<template>
  <main>
    <!--主要内容-->
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>{{ $t("mission list") }}</span>
        <el-button style="float: right" type="primary" size="mini" icon="el-icon-circle-plus" @click="showDialog">{{ $t("add mission") }}</el-button>
      </div>
      <div class="text item">
      
        <el-table :data="table.data" v-loading="table.loading" style="width: 100%">
          <el-table-column prop="id" label="ID"></el-table-column>
          <el-table-column prop="" :label="$t('mission title')">
            <template slot-scope="props">
              <router-link :to="{ name: 'detail', params: { id: props.row.id }}">{{ props.row.title }}</router-link>
            </template>
          </el-table-column>
          <el-table-column prop="priority_name" :label="$t('priority')"></el-table-column>
          <el-table-column :label="$t('status')">
            <template slot-scope="props">
              <span :style="{color: getColor(props.row.status)}">{{ props.row.status_name }}</span>
            </template>
          </el-table-column>
          <el-table-column prop="end_time" :label="$t('end time')"></el-table-column>
          <el-table-column :label="$t('operate')" align="center">
            <template slot-scope="props">
              <el-button size="mini" v-if="isShowStartBtn(props.row.status)" @click="changeMissionStatus(props.row.id, 10)">{{ $t("start") }}</el-button>
              <el-button size="mini" v-if="isShowPauseBtn(props.row.status)" @click="changeMissionStatus(props.row.id, 20)">{{ $t("pause") }}</el-button>
              <el-button size="mini" v-if="isShowFinishBtn(props.row.status)" @click="changeMissionStatus(props.row.id, 30)">{{ $t("finish") }}</el-button>
              <el-button size="mini" v-if="isShowCloseBtn(props.row.status)" @click="changeMissionStatus(props.row.id, 40)">{{ $t("close") }}</el-button>
            </template>
          </el-table-column>
        </el-table>
    
      </div>
    </el-card>
    
    <!--隐藏弹窗-->
    <footer>
      
      <!--添加任务的弹窗-->
      <el-dialog :title="$t('add mission')" :visible.sync="isShowDialog">
        <el-form ref="form" :model="form.data">
          <el-form-item :label="$t('title')" :label-width="formLabelWidth">
            <el-input v-model="form.data.title" :placeholder="$t('mission title')" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$t('content')" :label-width="formLabelWidth">
            <el-input v-model="form.data.content" :placeholder="$t('mission content')" autocomplete="off" type="textarea"></el-input>
          </el-form-item>
          <el-form-item :label="$t('priority')" :label-width="formLabelWidth">
            <el-select v-model="form.data.priorityId" :placeholder="$t('select please')" value="" style="width: 100%">
              <el-option v-for="item in priorityList" :key="item.name" :label="item.name" :value="item.id">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('end time')" :label-width="formLabelWidth">
            <el-date-picker v-model="form.data.endTime" type="datetime" style="width: 100%" value-format="yyyy-MM-dd" :placeholder="$t('end time')"></el-date-picker>
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
    name: 'MissionHome',
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
          loading: false,
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
        this.$set(this.table, "count", 0);
        this.$set(this.table, "data", []);
      
        HttpUtil.axiosPost("/mission/get-mission-table", {}, (apiReturn) => {
          if (apiReturn.code > 0) {
            this.$set(this.table, "count", apiReturn.data.count);
            this.$set(this.table, "data", apiReturn.data.data);
            this.$store.commit("offMissionHomeTable");
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
       * 修改任务状态
       */
      changeMissionStatus(missionId, toStatus) {
        console.log(missionId);
        this.table.loading = true;
  
        let that = this;
        HttpUtil.axiosPost("mission/change-mission-status", {id: missionId, toStatus: toStatus}, (apiReturn) => {
          if (apiReturn.code > 0) {
            that.requestTable();
            that.$message.success(apiReturn.message);
          } else {
            that.$message.error(apiReturn.message);
          }
          that.table.loading = false;
        }, (error) => {
          console.error(error);
          that.table.loading = false;
          that.$message.error(that.$t("Request server exception"));
        }, 5000);
      },
    
      /**
       * 提交要修改的数据
       */
      submit() {
        let submitData = this.getSubmitData();
        let that = this;
      
        HttpUtil.axiosPost("/mission/add", submitData, (apiReturn) => {
          if (apiReturn.code > 0) {
            this.$store.commit("onMissionHomeTable");
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
      },
      
      /**
       * 根据据状态获取颜色值
       */
      getColor(status) {
        status = Number.parseInt(status);
        switch (status) {
          case 0:
            return "#ff5e17";
          case 10:
            return "#1f5de7";
          case 20:
            return "#e7442d";
          case 30:
            return "#34e725";
          case 40:
            return "#79917f";
        }
      },
  
      /**
       * 是否显示开始按钮
       * @param status
       * @return {boolean}
       */
      isShowStartBtn(status) {
        status = Number.parseInt(status);
        return ([0, 20].indexOf(status) !== -1)
      },
  
      /**
       * 是否显示暂停按钮
       * @param status
       * @return {boolean}
       */
      isShowPauseBtn(status) {
        status = Number.parseInt(status);
        return ([10].indexOf(status) !== -1)
      },
  
      /**
       * 是否显示完成按钮
       * @param status
       * @return {boolean}
       */
      isShowFinishBtn(status) {
        status = Number.parseInt(status);
        return ([10].indexOf(status) !== -1)
      },
  
      /**
       * 是否显示关闭按钮
       * @param status
       * @return {boolean}
       */
      isShowCloseBtn(status) {
        status = Number.parseInt(status);
        return ([30].indexOf(status) !== -1)
      },
    },
    computed: {
      /**
       * 封装变量
       * @return {boolean}
       */
      isTableNeedRefresh() {
        return this.$store.state.refresh.missionHome.table;
      }
    },
    watch: {
      /**
       * 监听表格是否需要刷新
       * @param val
       */
      isTableNeedRefresh(val) {
        if (val) {
          this.requestTable();
        }
      }
    }
  }
</script>

<style scoped>

</style>
