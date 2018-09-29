<template>
  <main id='loginInit'>
    <el-row>
      <h3>{{ $t("init system") }}</h3>
    </el-row>
    <el-row :gutter='20' class='login-row'>
      <!--START 两边空白占位区-->
      <el-col :span='6'>
        <div>&nbsp;</div>
      </el-col>
      <!--END 两边空白占位区-->
      <el-col :span='12' class='initPanel'>
        <el-form ref='form' label-width='100px'>
          <el-form-item :label='$t("account")'>
            <el-input v-model='form.account' autocomplete='off'></el-input>
          </el-form-item>
          <el-form-item :label='$t("password")'>
            <el-input type='password' v-model='form.password' autocomplete='off'></el-input>
          </el-form-item>
          <el-form-item :label='$t("confirmation")'>
            <el-input type='password' v-model='form.passwordCheck' autocomplete='off'></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type='primary' @click='submitAdmin'>{{ $t("initialize") }}</el-button>
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
import HttpUtil from '../../utils/HttpUtil'
import EncryptUtil from '../../utils/EncryptUtil'
import NotifyUtil from "../../utils/NotifyUtil";

export default {
  name: 'LoginInit',
  data: () => {
    return {
      form: {
        account: '',
        password: '',
        passwordCheck: ''
      }
    }
  },
  methods: {
    submitAdmin () {
      if (this.form.password !== this.form.passwordCheck) {
        NotifyUtil.warning(this.$t("the two passwords were different"));
        return;
      }
      if (this.form.password.length < 6) {
        NotifyUtil.warning(this.$t("The password must be no less than 6 characters"));
        return;
      }
      if (this.form.account.length < 4) {
        NotifyUtil.warning(this.$t("The account must be no less than 4 characters"));
      }
      
      HttpUtil.axiosPost("/user/init-admin-user", {account: this.form.account, password: EncryptUtil.md5(this.form.password)}, (apiReturn) => {
        if (apiReturn.code > 0) {
          NotifyUtil.success(apiReturn.message);
          this.$router.push({path: "/login"});
        } else if (apiReturn.code === -4) {
          // 已经初始化
          NotifyUtil.warning(apiReturn.message);
          this.$router.push({path: "/login"})
        } else {
          NotifyUtil.error(apiReturn.message);
        }
      }, (error) => {
        console.error(error);
        NotifyUtil.error(this.$t("Request server exception"));
      });
    }
  },
  watch: {
  }
}
</script>

<style scoped>
#loginInit {
  padding-top: 120px;
  height: 100%;
}

.initPanel {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
