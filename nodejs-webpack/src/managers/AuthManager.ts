/**
 * 权限服务类
 */
import HttpUtil from "../utils/HttpUtil";
import ApiReturnModel from "../models/ApiReturnModel";
import MP from "./MP";

export default class AuthManager {
  public isInit: Boolean = true;
  public isLogin: Boolean = false;

  /**
   * 构造函数，构造时进行请求检查登录状态
   */
  public constructor() {
    this.checkLogin();

    // 理论上不用每次都检测
    this.checkInit();
  }

  /**
   * 是否是不需要权限验证的路由
   */
  public isNotAuthRoute (route: string): boolean {
    if (route.indexOf("/") !== 0) {
      route = "/" + route;
    }

    if (route === "/login") {
      return true;
    }

    return false;
  }

  /**
   * 检查是否已经登录
   */
  private checkLogin(): void {

  }

  /**
   * 检查是否已经初始化
   */
  private checkInit(): void {
    HttpUtil.xmlHttpRequestPost("/user/is-init-admin-user", {}, (response: any) => {
      let apiReturn: ApiReturnModel = ApiReturnModel.initByXmlResponse(response);
      if (apiReturn.code > 0) {
        if (apiReturn.data.isInitAdmin === "false") {
          MP.getAuthManager().isInit = false;
        }
      } else {
        console.error(apiReturn);
      }
    }, (error) => {
      console.error(error);
    }, 5000);
  }
}
