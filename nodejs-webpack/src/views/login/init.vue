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
        this.$message.error('两次输入的密码不同')
        return
      }
      HttpUtil.post('/user/init-admin-user', {account: this.account, password: EncryptUtil.md5(this.password)}, (apiReturn) => {
        console.log(apiReturn)
      })
      console.log(this.account, this.password, this.passwordCheck)
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
