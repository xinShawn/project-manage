
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  /**
   * 整个单页应用的状态属性
   */
  state: {
    /**
     * @type {Boolean} 是否已经登录
     */
    isLogin: true
  },

  getters: {

  },

  mutations: {

  }
})

export default store
