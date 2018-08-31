

export default {
  namespace: true,
  
  /**
   * 变量封装（不推荐直接引用这里的变量）
   */
  state: {
    /**
     * @type Boolean 是否已经登录
     */
    loginStatus: false,
  },
  
  /**
   * 变量获取的方法
   */
  getters: {
    isLogin(state) {
      return state.loginStatus;
    }
  },
  
  /**
   * 对 mutations 的进一步封装，支持异步。
   */
  actions: {
    setLogin ({ commit }) {
      commit("setLogin");
    }
  },
  
  /**
   * 设置store的方法。不支持异步
   */
  mutations: {
    setLogin (state) {
      state.loginStatus = true;
    }
  }
}
