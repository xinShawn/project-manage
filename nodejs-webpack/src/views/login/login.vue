<template>
  <main>
    <el-row>
      <h3>{{ $t("login['login page']") }}</h3>
    </el-row>
    <el-row :gutter='20' class='login-row'>
      <!--START 两边空白占位区-->
      <el-col :span='6'>
        <div>&nbsp;</div>
      </el-col>
      <!--END 两边空白占位区-->
      <el-col :span='12' class='initPanel'>
        <el-form ref='form' label-width='80px'>
          <el-form-item :label='$t("login[\"account\"]")'>
            <el-input v-model='from.account' auto-complete='off'></el-input>
          </el-form-item>
          <el-form-item :label='$t("login[\"password\"]")'>
            <el-input type='password' v-model='from.password' auto-complete='off'></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type='primary' @click='submitLogin'>{{ $t("login['login']") }}</el-button>
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
import EncryptUtil from "../../utils/EncryptUtil";

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
      let that = this;
      
      HttpUtil.xmlHttpRequestPost(
        "user/login",
        {account: this.from.account, password: EncryptUtil.md5(this.from.password)},
        (response) => {
          let apiReturn = ApiReturnModel.initByXmlResponse(response);
          if (apiReturn.code > 0) {
            let loginToken = apiReturn.data.loginToken;
            that.$store.dispatch("setLoginToken", loginToken);
            that.$message.success(apiReturn.message);
            that.$router.push("../main");
          } else {
            that.$message.error(apiReturn.message)
          }
        },
        (error) => {
          console.error(error);
          that.$message.error(that.$t("error['Request timeout']"));
        },
        5000
      )
    }
  }
}
</script>

<style scoped>

</style>
