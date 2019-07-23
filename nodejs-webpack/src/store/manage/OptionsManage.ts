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

  /**
   * 普通选项。如：{ 值 : 名字, ... }
   * @param {object}
   */
  private optionsArray: any = {
    project: new OptionsModel("/project/get-options")
  };

  /**
   * 富选项。如：[{id : id值, name: 名字, time: 时间}, ...]
   * @param {object}
   */
  private fullOptionsArray: any = {
    priority: new OptionsModel("/mission/get-priority-rich-options"),
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
   * 设置优先级选项
   * @param setOptionsCallback
   */
  public setPriorityFullOptions(setOptionsCallback: SetOptionsCallback) {
    this.fullOptionsArray.priority.setOptions(setOptionsCallback);
  }

  /**
   * 设置项目选项
   * @param setOptionsCallback
   */
  public setProjectOptions(setOptionsCallback: SetOptionsCallback) {
    this.optionsArray.project.setOptions(setOptionsCallback);
  }
}

export interface SetOptionsCallback {
  (options: any): void;
}
