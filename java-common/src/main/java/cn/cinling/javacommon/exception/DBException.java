package cn.cinling.javacommon.exception;

public class DBException extends BaseException {

    /**
     * 插入数据失败
     */
    public static final int INSERT_ERROR = 2;

    public DBException(Integer code) {
        super(code);
    }
}
