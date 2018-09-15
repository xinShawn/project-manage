import HttpUtil from "../../utils/HttpUtil";
import ApiReturnModel from "../../models/ApiReturnModel";


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
    },
    
    /**
     * 检测是否已经登录
     * @param commit
     * @param state
     * @param needLoginCallback。检测后结果的返回。带有一个参数是否需要登录 needLoginCallback(isNeedLogin);
     * @return {Promise<void>}
     */
    async checkLogin ({ commit, state }, needLoginCallback) {
      
      if (state.loginToken !== "") {
        commit("setLoginToken", state.loginToken);
        needLoginCallback(false);
      } else {
        HttpUtil.axiosPost("/user/check-login", {},
          (apiReturn) => {
            if (apiReturn.code < 0) {
              console.error(apiReturn);
              needLoginCallback(true);
              return;
            }
            let loginToken = apiReturn.data.loginToken;
            if (loginToken === "" || loginToken === null) {
              commit("setNotLogin");
              needLoginCallback(true);
              return;
            }
            
            commit("setLoginToken", loginToken);
            needLoginCallback(false);
          },
          (error) => {
            console.error(error);
            needLoginCallback(true);
          },
          5000);
      }
    },
  },
  
  /**
   * 设置store的方法。不支持异步
   */
  mutations: {
    /**
     * 设置 loginToken 并把状态 已登录
     * @param state
     * @param loginToken
     */
    setLoginToken (state, loginToken) {
      state.loginStatus = true;
      state.loginToken = loginToken;
    },
  
    /**
     * 设置状态为 未登录
     */
    setNotLogin(state) {
      state.loginStatus = false;
      state.loginToken = "";
    }
  }
}
