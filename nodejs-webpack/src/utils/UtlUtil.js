
class UrlUtil {
  /**
   * 获取基础路径
   * @returns {string}
   */
  static getBaseUrl () {
    return (process.env.NODE_ENV === 'development') ? '/api' : ''
  }
}

export default UrlUtil
