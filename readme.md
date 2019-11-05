# eTake 交大外卖项目
外卖项目后端程序   

## Changelog
See [CHANGELOG.md]

## 部署
### 环境要求
<https://laravel.com/docs/6.x>   

    PHP >= 7.2.0   
    BCMath PHP Extension   
    Ctype PHP Extension   
    JSON PHP Extension   
    Mbstring PHP Extension   
    OpenSSL PHP Extension   
    PDO PHP Extension   
    Tokenizer PHP Extension   
    XML PHP Extension  
    Redis PHP Extension
     
### 部署流程
1.复制 `.env.example` 到 `.env`   
2.修改 `.env` 中数据库、API、微信登录的相关配置   
3.执行 `php artisan migrate`  
4.执行 `php artisan jwt:secret`  
4.执行 `php artisan storage:link`  

## CONTRIBUTORS
* [f(x,z)=xzx](https://github.com/XuZhixuan)   
* [jmy0214](https://github.com/jmy0214)   

## LICENSE
[MIT License](https://opensource.org/licenses/MIT)  

    Copyright (c) 2019 eeyes.net

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.
