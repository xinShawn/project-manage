<template>
  <main>
    <el-row>
      <!--主要信息-->
      <el-col :span="16">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>{{$t("mission detail")}}</span>
          </div>
          <div class="text item">
            
            <el-form ref="form" :model="form" label-width="80px" v-loading="form.load">
              <el-form-item :label="$t('mission title')">
                <el-input v-model="form.data.title" :placeholder="$t('mission title')" autocomplete="off"/>
              </el-form-item>
              <el-form-item :label="$t('mission content')">
                <el-input v-model="form.data.content" type="textarea" :placeholder="$t('mission content')"
                          :autosize="{ minRows: 2, maxRows: 4}" autocomplete="off"/>
              </el-form-item>
              <el-form-item>
                <el-button type="primary" size="small" @click="submitChange">{{ $t("submit change") }}</el-button>
                <el-button size="small" @click="backToMission">{{ $t("back") }}</el-button>
              </el-form-item>
            </el-form>
            
          </div>
        </el-card>
      </el-col>
    
      <!--基础信息-->
      <el-col :span="8">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>{{$t("base info")}}</span>
          </div>
          <div class="text item">
  
            <el-form ref="form" :model="form" label-width="80px" v-loading="form.load">
              <el-form-item :label="$t('priority')">
                <el-select v-model="form.data.priority_id" :placeholder="$t('select please')" value="" style="width: 100%">
                  <el-option v-for="item in view.priorityOptions" :key="item.name" :label="item.name" :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
              
              <el-form-item :label="$t('end time')">
                <el-date-picker v-model="form.data.end_time" type="datetime" style="width: 100%" value-format="yyyy-MM-dd hh:mm:ss" :placeholder="$t('end time')"></el-date-picker>
              </el-form-item>
            </el-form>
            
          </div>
        </el-card>
      </el-col>
    </el-row>
    
  </main>
</template>

<script>
  import HttpUtil from "../../utils/HttpUtil";
  import OptionsManage from "../../store/manage/OptionsManage";
  import NotifyUtil from "../../utils/NotifyUtil";

  export default {
    name: 'MissionDetail',
    data() {
      return {
        view: {
          // 优先级详情
          priorityOptions: {}
        },
        
        /**
         * 任务表单数据
         */
        form: {
          /**
           * 是否在加载数据
           */
          load: true,
          /**
           * 提交锁
           */
          lock: true,
          /**
           * 具体数据
           */
          data: {
            id: "",
            // 任务详情
            title: "",
            content: "",
  
            // 基本信息
            priority_id: "",
            // 截至时间
            end_time: "",
          }
        }
      };
    },
    created() {
      this.requestViewData();
      this.requestMission();
    },
    methods: {
      /**
       * 请求页面模板数据
       */
      requestViewData() {
        OptionsManage.getInstance().setPriorityOptions((options) => {
          this.$set(this.view, "priorityOptions", options);
        });
      },
      
      /**
       * 请求任务所有的数据
       */
      requestMission() {
        this.cleanForm();
        this.$set(this.form, "load", true);
        
        HttpUtil.axiosPost("/mission/get-detail", {id: this.id}, (apiReturn) => {
          if (apiReturn.code > 0) {
            this.$set(this.form, "data", apiReturn.data);
            this.$set(this.form, "lock", false);
          } else {
            NotifyUtil.warning(this.$t("Fetch data failed"));
          }
          this.$set(this.form, "load", false);
        }, (error) => {
          console.error(error);
          NotifyUtil.warning(this.$t("Request server exception"));
          this.$set(this.form, "load", false);
        });
      },
  
      /**
       * 清空表格所有数据
       */
      cleanForm() {
        for (let prop in this.form.data) {
          this.$set(this.form.data, prop, "");
        }
      },
  
      /**
       * 返回任务列表
       */
      backToMission() {
        this.$router.back();
      },
  
      /**
       * 提交修改
       */
      submitChange() {
        if (this.form.lock) {
          NotifyUtil.warning(this.$t("Do not click many times"))
        }
        this.form.lock = true;
        
        HttpUtil.axiosPost("/mission/change", {form: Object.assign(this.form.data)}, (apiReturn) => {
          if (apiReturn.code > 0) {
            NotifyUtil.success(apiReturn.message);
            this.$store.commit("onMissionHomeTable");
            this.backToMission();
          } else {
            console.error(apiReturn);
            this.form.lock = false;
            NotifyUtil.error(apiReturn.message);
          }
        }, (error) => {
          console.error(error);
          this.form.lock = false;
          NotifyUtil.error(this.$t("Request server exception"));
        })
      }
    },
    computed: {
      id() {
        return this.$route.params.id;
      }
    },
    watch: {
      id(newValue) {
        if (newValue !== undefined) {
          this.form.data.id = newValue;
          this.requestMission();
        }
      }
    }
  }
</script>

<style scoped>

</style>
