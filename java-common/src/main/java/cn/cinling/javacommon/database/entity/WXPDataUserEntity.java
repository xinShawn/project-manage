package cn.cinling.javacommon.database.entity;

/**
 * CREATE TABLE `wxp_data_user` (
 *   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 *   `wechat_user_id` int(10) unsigned NOT NULL COMMENT '微信用户id',
 *   `auth_code` varbinary(32) NOT NULL DEFAULT '' COMMENT '登录授权码',
 *   `auth_code_dead_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录授权码到期时间',
 *   `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
 *   `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
 *   PRIMARY KEY (`id`),
 *   UNIQUE KEY `auth_code` (`auth_code`)
 * ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
 */
public class WXPDataUserEntity {
    private Integer id;
    private Integer wechatUserId;
    private String authCode;
    private Integer authCodeDeadTime;
    private Integer updateTime;
    private Integer createTime;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getWechatUserId() {
        return wechatUserId;
    }

    public void setWechatUserId(Integer wechatUserId) {
        this.wechatUserId = wechatUserId;
    }

    public String getAuthCode() {
        return authCode;
    }

    public void setAuthCode(String authCode) {
        this.authCode = authCode;
    }

    public Integer getAuthCodeDeadTime() {
        return authCodeDeadTime;
    }

    public void setAuthCodeDeadTime(Integer authCodeDeadTime) {
        this.authCodeDeadTime = authCodeDeadTime;
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
