#项目管理系统

## 项目所需环境
    nodejs  8.11 或以上
    php     7.1.13 或以上(composer安装所需最低版本)
    mysql   5.6 或以上
    nginx|apache    (信息服务器)
    composer        (php包管理工具，类似于 nodejs 的 npm)
    
## 软件安装部分说明

### Composer 安装

#### 1 下载 composer 。 按顺序执行下面三条命令
>参考链接： `https://www.phpcomposer.com/`

>如果没有安装 git 命令的，需要先安装 git 命令

    php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    
执行后，本地会有一个 `composer.phar` 文件

#### 2 把 `composer.phar` 配置成全局命令 `composer` 。步骤如下：

##### windows

2.1 把 composer.phar 移动到和 php.exe 同级的目录（即：php可执行文件的路径）
        
2.2 编写脚本 composer.bat
>@php "%~dp0composer.phar" %*

#
#

## 项目初始化

## 一、初始化PHP项目

>请查看 php-project-manage/README.md 文件
    
## 二、初始化 webpack 项目

>请查看 nodejs-webpack/README.md 文件

#
#    

## 目录结构

> 带 * 的是重要的目录

```
/                           项目根路径
    /nodejs-webpack         nodejs vue-template 源码目录
        /build              构建配置
        /config             配置
        /src                源代码
            /assets         静态资源
            /components     组件。一般是可重复使用的控件
            /models         模型（TypeScript）。对一些数据格式的封装
            /router         * 路由配置
            /store          * vuex 代码存放路径
            /utils          工具类（TypeScript）的封装
            /views          * 单个页面
        /static             原静态资源生成后存放的目录（已改到 php-project-manage/web目录下）
        /test               
    /php-project-manage     php yii 框架跟路径
        /assets             资源路径（这个可能用不到）
        /commands           命令行控制器。可以在命令行调用框架内的方法
        /config             配置文件路径
        /controllers        * web 控制器
        /exceptions         异常类
        /mail               邮件模板
        /managers           * 管理器（业务层），主要的逻辑处理代码放在这里
        /messages           多语言包
        /migrations         数据库版本管理文件
        /models             * 数据模型。对数据结构的封装
            /cache          缓存 数据模型
            /cmd            命令行 数据模型
            /db             数据表 数据模型
            /form           表单 数据模型
        /runtime            项目运行时产生的文件
        /tests              测试文件路径
        /utils              工具类存放处，如 文件工具，时间工具等
        /vagrant            信息服务器配置参考
        /views              网页模板（html模板）
            /layouts        主模板（为模板提供父级模板） -- 日后将减少这一层的使用
            /*              每个控制器的模板。如 /controllers/SiteController 对应 site 文件夹
        /web                web 开放目录，一般存放 css、js、图片 等静态资源
        /widgets
```
#
```
    
## 相关文档

>yii 文档： https://www.yiiframework.com/doc/api/2.0

>webpack 文档： https://www.webpackjs.com/concepts/

>vue.js 文档： https://cn.vuejs.org/v2/guide/

>vue单页面模板相关文档：https://github.com/vuejs-templates/webpack