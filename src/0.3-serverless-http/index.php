<?php
// 0.3 替换传统 HTTP Web 服务器（FGS + APIG + OBS 静态）
// 服务组合：APIG（动态请求→FGS PHP）+ OBS 静态托管（静态资源）
function index($event, $context)
{
    // APIG 事件：query 参数位于 event['queryStringParameters']
    $qs = isset($event['queryStringParameters']) && is_array($event['queryStringParameters'])
        ? $event['queryStringParameters'] : [];
    $name = isset($qs['name']) ? $qs['name'] : 'world';
    // 返回 APIG 响应结构
    return [
        'statusCode' => 200,
        'headers'    => ['Content-Type' => 'text/html; charset=utf-8'],
        'body'       => "<html><body><h1>Hello, " . htmlspecialchars($name) . "!</h1>" .
                        "<p>静态资源由 OBS 静态桶托管</p></body></html>",
    ];
}
