/**
 * 时间工具
 */
export default class TimeUtil {
  /**
   * 时间戳转时间
   * @param {String|Number} timestamp 时间戳（秒 或 毫秒）
   */
  public static timestampToDateTime(timestamp) {
    let time = parseInt(timestamp);
    if (time < 2000000000) {
      time *= 1000;
    }
    let dateMat= new Date(time);
    let year: string|number = dateMat.getFullYear();
    let month: string|number = dateMat.getMonth() + 1;
    let day: string|number = dateMat.getDate();
    let hh: string|number = dateMat.getHours();
    let mm: string|number = dateMat.getMinutes();
    let ss: string|number = dateMat.getSeconds();

    if (month < 10) {
      month = "0" + month;
    }
    if (day < 10) {
      day = "0" + day;
    }
    if (hh < 10) {
      hh = "0" + hh;
    }
    if (mm < 10) {
      mm = "0" + mm;
    }
    if (ss < 10) {
      ss = "0" + ss;
    }

    return year + "-" + month + "-" + day + " " + hh + ":" + mm + ":" + ss;
  }

  /**
   * 获取当前时间戳
   * @return int 时间戳（秒）
   */
  public static currentTime() {
    return new Date().getTime() / 1000;
  }
};
