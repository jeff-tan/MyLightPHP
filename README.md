## MyLightPHP
------------------
A light PHP framework 

### 依赖
------------------
- PHP >= 7.0
- Composer

### 安装
------------------
```
git clone 
cd MyLightPHP
composer install
```

### WEB服务器配置
--------------------
##### Nginx
```
    location / {
        try_files $uri $uri/ /index.php?query_string;
    }
```

### Todo
------------------
- Cookie
- Session
- Log
- Exception
- Auxiliary Functions




