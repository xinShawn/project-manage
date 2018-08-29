
import ApiReturnModel from "../../models/ApiReturnModel";
import axios from "axios";

export default {
  namespace: true,
  
  /**
   * 变量封装（不推荐直接引用这里的变量）
   */
  state: {
    /**
     * 是否已经登陆
     */
    isLogin: false,
    /**
     * 是否已经初始化了管理员
     */
    isInit: true
  },
  
  /**
   * 变量获取的方法
   */
  getters: {
  },
  
  /**
   * 对 mutations 的进一步封装，支持异步。
   */
  actions: {
    /**
     * 设置是否初始化了管理员账号
     * @param commit
     */
    setIsInitAdmin ({ commit }) {
      axios.post('/api/user/is-init-admin-user', {}).then((response) => {
        let apiReturn = ApiReturnModel.initByResponse(response)
        let isInit = apiReturn.data["isInitAdmin"];
        if (isInit === "false") {
          commit('setSysNotInit');
        } else {
          commit("setSysInit");
        }
      }).catch((e) => {
        console.error(e);
      })
    }
  },
  
  /**
   * 设置store的方法。不支持异步
   */
  mutations: {
    /**
     * 设置系统为未初始化
     */
    setSysNotInit (state) {
      state.isInit = false;
      console.log(false);
    },
  
    /**
     * 设置系统为初始化
     * @param state
     */
    setSysInit(state) {
      state.isInit = true;
      console.log(true);
    }
  }
}
