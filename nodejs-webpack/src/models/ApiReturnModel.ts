'use strict'
/**
 * 请求后台返回的数据通用模型
 */
export default class ApiReturnModel {
  public code: Number;

  public constructor (response: any) {
    this.code = response.data.code;
  }
}
