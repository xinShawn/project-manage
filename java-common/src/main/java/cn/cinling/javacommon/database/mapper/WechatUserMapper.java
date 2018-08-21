package cn.cinling.javacommon.database.mapper;

import cn.cinling.javacommon.database.entity.WechatUserEntity;
import org.apache.ibatis.annotations.Mapper;

@Mapper
public interface WechatUserMapper {
    WechatUserEntity SelectByOpenid(String openId);
    WechatUserEntity SelectById(Integer id);
    void UpdateOne(WechatUserEntity wechatUserEntity);
    int InsertOne(WechatUserEntity wechatUserEntity);
}
