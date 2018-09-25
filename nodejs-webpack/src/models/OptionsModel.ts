'use strict';
import HttpUtil from "../utils/HttpUtil";
import ApiReturnModel from "./ApiReturnModel";
import {SetOptionsCallback} from "../store/manage/OptionsManage";

/**
 * 选项模型
 */
export default class OptionsModel {

  /**
   * 选项状态：未使用
   * @type {number}
   */
  public static readonly OPTIONS_STATUS_NOT_USE: number = 0;
  /**
   * 选项状态：等待请求完成
   * @type {number}
   */
  public static readonly OPTIONS_STATUS_WAIT_REQUEST: number = 10;
  /**
   * 选项状态：完成请求，可正常使用
   * @type {number}
   */
  public static readonly OPTIONS_STATUS_FINISHED: number = 20;

  /**
   * 状态
   */
  private status: number;
  /**
   * 请求地址
   */
  private readonly url: string;
  /**
   * 数据
   */
  private data: Array<object>;
  /**
   * 请求锁，防止多次请求
   */
  private lock: boolean = false;

  /**
   * 构造函数
   * @param url
   */
  public constructor(url: string) {
    this.url = url;
    this.status = OptionsModel.OPTIONS_STATUS_NOT_USE;
    this.data = [];
  }

  /**
   * 获取请求数据的url
   */
  public getUrl() {
    return this.url;
  }

  /**
   * 获取状态
   */
  public getStatus(): number {
    return this.status;
  }

  /**
   * 获取选项数据
   */
  public setOptions(setOptionsCallback: SetOptionsCallback) {
    if (this.status === OptionsModel.OPTIONS_STATUS_NOT_USE) {
      this.setWaitRequest();
      this.requestData(setOptionsCallback);
    } else {
      setOptionsCallback(this.data);
    }
  }

  /**
   * 设置请求状态
   */
  public setWaitRequest(): void {
    this.status = OptionsModel.OPTIONS_STATUS_WAIT_REQUEST;
  }

  /**
   * 设置完成状态
   */
  public setFinished(): void {
    this.status = OptionsModel.OPTIONS_STATUS_FINISHED;
  }

  /**
   * 请求数据
   */
  public requestData(setOptionsCallback: SetOptionsCallback): void {
    if (this.lock) {
      return;
    }
    this.lock = true;

    HttpUtil.axiosPost(this.url, {}, (apiReturn: ApiReturnModel) => {
      if (apiReturn.code > 0) {
        this.data = apiReturn.data;
        setOptionsCallback(this.data);
        this.setFinished();
      } else {
        console.error(apiReturn);
      }
      this.lock = false;
    }, (error) => {
      console.error(error);
      this.lock = false;
    })
  }
}
