# PHP Serverless 参考资源

> 本页汇总在华为云 FunctionGraph（FGS）上使用 PHP 构建 Serverless 应用时的技术选型、
> 常见框架支持情况与官方文档入口，供开发者按需查阅。

---

## 一、运行时与框架

| 能力 | 说明 |
|---|---|
| PHP 原生运行时 | FGS 提供 PHP 7.4 / 8.0 运行时，handler 以「文件.函数」形式配置（如 `index.index`），无需自定义 bootstrap |
| 自定义运行时 | 通过 Dockerfile 打包任意 PHP 版本与扩展（示例见 `src/0.7-container-image/`） |
| 依赖层（Layers） | 公共依赖（Composer 包、PHP 扩展）打包为层，多函数共享，避免重复打包 |
| Bref 支持 | Bref 是 PHP Serverless 的代表性框架，可用其 HTTP API 层对接 FGS 的 HTTP 触发器 |

## 二、数据库与存储

| 场景 | 建议服务 |
|---|---|
| 关系数据库（需要连接池/连接数控制） | RDS for MySQL + 数据库代理 |
| 键值存储（items 语义） | DCS Redis |
| 对象存储（静态资源、用户上传） | OBS（含静态托管） |

## 三、HTTP 与静态资源

| 场景 | 建议服务 |
|---|---|
| HTTP 入口 / API 网关 | APIG（动态请求 → FGS 函数） |
| 静态站点与前端产物 | OBS 静态托管 + CDN |
| 异步任务与消息驱动 | DMS 消息队列 / FunctionGraph 异步调用 |

## 四、常见框架落地方案

| 框架 | 落地方式 |
|---|---|
| Laravel | 完整框架建议用 CCE 容器化部署（Nginx + PHP-FPM）；需要轻量入口时用 FGS PHP 运行时承接 HTTP 层 |
| Symfony | 同上，或用 FGS 自定义运行时承载 HTTP Kernel |
| WordPress / 传统 CMS | CCE 容器化部署，配合 RDS for MySQL 与 OBS 静态资源 |
| 队列消费者 | FGS 触发器 + DMS 消息队列，配合 DCS Redis 做状态与幂等控制 |

## 五、排查建议

| 症状 | 排查方向 |
|---|---|
| 函数返回 500 且日志为空 | 检查 handler 命名是否为「文件.函数」；同步调用时请求体位于 `event.body` |
| 依赖类找不到（Class not found） | Composer 依赖需随代码打包或放入依赖层；检查 `vendor/` 是否在打包范围内 |
| 数据库连接超时 | 确认安全组放通数据库代理端口；FGS 与数据库需同 VPC |
| 静态资源 404 | OBS 桶需开启静态网站托管，且桶与前端产物路径一致 |

---

## 相关文档

- [架构说明](architecture.md) — 整体服务组合与调用链
- [部署指南](deployment-guide.md) — 打包、上传与验证步骤
- [示例代码](../src) — 各场景的最小可运行示例
