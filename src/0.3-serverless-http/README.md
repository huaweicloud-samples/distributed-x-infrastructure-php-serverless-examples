# 0.3 替换 HTTP Web 服务器

**示例**：0.3（Bref FPM 自定义运行时 + API 网关 + 对象存储静态托管 + CDN 加速）
**华为云形态**：APIG + FGS PHP + OBS 静态托管（OBS 已自带 CDN 入口，按需叠加加速）

- 动态请求：APIG → FGS PHP（事件结构适配：`queryStringParameters`）
- 静态资源：OBS 静态桶（index.html/assets）
- 差异：`$_GET` → `$event['queryStringParameters']`；Bref FPM → 原生 PHP handler
