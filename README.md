#项目管理系统

## 项目所需环境
    nodejs  8.11 或以上
    php     5.4 或以上(推荐 使用php7)
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

```
/                           项目根路径
    /nodejs-webpack         nodejs vue-template 源码目录
        /build              构建配置
        /config             配置
        /src                源代码
            /assets         静态资源
            /components     组件
            /router         路由配置
            /views          单个页面
        /static             原静态资源生成后存放的目录（已改到[php-project-manage] web目录下）
        /test               
    /php-project-manage     php yii 框架跟路径
        /assets             资源路径（这个可能用不到）
        /commands           命令行控制器。可以在命令行调用框架内的方法
        /config             配置文件路径
        /controllers        web 控制器
        /mail               
        /migrations         数据库版本管理文件
        /models             数据模型文件
            /db             每个数据表对应的模型
        /runtime            项目运行时产生的文件
        /tests              测试文件路径
        /vagrant            信息服务器配置参考
        /views              网页模板（html模板）
            /layouts        主模板（为模板提供父级模板） -- 日后将减少这一层的使用
            /*              每个控制器的模板。如 /controllers/SiteController 对应 site 文件夹
        /web                web 开放目录，一般存放 css、js、图片 等静态资源
        /widgets
```
#
#    

## 更好的开发环境配置： Nginx + Nodejs + php 热更新配置

> 这个方法不能很好地解决，app.js 加载缓慢，且无法实时更新

    修改代码后，可立即呈现在页面中。无需重新 build
    
    原理：
        php原本就支持修改后立即更新。但是 nodejs需要重新编译生成文件，访问首页才会更新。
        现在，只需要修改nginx文件，使访问非php文件时的请求转发到 nodejs (npm run dev) 服务上即可
        
        
配置文件参考：
```
upstream project_manage_server {
    server localhost:8888;
    keepalive 64;
}

server {
    charset utf-8;
    client_max_body_size 128M;
    sendfile off;

    listen 80;

    server_name dev.project-manage.local;
    root        D:\workspace\project-manage\php-project-manage\web;
    index       index.php index.html;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;  
    }

    # 静态资源转发 到 npm run dev 的端口下
    location ~ \.(html|js|css|jpg|png|json)$ {
        proxy_pass        http://localhost:8888;
        proxy_set_header  X-Real-IP $remote_addr;
        proxy_set_header  X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header  Host localhost;
    }

    location ^~ /websocket {
        proxy_pass http://localhost:8888;

        proxy_redirect   off;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header Host localhost;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;

        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }

    # 禁止访问以下文件夹 或 后缀名
    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
```
    
## 相关文档

>yii 文档： https://www.yiiframework.com/doc/api/2.0

>webpack 文档： https://www.webpackjs.com/concepts/

>vue.js 文档： https://cn.vuejs.org/v2/guide/

>vue单页面模板相关文档：https://github.com/vuejs-templates/webpack