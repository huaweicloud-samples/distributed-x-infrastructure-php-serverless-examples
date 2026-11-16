<?php
// 0.2 关系数据库（FGS + RDS for MySQL + 数据库代理）
// 服务组合：RDS for MySQL + 数据库代理 + FGS PHP
// 说明：FGS 内用 PDO（账号密码，经代理连接）
function index($event, $context)
{
    $host = getenv('DB_HOST') ?: '127.0.0.1';   // 数据库代理地址
    $port = getenv('DB_PORT') ?: '3306';
    $db   = getenv('DB_NAME') ?: 'app';
    $user = getenv('DB_USER');                  // 通过 FGS 环境变量注入
    $pass = getenv('DB_PASS');
    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $name = $pdo->query('SELECT name FROM greetings LIMIT 1')->fetchColumn();
        return ['greeting' => "Hello from DB: {$name}", 'via' => 'rds-proxy'];
    } catch (Throwable $e) {
        return ['error' => 'DB connection failed: ' . $e->getMessage(), 'code' => 500];
    }
}
