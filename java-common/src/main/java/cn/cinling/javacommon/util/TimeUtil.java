package cn.cinling.javacommon.util;

public class TimeUtil {
    /**
     * @return 当前时间戳。单位：秒
     */
    public static int GetTime() {
        return (int) (System.currentTimeMillis() / 1000);
    }
}
