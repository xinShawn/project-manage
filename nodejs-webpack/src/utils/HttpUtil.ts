'use strict'

import axios from 'axios'
import ApiReturnModel from "../models/ApiReturnModel";

/**
 * http 请求工具封装
 */
export default class HttpUtil {

  /**
   * 向服务器发送 post 请求
   * @param url 请求地址
   * @param params post参数
   * @param succCallback 成功回调
   * @param errorCallback 失败回调
   * @param completeCallback 无论成功或失败都回调
   */
  public static post(url: string, params: object = {}, succCallback: Function = undefined, errorCallback: Function = undefined, completeCallback: Function = undefined): void {
    axios.post(HttpUtil.getBaseUrl() + url, HttpUtil.objectToPostParams(params)).then((response: any) => {
      if (response.status === 200) {

        let apiReturn = new ApiReturnModel(response.data.code, response.data.msg, response.data.data);
        if (succCallback !== undefined) {
          succCallback(apiReturn);
        }
      } else {
        console.error(response)
        if (errorCallback !== undefined) {
          errorCallback(response);
        }
      }

      if (completeCallback !== undefined) {
        completeCallback();
      }
    }).catch((e) => {
      console.error(e);

      if (errorCallback !== undefined) {
        errorCallback(e);
      }

      if (completeCallback !== undefined) {
        completeCallback();
      }
    })
  }

  /**
   * 获取请求的基本路径
   */
  private static getBaseUrl(): string {
    return (process.env.NODE_ENV === 'development') ? '/api' : ''
  }

  /**
   * 把 对象数据 转为 提交格式的字符串
   */
  private static objectToPostParams(obj: object): URLSearchParams {
    let params: URLSearchParams = new URLSearchParams();

    for (let name in obj) {
      if (obj.hasOwnProperty(name)) {
        let value = obj[name];
        params.append(name, value);
      }
    }

    return params;
  }
}
