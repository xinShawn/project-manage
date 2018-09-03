'use strict'


import {Md5} from "ts-md5";

/**
 * 加密工具类
 */
export default class EncryptUtil {

  /**
   * md5 加密
   * @param str
   */
  public static md5(str: string): string {
    return Md5.hashStr(str).toString();
  }
}
