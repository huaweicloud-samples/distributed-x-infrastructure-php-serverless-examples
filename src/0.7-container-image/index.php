<?php
// 0.7 容器镜像 PHP 函数（FGS 自定义镜像）
function index($event, $context)
{
    return ['message' => 'Hello from container image', 'php' => PHP_VERSION];
}
