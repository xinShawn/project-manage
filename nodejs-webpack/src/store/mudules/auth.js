
export default {
  namespace: true,
  /**
   * 变量封装（不推荐直接引用这里的变量）
   */
  state: {
    auth: {
      /**
       * 是否已经登陆
       */
      isLogin: false,
      /**
       * 是否已经初始化了管理员
       */
      isInit: true
    }
  },
  /**
   * 变量获取的方法
   */
  getters: {
    isInit: store => {
      return store.auth.isInit
    }
  },
  /**
   * 对 mutations 的进一步封装
   */
  actions: {
  },
  /**
   * 设置store的方法
   */
  mutations: {
    /**
     * 设置系统为未初始化
     */
    setSysNotInit (state) {
      state.auth.isInit = false
    }
  }
}
