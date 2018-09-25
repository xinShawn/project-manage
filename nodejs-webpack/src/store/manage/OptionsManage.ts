'use strict';
import OptionsModel from "../../models/OptionsModel";

/**
 * 选项数据的管理
 */
export default class OptionsManage {
  /**
   * 共享实例
   */
  private static shareInstance: OptionsManage = null;

  private optionsArray: any = {
    priority: new OptionsModel("/mission/get-priority-rich-options")
  };

  /**
   * 获取实例
   */
  public static getInstance(): OptionsManage {
    if (OptionsManage.shareInstance === null) {
      OptionsManage.shareInstance = new OptionsManage();
    }
    return OptionsManage.shareInstance;
  }

  /**
   * 构造函数
   */
  public constructor() {
  }

  /**
   * 获取优先级选项
   */
  public setPriorityOptions(setOptionsCallback: SetOptionsCallback) {
    this.optionsArray.priority.setOptions(setOptionsCallback);
  }
}

export interface SetOptionsCallback {
  (options: any): void;
}
