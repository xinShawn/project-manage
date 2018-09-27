/**
 * 数据帮助工具类
 */
export default class DataUtil {
  /**
   * 字符串切割
   * @param origin
   * @param token
   */
  public static split(origin: string, token: string): string[] {
    return origin.split(token);
  }
}
