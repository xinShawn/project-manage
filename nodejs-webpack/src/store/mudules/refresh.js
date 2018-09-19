
/**
 * 刷新处理相关处理的封装
 */
export default {
  namespace: true,
  
  state: {
    /**
     * missionHome 页面的状态封装
     */
    missionHome: {
      table: true
    }
  },
  
  /**
   * 调用 getters 获取 state 中的值
   */
  getters: {
  },
  
  /**
   * 可异步的方法
   */
  actions: {
  
  },

  /**
   * 不可异步的方法
   */
  mutations: {
    /**
     * 需要刷新
     * @param state
     */
    onMissionHomeTable(state) {
      state.missionHome.table = true;
    },
  
    /**
     * 不需要刷新
     * @param state
     */
    offMissionHomeTable(state) {
      state.missionHome.table = false;
    }
  }
}
