<template>
  <main id='loginInit'>
    <el-row>
      <h3>初始化系统</h3>
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
            <el-input v-model='account' auto-complete='off'></el-input>
          </el-form-item>
          <el-form-item label='登录密码'>
            <el-input type='password' v-model='password' auto-complete='off'></el-input>
          </el-form-item>
          <el-form-item label='再次确认'>
            <el-input type='password' v-model='passwordCheck' auto-complete='off'></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type='primary' @click='submitAdmin'>初始化</el-button>
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
import ApiReturnModel from "../../models/ApiReturnModel";

export default {
  name: 'init',
  data: () => {
    return {
      account: '',
      password: '',
      passwordCheck: ''
    }
  },
  methods: {
    submitAdmin () {
      if (this.password !== this.passwordCheck) {
        this.$message.warning('两次输入的密码不同');
        return;
      }
      if (this.password.length < 6) {
        this.$message.warning('密码不能少于6个字符');
        return;
      }
      if (this.account.length < 4) {
        this.$message.warning('账号不能少于4个字符');
      }
      let thisVue = this;
      
      this.axios.post(HttpUtil.getBaseUrl() + "/user/init-admin-user",
        HttpUtil.objectToPostParams({account: this.account, password: EncryptUtil.md5(this.password)})
      ).then((response) => {
        let apiReturn = ApiReturnModel.initByResponse(response);
        if (apiReturn.code > 0) {
          this.$message.success(apiReturn.message);
          setTimeout(() => {
            this.$store.commit("setSysInit");
          }, 800);
        } else {
          thisVue.$message.error(apiReturn.message);
        }
      }).catch((error) => {
        console.error(error);
        thisVue.$message.error("请求服务器异常");
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
