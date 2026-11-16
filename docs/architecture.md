# 架构说明

`distributed-x-infrastructure-php-serverless-examples` 提供 **Serverless LAMP 渐进示例**：传统 PHP LAMP 栈无服务器化的 7 个演进步骤，全部移植到华为云（FGS PHP 原生运行时 + APIG + OBS + RDS 代理 + DCS Redis + 容器镜像）。

## 演进路线

```
                            ┌────────────┐
                            │    LAMP    │
                            └──────┬─────┘
                                   │ 渐进演进
                                   ▼
┌────────────────────────────────────────────────────────────────────┐
│                    Serverless PHP LAMP 渐进示例                    │
│            FGS PHP / APIG / OBS / RDS / DCS Redis / CCE            │
└────┬───────────┬───────────┬───────────┬───────────┬───────────┬───┘
     │           │           │           │           │           │
     ▼           ▼           ▼           ▼           ▼           ▼
┌────────┐  ┌────────┐  ┌────────┐  ┌────────┐  ┌────────┐  ┌────────┐
│  0.1   │  │  0.2   │  │  0.3   │  │  0.4   │  │  0.6   │  │  0.7   │
│ SIMPLE │  │   DB   │  │  HTTP  │  │LARAVEL │  │  MVC   │  │ IMAGE  │
└────┬───┘  └────┬───┘  └────┬───┘  └────┬───┘  └────┬───┘  └────┬───┘
     │           │           │           │           │           │
     └───────────┴───────────┴─────┬─────┴───────────┴───────────┘
                                   ▼
┌────────────────────────────────────────────────────────────────────┐
│                统一底座：原生 PHP 运行时 + 托管服务                │
│            从单函数到数据库代理、静态托管、容器与微服务            │
└────────────────────────────────────────────────────────────────────┘
```

## 核心组件

| 目录 | 说明 |
|---|---|
| `src/0.1-simple-php-function/` | 原生 FGS PHP 函数（免 bootstrap） |
| `src/0.2-rds-proxy/` | RDS for MySQL + 数据库代理 + PDO |
| `src/0.3-serverless-http/` | APIG + OBS 静态 + FGS PHP |
| `src/0.4-laravel/` | Laravel → CCE 容器（推荐） |
| `src/0.6-microservices/` | 5 个 handler（DCS Redis KV） |
| `src/0.7-container-image/` | FGS 容器镜像 PHP |
| `infra/examples/` | 各示例 Terraform 脚手架 |

## 设计说明

- PHP 同语言直转（FGS 原生 PHP 7.4），自定义运行时 bootstrap/Bref 由原生运行时等效替代
- 数据库认证令牌（签名式 AuthToken）→ PDO / Redis / 华为云
- 0.4 Laravel 完整框架建议 CCE 容器（FGS 提供轻量验证入口）
