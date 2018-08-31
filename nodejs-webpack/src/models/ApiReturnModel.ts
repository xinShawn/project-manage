'use strict'
/**
 * 请求后台返回的数据通用模型
 */
export default class ApiReturnModel {
  /**
   * api 请求状态码（主要区分成功或失败）
   */
  public readonly code: Number;
  /**
   * api 请求返回消息
   */
  public readonly message: String;
  /**
   * qpi 请求返回数据
   */
  public readonly data: any;

  /**
   * @param code
   * @param message
   * @param data
   */
  public constructor (code: Number, message: String, data: any) {
    this.code = code;
    this.message = message;
    this.data = data;
  }

  /**
   * 使用 axios 的 response 实例化 ApiReturnModel 并返回
   * @param response
   * @throws
   */
  public static initByAxiosResponse(response: any): ApiReturnModel {
    if (response.status === 200) {
      return new ApiReturnModel(response.data.code, response.data.msg, response.data.data);
    } else {
      console.error(response);
      throw new Error("请求失败");
    }
  }

  /**
   *使用 XMLHttpRequest 的 response 实例化 ApiReturnModel 并返回
   * @param response
   */
  public static initByXmlResponse(response: any): ApiReturnModel {
    let json = JSON.parse(response);
    return new ApiReturnModel(json.code, json.msg, json.data);
  }
}
