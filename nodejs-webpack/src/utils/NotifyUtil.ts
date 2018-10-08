import {Notification} from "element-ui";
import i18n from "./i18n";

/**
 * 通知工具
 */
export default class NotifyUtil {
  /**
   * 成功消息
   * @param message
   * @param title
   */
  public static success(message: string, title: string = i18n.t("operate successfully")) {
    Notification.success({title: title, message: message, position: "bottom-right"});
  }

  /**
   * 失败消息
   * @param message
   * @param title
   */
  public static warning(message: string, title: string = i18n.t("warning")) {
    Notification.warning({title: title, message: message, position: "bottom-right"});
  }

  /**
   * 失败消息
   * @param message
   * @param title
   */
  public static error(message: string, title: string = i18n.t("operation failure")) {
    Notification.error({title: title, message: message, position: "bottom-right"});
  }
}
