<template>
  <main>
    <el-row>
      <h3>登录页面</h3>
    </el-row>
    <el-row :gutter='20' class='login-row'>
      <!--START 两边空白占位区-->
      <el-col :span='6'>
        <div>&nbsp;</div>
      </el-col>
      <!--END 两边空白占位区-->
      <el-col :span='12' class='initPanel'>
        <el-form ref='form' label-width='80px'>
          <el-form-item label='系统账号'>
            <el-input v-model='from.account' auto-complete='off'></el-input>
          </el-form-item>
          <el-form-item label='登录密码'>
            <el-input type='password' v-model='from.password' auto-complete='off'></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type='primary' @click='submitLogin'>登陆</el-button>
          </el-form-item>
        </el-form>
      </el-col>
      <!--START 两边空白占位区-->
      <el-col :span='6'>
        <div>&nbsp;</div>
      </el-col>
      <!--END 两边空白占位区-->
    </el-row>
  </main>
</template>

<script>
import HttpUtil from "../../utils/HttpUtil";
import ApiReturnModel from "../../models/ApiReturnModel";

export default {
  name: 'login',
  data() {
    return {
      /**
       * 表单数据
       */
      from: {
        account: "",
        password: ""
      }
    }
  },
  created() {
    this.checkIsInit();
  },
  methods: {
    /**
     * 检查系统是否已经初始化
     */
    checkIsInit() {
      let that = this;
      
      HttpUtil.xmlHttpRequestPost(
        "/user/is-init-system",
        {},
        (response) => {
          let apiResponse = ApiReturnModel.initByXmlResponse(response);
          if (apiResponse.code > 0) {
            if ( apiResponse.data.isInitAdmin === "false" ) {
              // 未初始化管理员账号，跳转到初始化页面
              that.$router.push({ path: 'init' })
            }
          } else {
            console.error(apiResponse);
          }
        },
        (error) => {
          console.error(error);
        },
        5000
      );
    },
  
    /**
     * 提交登录表单
     */
    submitLogin() {
    
    }
  }
}
</script>

<style scoped>

</style>
