'use strict';

import axios from 'axios'
import ApiReturnModel from "../models/ApiReturnModel";

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
  public static axiosPost(url: string, params: object = {}, succCallback: SuccCallback = undefined, errorCallback: Function = undefined, timeoutMS: number = 5000) {
    try {
      axios.post(HttpUtil.getBaseUrl() + url, HttpUtil.objectToPostParams(params), {timeout: timeoutMS}).then((response: any) => {
        let apiReturn: ApiReturnModel = ApiReturnModel.initByAxiosResponse(response);
        if (succCallback !== undefined) {
          succCallback(apiReturn);
        }
      });
    } catch (error) {
      console.error(error);
      if (errorCallback !== undefined) {
        errorCallback(error);
      }
    }
  }

  /**
   * 发送 post 请求。使用原生js的方法(XMLHttpRequest)
   * @deprecated 推荐使用 axiosPost 代替
   * @see axiosPost()
   * @author Cinling
   * @version 相对比较稳定的版本，但是功能不够齐全
   * @param relativeUrl 请求相对路径
   * @param params 请求参数（json object格式）
   * @param successCallback 成功回调
   * @param errorCallback 失败回调
   * @param timeoutMS 超时毫秒数
   */
  public static xmlHttpRequestPost(relativeUrl: string, params: object, successCallback: SuccCallback, errorCallback: Function, timeoutMS: number) {
    if (relativeUrl.indexOf("/", 0) !== 0) {
      relativeUrl = "/" + relativeUrl;
    }
    let xmlHttp = new XMLHttpRequest();

    xmlHttp.responseType = "text";
    xmlHttp.onreadystatechange = function () {

      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        let apiReturn = ApiReturnModel.initByXmlResponse(xmlHttp.response);
        successCallback(apiReturn);
      } else if (xmlHttp.readyState == 4) {
        errorCallback({
          status: xmlHttp.status,
          response: xmlHttp.response
        });
      }
    };

    xmlHttp.open("post", HttpUtil.getBaseUrl() + relativeUrl, true);
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    // 发送数据
    let sendData = HttpUtil.ObjectToPostStr(params);
    xmlHttp.send(sendData);

    setTimeout(function() {
      if (xmlHttp.readyState != 4) {
        xmlHttp.abort();
        errorCallback("request timeout!");
      }
    }, timeoutMS);
  }

  /**
   * 获取请求的基本路径
   */
  public static getBaseUrl(): string {
    return (process.env.NODE_ENV === 'development') ? '/api' : ''
  }

  /**
   * 把 对象数据 转为 提交格式的字符串
   */
  public static objectToPostParams(obj: object): URLSearchParams {
    let params: URLSearchParams = new URLSearchParams();

    for (let name in obj) {
      if (obj.hasOwnProperty(name)) {
        let value = obj[name];
        params.append(name, value);
      }
    }

    return params;
  }

  /**
   * 把对象转为 post 请求的字符串
   * @param object
   * @return {string}
   */
  private static ObjectToPostStr(object: object) {
    let postStr = "";

    for (let key in object) {
      if (postStr.length != 0) {
        postStr += "&";
      }
      let value = object[key];

      postStr += key + "=" + value;
    }

    return postStr;
  }
}

/**
 * http成功回调方法接口定义
 */
export interface SuccCallback {
  (apiReturn: ApiReturnModel): void;
}
