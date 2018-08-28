'use strict'
/**
 * 请求后台返回的数据通用模型
 */
export default class ApiReturnModel {
  /**
   * api 请求状态码（主要区分成功或失败）
   */
  private readonly _code: Number;
  /**
   * api 请求返回消息
   */
  private readonly _message: String;
  /**
   * qpi 请求返回数据
   */
  private readonly _data: any;

  /**
   * @param code
   * @param message
   * @param data
   */
  public constructor (code: Number, message: String, data: any) {
    this._code = code;
    this._message = message;
    this._data = data;
  }

  /**
   * 处理结果状态码
   */
  get code(): Number {
    return this._code;
  }

  /**
   * 处理结果消息
   */
  get message(): String {
    return this._message;
  }

  /**
   * 处理结果数据
   */
  get data(): any {
    return this._data;
  }
}
