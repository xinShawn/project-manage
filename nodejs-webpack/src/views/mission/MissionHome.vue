<template>
  <main>
    <!--搜索栏-->
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        项目：
        <el-select v-model="table.params.projectId" size="mini" placeholder="项目id">
          <el-option
            v-for="(name, id) in view.projectOptions"
            :key="id"
            :label="name"
            :value="parseInt(id)">
          </el-option>
        </el-select>
  
        状态：
        <el-radio-group v-model="table.params.radio" @change="requestTable" size="mini">
          <el-radio-button label="all">{{ $t("all") }}</el-radio-button>
          <el-radio-button label="unfinished">{{ $t("unfinished") }}</el-radio-button>
        </el-radio-group>
      </div>
    </el-card>
    
    <!--主要内容-->
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>{{ $t("mission list") }}</span>
        <el-button style="float: right" type="primary" size="mini" icon="el-icon-circle-plus" @click="showDialog">{{ $t("add mission") }}</el-button>
      </div>
      <div class="text item">
        <el-pagination
          @size-change="onSizeChange"
          @current-change="onPageChange"
          :current-page="table.params.page"
          :page-sizes="[10, 20, 50, 100]"
          :page-size="table.params.rows"
          layout="total, sizes, prev, pager, next, jumper"
          :total="table.count">
        </el-pagination>
        
        <el-table :data="table.data" v-loading="table.loading" size="mini">
          <el-table-column prop="id" label="ID" width="60"></el-table-column>
          <el-table-column prop="" :label="$t('mission title')">
            <template slot-scope="props">
              <router-link :to="{ name: 'detail', params: { id: props.row.id }}">{{ props.row.title }}</router-link>
            </template>
          </el-table-column>
          <el-table-column prop="priority_name" :label="$t('priority')" width="70"></el-table-column>
          <el-table-column :label="$t('status')" width="70">
            <template slot-scope="props">
              <span :style="{color: getStatusColor(props.row.status)}">{{ props.row.status_name }}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('end time')" width="160">
            <template slot-scope="props">
              <span :style="{color: getEndTimeColor(props.row.end_time)}">{{ toDateTime(props.row.end_time) }}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('operate')" align="center" width="160">
            <template slot-scope="props">
              <el-button size="mini" v-if="isShowStartBtn(props.row.status)" @click="changeMissionStatus(props.row.id, conf.STATUS_START)">{{ $t("start") }}</el-button>
              <el-button size="mini" v-if="isShowPauseBtn(props.row.status)" @click="changeMissionStatus(props.row.id, conf.STATUS_PAUSE)">{{ $t("pause") }}</el-button>
              <el-button size="mini" v-if="isShowFinishBtn(props.row.status)" @click="changeMissionStatus(props.row.id, conf.STATUS_FINISHED)">{{ $t("finish") }}</el-button>
              <el-button size="mini" v-if="isShowCloseBtn(props.row.status)" @click="changeMissionStatus(props.row.id, conf.STATUS_CLOSED)">{{ $t("close") }}</el-button>
              <el-button size="mini" v-if="isShowCancelBtn(props.row.status)" @click="changeMissionStatus(props.row.id, conf.STATUS_CANCELED)">{{ $t("cancel") }}</el-button>
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
              <el-option v-for="item in view.priorityOptions" :key="item.name" :label="item.name" :value="item.id">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('end time')" :label-width="formLabelWidth">
            <el-date-picker v-model="form.data.endTime" type="datetime" style="width: 100%" value-format="yyyy-MM-dd hh:mm:ss" :placeholder="$t('end time')"></el-date-picker>
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
  import OptionsManage from "../../store/manage/OptionsManage";
  import NotifyUtil from "../../utils/NotifyUtil";
  import TimeUtil from "../../utils/TimeUtil";
  
  export default {
    name: 'MissionHome',
    data() {
      return {
        /** 是否显示弹窗 */
        isShowDialog: false,
        /** 表格提示文字的宽度 */
        formLabelWidth: "120px",
        
        /** 配置 */
        conf: {
          /** 状态：未开始 */
          STATUS_NOT_START: 0,
          /** 状态：进行中 */
          STATUS_START: 10,
          /** 状态：暂停 */
          STATUS_PAUSE: 20,
          /** 状态：已完成 */
          STATUS_FINISHED: 30,
          /** 状态：已关闭 */
          STATUS_CLOSED: 40,
          /** 状态：已取消 */
          STATUS_CANCELED: -10,
        },
        
        /** 页面需要便利的数据 */
        view: {
          priorityOptions: [],
          projectOptions: [],
        },
      
        /** @type {object} 表单数据封装 */
        form: {
          lock: true,
          data: {
            title: "",
            priorityId: "",
            content: "",
            endTime: ""
          }
        },
      
        /** @type {object} 表格数据封装 */
        table: {
          loading: false,
          // 查询时需要提交的参数
          params: {
            page: 1,
            rows: 50,
            radio: "unfinished",
            projectId: "",
          },
          count: 0,
          data: []
        }
      }
    },
    created() {
      this.initViewData();
    },
    methods: {
      /**
       * 请求页面模板数据
       */
      initViewData() {
        let optionsManage = OptionsManage.getInstance();
        optionsManage.setPriorityFullOptions((options) => {
          this.$set(this.view, "priorityOptions", options);
        });
        optionsManage.setProjectOptions((options) => {
          this.$set(this.view, "projectOptions", options);
          this.requestProjectId();
        });
      },
      
      /**
       * 请求默认的项目id
       */
      requestProjectId() {
        HttpUtil.axiosPost("/project/get-project-id", {}, (apiReturn) => {
          if (apiReturn.code > 0) {
            let projectId = apiReturn.data;
            
            if (projectId === null) {
              projectId = Object.keys(this.view.projectOptions)[0];
            }
            this.$set(this.table.params, "projectId", parseInt(projectId));
          } else {
            console.error(apiReturn);
          }
        }, (error) => {
          console.error(error);
        }, 5000);
      },
      
      /**
       * 请求设置项目id
       */
      requestSetProjectId() {
        HttpUtil.axiosPost("/project/set-project-id", {projectId: this.table.params.projectId}, (apiReturn) => {
          if (apiReturn.code < 0) {
            console.error(apiReturn);
          }
        }, (error) => {
          console.error(error);
        });
      },
      
      /**
       * 请求表格数据
       */
      requestTable() {
        if (this.table.loading) {
          return;
        }
        this.table.loading = true;
        
        this.$set(this.table, "data", []);
      
        HttpUtil.axiosPost("/mission/get-mission-table", this.table.params, (apiReturn) => {
          if (apiReturn.code > 0) {
            this.$set(this.table, "count", Number.parseInt(apiReturn.data.count));
            this.$set(this.table, "data", apiReturn.data.data);
            this.$store.commit("offMissionHomeTable");
          } else {
            console.error(apiReturn);
          }
          this.table.loading = false;
        }, (error) => {
          console.error(error);
          this.table.loading = false;
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
       * 监听每页显示行数的变化
       * @param {int} size
       */
      onSizeChange(size) {
        this.table.params.rows = size;
        this.requestTable();
      },
      
      /**
       * 监听当前页数的变化
       * @param {int} page
       */
      onPageChange(page) {
        this.table.params.page = page;
        this.requestTable();
      },
      
      /**
       * 修改任务状态
       * @param {string|int} missionId
       * @param {int} toStatus
       */
      changeMissionStatus(missionId, toStatus) {
        this.table.loading = true;
  
        HttpUtil.axiosPost("mission/change-mission-status", {id: missionId, toStatus: toStatus}, (apiReturn) => {
          this.table.loading = false;
          if (apiReturn.code > 0) {
            NotifyUtil.success(apiReturn.message);
            this.requestTable();
          } else {
            NotifyUtil.error(apiReturn.message);
          }
        }, (error) => {
          console.error(error);
          this.table.loading = false;
          NotifyUtil.error(this.$t("Request server exception"));
        }, 5000);
      },
      
      /**
       * 提交要修改的数据
       */
      submit() {
        HttpUtil.axiosPost("/mission/add", this.form.data, (apiReturn) => {
          if (apiReturn.code > 0) {
            this.$store.commit("onMissionHomeTable");
            NotifyUtil.success(apiReturn.message);
            this.hideDialog();
          } else {
            NotifyUtil.error(apiReturn.message);
          }
        }, (error) => {
          console.error(error);
          NotifyUtil.error(this.$t("Request server exception"))
        }, 5000);
      },
      
      /**
       * 根据据状态获取颜色值
       * @return string 颜色值
       */
      getStatusColor(status) {
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
       * 获取结束时间的颜色值
       * @return string 颜色值
       */
      getEndTimeColor(endTime) {
        let currentTime = TimeUtil.currentTime();
        if (currentTime > endTime) {
          return "#ff0000";
        }
        return "";
      },
      
      /**
       * 把时间戳转为日期
       */
      toDateTime(time) {
        return TimeUtil.timestampToDateTime(time);
      },
      
      /**
       * 是否显示开始按钮
       * @param {string|number} status
       * @return {boolean}
       */
      isShowStartBtn(status) {
        status = Number.parseInt(status);
        return ([this.conf.STATUS_NOT_START, this.conf.STATUS_PAUSE].indexOf(status) !== -1)
      },
      
      /**
       * 是否显示暂停按钮
       * @param {string|number} status
       * @return {boolean}
       */
      isShowPauseBtn(status) {
        status = Number.parseInt(status);
        return ([this.conf.STATUS_START].indexOf(status) !== -1)
      },
      
      /**
       * 是否显示完成按钮
       * @param {string|number} status
       * @return {boolean}
       */
      isShowFinishBtn(status) {
        status = Number.parseInt(status);
        return ([this.conf.STATUS_START].indexOf(status) !== -1)
      },
      
      /**
       * 是否显示关闭按钮
       * @param {string|number} status
       * @return {boolean}
       */
      isShowCloseBtn(status) {
        status = Number.parseInt(status);
        return ([this.conf.STATUS_FINISHED].indexOf(status) !== -1)
      },
      
      /**
       * 是否显示取消按钮
       * @param {string|number} status
       * @return {boolean}
       */
      isShowCancelBtn(status) {
        status = Number.parseInt(status);
        return ([this.conf.STATUS_CANCELED, this.conf.STATUS_CANCELED].indexOf(status) === -1);
      }
    },
    computed: {
      /**
       * 封装变量
       * @return {boolean}
       */
      isTableNeedRefresh() {
        return this.$store.state.refresh.missionHome.table;
      },
      
      /**
       * 封装 projectId 选项
       */
      projectId() {
        return this.table.params.projectId;
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
      },
  
      /**
       * 监听项目id
       */
      projectId() {
        this.requestSetProjectId();
        this.requestTable();
      }
    }
  }
</script>

<style scoped>

</style>
