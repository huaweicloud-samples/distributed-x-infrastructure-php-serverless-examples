# FGS 自定义容器镜像（对应源 0.7 docker 容器 Lambda）
FROM php:8.1-cli
COPY index.php /app/index.php
WORKDIR /app
# FGS 函数运行时：容器镜像需实现函数运行时协议（PHP 监听入口），生产按 FGS 容器规范补齐
CMD ["php", "index.php"]
