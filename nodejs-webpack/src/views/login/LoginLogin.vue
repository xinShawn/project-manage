<template>
  <main>
    <el-row>
      <h3>{{ $t("login page") }}</h3>
    </el-row>
    <el-row :gutter='20' class='login-row'>
      <!--START 两边空白占位区-->
      <el-col :span='6'>
        <div>&nbsp;</div>
      </el-col>
      <!--END 两边空白占位区-->
      <el-col :span='12' class='initPanel'>
        <el-form ref='form' label-width='80px'>
          <el-form-item :label='$t("account")'>
            <el-input v-model='from.account' autocomplete='off'></el-input>
          </el-form-item>
          <el-form-item :label='$t("password")'>
            <el-input type='password' v-model='from.password' autocomplete='off' @keyup.enter.native="submitLogin"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type='primary' @click='submitLogin'>{{ $t("login") }}</el-button>
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
  name: 'LoginLogin',
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
    this.checkIsLogin();
    this.checkIsInit();
  },
  methods: {
    /**
     * 检查系统是否已经初始化
     */
    checkIsInit() {
      let that = this;
      
      HttpUtil.axiosPost("/user/is-init-system", {}, (apiReturn) => {
          if (apiReturn.code > 0) {
            if ( apiReturn.data.isInitAdmin === "false" ) {
              // 未初始化管理员账号，跳转到初始化页面
              that.$router.push({ path: 'init' })
            }
          } else {
            console.error(apiReturn);
          }
        },
        (error) => {
          console.error(error);
        }
      );
    },
    
    /**
     * 检测是否已经登录
     */
    checkIsLogin() {
      if (this.$store.state.auth.loginStatus) {
        this.$router.push("/main");
      }
    },
  
    /**
     * 提交登录表单
     */
    submitLogin() {
      let that = this;
      
      HttpUtil.axiosPost("user/login", {account: this.from.account, password: EncryptUtil.md5(this.from.password)}, (apiReturn) => {
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
          that.$message.error(that.$t("Request timeout"));
        }
      )
    }
  },
  computed: {
    isLogin () {
      return this.$store.state.auth.loginStatus;
    }
  },
  watch: {
    isLogin (loginStatus) {
      if (loginStatus) {
        this.$router.push("/main");
      }
    }
  }
}
</script>

<style scoped>

</style>
