<template>
  <main>
    <el-row>
      
      <!--主要信息-->
      <el-col :span="16">
        <el-form ref="form" :model="form" label-width="80px">
          <el-form-item :label="$t('mission title')">
            <el-input v-model="form.data.title" :placeholder="$t('mission title')" autocomplete="off" />
          </el-form-item>
          <el-form-item :label="$t('mission content')">
            <el-input v-model="form.data.content" type="textarea" :placeholder="$t('mission content')"
                      :autosize="{ minRows: 2, maxRows: 4}"autocomplete="off" />
          </el-form-item>
        </el-form>
      </el-col>
      
      <!--基础信息-->
      <el-col :span="8">
      
      </el-col>
    </el-row>
  </main>
</template>

<script>
  export default {
    name: 'MissionDetail',
    data() {
      return {
        /**
         * 任务表单数据
         */
        form: {
          /**
           * 具体数据
           */
          data: {
            id: 0,
            title: "",
            content: "",
          }
        }
      };
    },
    created() {
    },
    mounted() {
      this.requestMission();
    },
    methods: {
      /**
       * 请求任务所有的数据
       */
      requestMission() {
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
