package cn.cinling.javacommon.exception;

/**
 * 所有异常的基类
 */
public class BaseException extends Exception {

    private Integer code;
    private String message;

    public BaseException(Integer code) {
        super("");
        this.code = code;
    }

    public BaseException(Integer code, String message) {
        super(message);
        this.code = code;
    }

    public int GetCode() {
        return this.code;
    }

    public String GetMessage() {
        return this.message;
    }
}
