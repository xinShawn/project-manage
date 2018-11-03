/**
 * 检测登录状态的工具
 */
import HttpUtil from "./HttpUtil";
import ApiReturnModel from "../models/ApiReturnModel";

export default class CheckLoginUtil {
  private static timer: any = null;

  /**
   * 开始循环
   */
  public static startLoop(): void {
    CheckLoginUtil.timer = setInterval(() => {
      CheckLoginUtil.check();
    }, 100000);
  }

  /**
   * 马上进行检测
   */
  public static checkNow(): void {
    clearInterval(CheckLoginUtil.timer);
    CheckLoginUtil.check();
    CheckLoginUtil.startLoop();
  }

  /**
   * 检测登录状态的方法
   */
  private static check(): void {
    HttpUtil.axiosPost("user/check-login", {}, (apiReturn: ApiReturnModel) => {
      if (apiReturn.code > 0 && apiReturn.data.loginToken === null) {
        window.location.reload();
      }
    });
  }
}
