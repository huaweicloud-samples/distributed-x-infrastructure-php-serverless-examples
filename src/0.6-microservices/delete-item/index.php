<?php
// 0.6 handler（FGS PHP）：REDIS_HOST 存在时用 DCS Redis，否则使用内存存储演示
function unwrap($event) {
    if (is_object($event) || is_array($event)) {
        $body = is_object($event) ? ($event->body ?? null) : ($event['body'] ?? null);
        if ($body !== null) {
            if (is_string($body)) { $d = json_decode($body, true); if (is_array($d)) { return $d; } }
            else { return $body; }
        }
    }
    return $event;
}
function id_from($event) {
    if (is_object($event) && isset($event->pathParameters) && isset($event->pathParameters->id)) return $event->pathParameters->id;
    if (is_array($event) && isset($event['pathParameters']['id'])) return $event['pathParameters']['id'];
    return 'demo';
}
function body_parse($event) {
    $b = null;
    if (is_object($event) && isset($event->body)) $b = $event->body;
    elseif (is_array($event) && isset($event['body'])) $b = $event['body'];
    if (is_string($b)) { $b = json_decode($b, true); }
    return is_array($b) ? $b : [];
}
function store() {
    $h = getenv('REDIS_HOST');
    if (!$h) { return null; }
    $r = new Redis();
    $a = getenv('REDIS_AUTH') ?: '';
    if ($a) { $r->auth($a); }
    if ($r->connect($h, 6379, 3)) { $r->select(0); return $r; }
    return null;
}
$GLOBALS['MEM'] = [];
function kv_get($k) { return $GLOBALS['MEM'][$k] ?? null; }
function kv_set($k, $v) { $GLOBALS['MEM'][$k] = $v; }
function kv_del($k) { unset($GLOBALS['MEM'][$k]); }
function kv_all() { return $GLOBALS['MEM']; }

function index($event, $context)
{
    $event = unwrap($event);
    $id = id_from($event);
    $rc = store();
    if ($rc) { $rc->del('item:'.$id); } else { kv_del('item:'.$id); }
    $out = ['id'=>$id, 'deleted'=>true, 'op'=>'delete', 'store'=>($rc ? 'redis' : 'memory')];
    return ['statusCode' => 200, 'headers' => ['Content-Type' => 'application/json'], 'body' => json_encode($out)];
}
