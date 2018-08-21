package cn.cinling.javacommon.database.entity;

/**
 * CREATE TABLE `wechat_user` (
 *   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 *   `openid` varbinary(64) NOT NULL COMMENT '用户唯一标识',
 *   `session_key` varbinary(128) NOT NULL COMMENT '会话密钥',
 *   `nick_name` varbinary(64) NOT NULL DEFAULT '' COMMENT '用户昵称',
 *   `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户性别。0：为止，1：男性，2：女性',
 *   `language` varbinary(8) NOT NULL DEFAULT '' COMMENT '用户语言',
 *   `avatar_url` varbinary(200) NOT NULL DEFAULT '' COMMENT '用户头像url地址',
 *   `country` varbinary(32) NOT NULL DEFAULT '' COMMENT '国家',
 *   `province` varbinary(32) NOT NULL DEFAULT '' COMMENT '省份',
 *   `city` varbinary(32) NOT NULL DEFAULT '' COMMENT '城市',
 *   `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
 *   `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
 *   PRIMARY KEY (`id`),
 *   KEY `openid` (`openid`)
 * ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
 */
public class WechatUserEntity {
    private Integer id;
    private String openid;
    private String sessionKey;
    private String nickName;
    private Integer gender;
    private String language;
    private String avatarUrl;
    private String country;
    private String province;
    private String city;
    private Integer updateTime;
    private Integer createTime;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getOpenid() {
        return openid;
    }

    public void setOpenid(String openid) {
        this.openid = openid;
    }

    public String getSessionKey() {
        return sessionKey;
    }

    public void setSessionKey(String sessionKey) {
        this.sessionKey = sessionKey;
    }

    public String getNickName() {
        return nickName;
    }

    public void setNickName(String nickName) {
        this.nickName = nickName;
    }

    public Integer getGender() {
        return gender;
    }

    public void setGender(Integer gender) {
        this.gender = gender;
    }

    public String getLanguage() {
        return language;
    }

    public void setLanguage(String language) {
        this.language = language;
    }

    public String getAvatarUrl() {
        return avatarUrl;
    }

    public void setAvatarUrl(String avatarUrl) {
        this.avatarUrl = avatarUrl;
    }

    public String getCountry() {
        return country;
    }

    public void setCountry(String country) {
        this.country = country;
    }

    public String getProvince() {
        return province;
    }

    public void setProvince(String province) {
        this.province = province;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public Integer getUpdateTime() {
        return updateTime;
    }

    public void setUpdateTime(Integer updateTime) {
        this.updateTime = updateTime;
    }

    public Integer getCreateTime() {
        return createTime;
    }

    public void setCreateTime(Integer createTime) {
        this.createTime = createTime;
    }
}
