package cn.cinling.javacommon.util;

import java.util.Random;

/**
 * 随机生成器
 */
public class RandomUtil {

    private static final String STRING_SOURCES = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    private static Random random = null;

    /**
     * @param length 长度
     * @return 随机字符串
     */
    public static String GenerateString(int length) {
        StringBuilder sb = new StringBuilder();
        int strLen = RandomUtil.STRING_SOURCES.length();
        Random random = RandomUtil.GetRandom();

        for (int i = 0; i < length; ++i) {
            int index = random.nextInt(strLen);
            sb.append(RandomUtil.STRING_SOURCES.charAt(index));
        }

        return sb.toString();
    }

    private static Random GetRandom() {
        if (RandomUtil.random == null) {
            RandomUtil.random = new Random();
        }
        return RandomUtil.random;
    }
}
