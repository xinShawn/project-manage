
import AuthManager from "./AuthManager";
/**
 * 所有管理类的代理类  manager proxy
 */
export default class MP {
  private static authManager: AuthManager = null;

  /**
   * 权限
   */
  public static getAuthManager () : AuthManager {
    if (MP.authManager === null) {
      MP.authManager = new AuthManager();
    }
    return MP.authManager;
  }
}
