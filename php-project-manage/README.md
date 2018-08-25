
# yii 后台

## 初始化

### 1 初始化 php-project-manage (yii) 项目

    #进入项目路径
    cd ./php-project-manage
    #安装 yii 的依赖库
    composer install 或 composer update
    
### 2 初始化环境配置

    执行命令。(init 脚本 命令非 yii 自带）
    php init
    
### 3 修改数据库配置

>文件路径：`php-project-manage/config/db-local.php`

>默认：使用mysql本地默认端口（3306）

    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=数据库名字',
    'username' => '数据库账号',
    'password' => '数据库密码',
    'charset' => 'utf8mb4',

### 4 升级更新数据库

    执行命令
    yii migrate/up 或 php yii migrate/up
    
#
#

## yii 框架相关命令

`提示：yii 是一个php脚本，'yii' 命令等价于 'php yii' 命令`

### 启动服务（免信息服务器）

    ./yii serve --port=8888
    
### 数据库命令

>创建数据库更新文件

    ./yii migrate/create [文件名]
    
>更新数据库

    ./yii migrate/up
    
>数据库版本回滚一个版本（前提：最近一次更新的文件支持回滚）

    ./yii migrate/down
    
###执行脚本控制器

    ./yii site/index        #等价于执行方法 /commands/SiteController::actionIndex()