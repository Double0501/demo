server{

    listen 80;
    server_name demo.com;

    # 程序的安装路径
    root /var/www/demo/php;

    location / {
        index index.php;
        try_files $uri @rewriteapp;
    }

    location @rewriteapp {
        rewrite ^(.*)$ /index.php/$1 last;
    }

    location ~ ^/(index)\.php(/|$) {
        # [改] 请根据实际php-fpm运行的方式修改
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
        fastcgi_param  HTTPS              off;
    }
}
