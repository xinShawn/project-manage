package cn.cinling.javacommon.database.mapper;

import cn.cinling.javacommon.database.entity.WXPDataUserEntity;
import org.apache.ibatis.annotations.Mapper;

@Mapper
public interface WXPDataUserMapper {
    void InsertOne(WXPDataUserEntity wxpDataUserEntity);
    WXPDataUserEntity SelectById(Integer id);
    WXPDataUserEntity SelectByWechatUserId(Integer wechatUserId);
    WXPDataUserEntity SelectByAuthCode(String authCode);
    int GetLastId();
    void UpdateOne(WXPDataUserEntity wxpDataUserEntity);
}
