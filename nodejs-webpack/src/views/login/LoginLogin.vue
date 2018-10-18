<template>
  <main class="login-login">
    <el-row>
      <el-col
        :sm="{span: 8, offset: 8}"
        :xs="24">
        <div class="login-panel">
          <div class="login-form">
            <section>
              <h1 style="color: white">{{ $t("sign in project manage") }}</h1>
            </section>
            <section>
              <el-input v-model="from.account"
                autocomplete="off"
                :placeholder="$t('account')"></el-input>
            </section>
            <section>
              <el-input v-model="from.password"
                @keyup.enter.native="submitLogin"
                type="password"
                autocomplete="off"
                :placeholder="$t('password')"></el-input>
            </section>
            <section>
              <el-button @click='submitLogin'
                style="width: 100%"
                type='primary'>{{ $t("login") }}</el-button>
            </section>
          </div>
        </div>
      </el-col>
    </el-row>
  </main>
</template>

<script>
import HttpUtil from "../../utils/HttpUtil";
import EncryptUtil from "../../utils/EncryptUtil";
import NotifyUtil from "../../utils/NotifyUtil";

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
            NotifyUtil.success(apiReturn.message);
            that.$router.push("../main");
          } else {
            NotifyUtil.error(apiReturn.message)
          }
        },
        (error) => {
          console.error(error);
          NotifyUtil.error(that.$t("Request timeout"));
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

<!--局部样式（仅本页有效）-->
<style scoped>
  .login-login {
    width: 100%;
    height: 100%;
    background-size: cover;
    background: url("./../../assets/img/login-bg.jpg") center center;
  }
  
  .login-panel {
    margin-top: 100px;
    padding: 5px;
  }

  .login-form {
    padding: 5px 20px;
    text-align: center;
    border: 1px solid #333;
    background-color: rgba(255, 255, 255, 0.15);
    border-radius: 10px;
  }
  
  .login-form section {
    margin: 20px 0;
  }
  
  /*手机端兼容*/
  @media only screen and (max-width: 768px) {

  }
</style>

<!--全局样式-->
<style>
  /*设置输入框样式*/
  .login-form .el-input__inner {
    color: white;
    background-color: rgba(0, 0, 0, 0.6);
    border-color: #333;
  }
  
  /*按钮样式*/
  .login-form .el-button--primary {
    background-color: rgba(0, 0, 0, 0.6);
    border-color: #333;
  }
</style>
