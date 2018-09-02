

export default {
  namespace: true,
  
  /**
   * 变量封装（不推荐直接引用这里的变量）
   */
  state: {
    /**
     * @var Boolean 是否已经登录
     */
    loginStatus: false,
  
    /**
     * @var string 登录令牌
     */
    loginToken: ""
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
    /**
     * 设置登录令牌并进行登录
     * @param commit
     * @param loginToken
     */
    setLoginToken ({ commit }, loginToken) {
      commit("setLoginToken", loginToken);
    }
  },
  
  /**
   * 设置store的方法。不支持异步
   */
  mutations: {
    setLoginToken (state, loginToken) {
      state.loginStatus = true;
      state.loginToken = loginToken;
    }
  }
}
