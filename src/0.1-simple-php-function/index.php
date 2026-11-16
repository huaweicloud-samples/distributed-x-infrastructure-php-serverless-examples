<?php
// 0.1 简单 PHP 函数（FGS 原生 PHP 运行时）
// 运行时：华为云 FGS 原生 PHP 7.4 运行时
// 说明：handler 配置为 index.index（文件.函数）；
//       FGS 同步调用将请求体包装在 event.body（可能为字符串/stdClass/数组），代码做多层兼容
function index($event, $context)
{
    $name = 'world';
    $raw = $event;
    // 解包 event.body
    if (is_object($raw) && isset($raw->body)) { $raw = $raw->body; }
    elseif (is_array($raw) && isset($raw['body'])) { $raw = $raw['body']; }
    if (is_string($raw)) { $d = json_decode($raw, true); if (is_array($d)) { $raw = $d; } }
    if (is_array($raw) && isset($raw['name'])) {
        $name = $raw['name'];
    } elseif (is_object($raw) && isset($raw->name)) {
        $name = $raw->name;
    }
    return ['message' => "Hello, {$name}!", 'runtime' => 'hcloud-fgs-php'];
}
