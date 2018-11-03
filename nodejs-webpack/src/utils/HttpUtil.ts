'use strict';

import axios from 'axios'
import ApiReturnModel from "../models/ApiReturnModel";
import CheckLoginUtil from "./CheckLoginUtil";

const Qs = require('querystring')


/**
 * http 请求工具封装
 */
export default class HttpUtil {

  /**
   * 发送post请求 使用 axios
   * @author Cinling
   * @version 该方法不能保证稳定运行，可能会出现未知的错误
   * @see 向服务器发送 post 请求 注意：这个方法不做任何错误的处理，只做超时处理。而且方法会抛出未知的错误
   * @param url 请求地址
   * @param params post参数
   * @param succCallback 成功回调
   * @param errorCallback 错误回调
   * @param timeoutMS 超时：毫秒
   */
  public static axiosPost(url: string, params: object = {}, succCallback: SuccCallback = undefined, errorCallback: Function = undefined, timeoutMS: number = 60000) {

    try {
      axios.post(HttpUtil.getBaseUrl() + url, params, {
        transformRequest: [
          function (data) {
            Object.keys(data).forEach((key) => {
              if ((typeof data[key]) === 'object') {
                data[key] = JSON.stringify(data[key]) // 这里必须使用内置JSON对象转换
              }
            });
            data = Qs.stringify(data); // 这里必须使用qs库进行转换
            return data
          }
        ],
        timeout: timeoutMS,
      }).then((response: any) => {
        try {
          let apiReturn: ApiReturnModel = ApiReturnModel.initByAxiosResponse(response);
          if (succCallback !== undefined) {
            succCallback(apiReturn);
          }
        } catch (e) {
          CheckLoginUtil.checkNow();
          throw e;
        }
      });
    } catch (error) {
      if (errorCallback !== undefined) {
        errorCallback(error);
      }
      CheckLoginUtil.checkNow();
    }
  }

  /**
   * 获取请求的基本路径
   */
  public static getBaseUrl(): string {
    return (process.env.NODE_ENV === 'development') ? '/api' : ''
  }
}

/**
 * http成功回调方法接口定义
 */
export interface SuccCallback {
  (apiReturn: ApiReturnModel): void;
}
