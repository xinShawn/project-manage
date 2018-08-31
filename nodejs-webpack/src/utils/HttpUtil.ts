'use strict'

import axios from 'axios'
import ApiReturnModel from "../models/ApiReturnModel";

/**
 * http 请求工具封装
 */
export default class HttpUtil {

  /**
   * 发送post请求
   * @deprecated 向服务器发送 post 请求 注意：这个方法不做任何错误的处理，只做超时处理。而且方法会抛出位置的错误
   * @param url 请求地址
   * @param params post参数
   * @param succCallback 成功回调
   * @param timeoutMS 超时：毫秒
   * @param timeoutCallback 超时回调
   */
  public static axiosPost(url: string, params: object = {}, succCallback: Function = undefined,
                     timeoutMS: Number = 500, timeoutCallback: Function = undefined): void {
    let isSuccCallback = false;

    try {
      axios.post(HttpUtil.getBaseUrl() + url, HttpUtil.objectToPostParams(params)).then((response: any) => {
        if (response.status === 200) {
          let apiReturn = new ApiReturnModel(response.data.code, response.data.msg, response.data.data);
          if (succCallback !== undefined) {
            isSuccCallback = true;
            succCallback(apiReturn);
          }
        }
      });
    } catch (error) {

    }

    setTimeout(() => {
      if (!isSuccCallback && timeoutCallback !== undefined) {
        timeoutCallback();
      }
    }, timeoutMS);
  }

  /**
   * 发送 post 请求。使用原声js的方法(XMLHttpRequest)
   * @param relativeUrl 请求相对路径
   * @param params
   * @param success
   * @param error
   * @param timeoutMS
   */
  public static xmlHttpRequestPost(relativeUrl: string, params: object, success: Function, error: Function, timeoutMS: number) {
    if (relativeUrl.indexOf("/", 0) !== 0) {
      relativeUrl = "/" + relativeUrl;
    }
    let xmlHttp = new XMLHttpRequest();

    xmlHttp.responseType = "text";
    xmlHttp.onreadystatechange = function () {

      if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        success(xmlHttp.response);
      } else if (xmlHttp.readyState == 4) {
        error({
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
        error("request timeout!");
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
