package cn.cinling.javacommon.exception;

/**
 * HttpUtil 抛出的异常类
 */
public class HttpUtilException extends Exception {

    /**
     * http 状态吗
     */
    private Integer responseCode;

    /**
     *
     * @param message 异常信息
     */
    public HttpUtilException(String message) {
        super(message);
    }

    public Integer getResponseCode() {
        return responseCode;
    }

    public void setResponseCode(Integer responseCode) {
        this.responseCode = responseCode;
    }

}
