<template>
  <main class="login-login">
    <el-row>
      <el-col
        :sm="{span: 8, offset: 8}"
        :xs="24">
        <div class="login-panel">
          <div class="login-form">
            <section>
              <h1 class="login-form-title">{{ $t("sign in project manage") }}</h1>
            </section>
            <section>
              <el-input v-model="form.data.account"
                autocomplete="off"
                :placeholder="$t('account')"></el-input>
            </section>
            <section>
              <el-input v-model="form.data.password"
                @keyup.enter.native="submitLogin"
                type="password"
                autocomplete="off"
                :placeholder="$t('password')"></el-input>
            </section>
            <section>
              <el-button @click='submitLogin'
                         v-loading="form.loading"
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
      form: {
        loading: false,
        data: {
          account: "",
          password: ""
        }
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
      this.form.loading = true;
      
      HttpUtil.axiosPost("user/login", {account: this.form.data.account, password: EncryptUtil.md5(this.form.data.password)}, (apiReturn) => {
          if (apiReturn.code > 0) {
            let loginToken = apiReturn.data.loginToken;
            this.$store.dispatch("setLoginToken", loginToken);
            NotifyUtil.success(apiReturn.message);
            this.$router.push("../main");
          } else {
            NotifyUtil.error(apiReturn.message)
          }
          this.form.loading = false;
        },
        (error) => {
          console.error(error);
          NotifyUtil.error(this.$t("Request timeout"));
          this.form.loading = false;
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
<style lang="scss" scoped>
  .login-login {
    width: 100%;
    height: 100%;
    background-size: cover;
    background: url("./../../assets/img/login-bg.jpg") center center;
  }
  
  .login-panel {
    margin: 100px auto 0;
    padding: 5px;
    width: 400px;
  }

  .login-form {
    padding: 5px 20px;
    background-color: white;
    border-radius: 4px;
  }
  
  .login-form-title {
    text-align: center;
  }
  
  .login-form section {
    margin: 20px 0;
  }
  
  /*手机端兼容*/
  @media only screen and (max-width: 768px) {
    .login-panel {
      padding: 0;
      width: 96%;
    }
  }
</style>
