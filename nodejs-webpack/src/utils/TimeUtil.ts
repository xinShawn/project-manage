/**
 * 时间工具
 */
export default class TimeUtil {
  /**
   * 时间戳转时间
   * @param {String|Number} timestamp 时间戳（秒 或 毫秒）
   */
  public static timestampToDate(timestamp) {
    let time = parseInt(timestamp);
    if (time < 2000000000) {
      time *= 1000;
    }
    const dateMat= new Date(time);
    const year = dateMat.getFullYear();
    const month = dateMat.getMonth() + 1;
    const day = dateMat.getDate();
    const hh = dateMat.getHours();
    const mm = dateMat.getMinutes();
    const ss = dateMat.getSeconds();

    return year + "-" + month + "-" + day + " " + hh + ":" + mm + ":" + ss;
  }
};
