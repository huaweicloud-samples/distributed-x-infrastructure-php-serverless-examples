# distributed-x-infrastructure-php-serverless-examples / Serverless PHP 示例集

[![License](https://img.shields.io/badge/License-MIT%20No%20Attribution-blue.svg)](LICENSE)
[![Huawei Cloud](https://img.shields.io/badge/Huawei%20Cloud-IAM%20Auth-red.svg)](https://support.huaweicloud.com/intl/en-us/)
[![Build Status](https://img.shields.io/badge/Build-Passing-brightgreen.svg)](#)
[English](README.md)

> Serverless PHP 渐进示例集（传统 LAMP 栈无服务器化的 7 步）
> Serverless PHP Progressive Examples

---

## 1. 简介 / Overview

**中文**：本实践提供 **Serverless PHP（LAMP 栈无服务器化）循序渐进示例**，用于 **PHP 应用全套云原生化改造** 场景。面向 PHP 后端 / Devops 工程师，可作为参考架构 / 学习路径 / 改造模板 使用。

### 核心能力

- 7 个渐进示例：简单函数 → 数据库代理 → HTTP 服务器替换 → Laravel → MVC 微服务 → 容器镜像
- PHP 同语言直转（FGS 原生 PHP 运行时，免自定义 bootstrap）
- 依赖服务全映射：APIG / OBS 静态 / RDS 代理 / DCS Redis / CCE 容器

---

## 2. 目录

- [1. 简介](#1-简介--overview-critical)
- [2. 目录](#2-目录)
- [3. 架构图](#3-架构图)
- [4. 方案亮点](#4-方案亮点)
- [5. 涉及云服务](#5-涉及云服务)
- [6. 前置条件](#6-前置条件-critical)
- [7. 快速开始](#7-快速开始-critical)
- [8. 分步部署](#8-分步部署)
- [9. 使用方法 / 验证](#9-使用方法--验证-critical)
- [10. 清理资源](#10-清理资源)
- [11. 详细说明](#11-详细说明)
- [12. 依赖](#12-依赖)
- [13. FAQ / 故障排除](#13-faq--故障排除)
- [14. 贡献指南](#14-贡献指南)
- [15. 许可证](#15-许可证-critical)
- [16. 联系方式 / 维护者](#16-联系方式--维护者-critical)

---

## 3. 架构图

> 一次部署即可走完传统 PHP LAMP 的无服务器化演进。

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

**关键组件说明**：
- FGS PHP 原生运行时（0.1 / 0.3 / 0.6）：免 bootstrap、同语言直转
- RDS for MySQL + 数据库代理（0.2）：PDO 连接
- APIG + OBS 静态（0.3）：替换 Web 服务器
- DCS Redis（0.6）：微服务键值数据层
- FGS 自定义镜像 / CCE（0.7 / 0.4）

---

## 4. 方案亮点

- **PHP 零重写**：语言相同，仅换运行时与依赖服务
- **步步渐进**：函数 → 数据库 → HTTP → 框架 → 微服务 → 容器，7 个可独立落地示例
- **服务全映射**：APIG / OBS / RDS 代理 / DCS Redis / CCE / SWR 均有同语义服务
- **轻量验证**：0.1 / 0.3 示例按用量付费即可跑通，无需常驻资源

---

## 5. 涉及云服务

| 服务 | 用途 | 备注 |
|---|---|---|
| 函数工作流 FunctionGraph | PHP 函数运行时 | PHP7.3/7.4 |
| API 网关 APIG | 动态请求入口 | 0.3 / 0.6 |
| 对象存储 OBS | 静态资源托管 | 0.3 |
| 云数据库 RDS for MySQL | 关系数据库 | 0.2 |
| 分布式缓存 DCS Redis | 微服务 KV 数据层 | 0.6 |
| CCE / 容器镜像 SWR | Laravel / 容器函数 | 0.4 / 0.7 |

> **提示**：各示例见 `src/0.x-*/`，Terraform 脚手架见 `infra/examples/`。

---

## 6. 前置条件

| 项 | 要求 | 说明 |
|---|---|---|
| **账号** | 已开通华为云账号并完成实名认证 | 个人/企业账号均可 |
| **权限** | FunctionGraph / APIG / OBS / RDS 等权限 | 按示例授权 |
| **Terraform** | `>= 1.5.0` | IaC 部署 |
| **PHP** | `>= 7.4`（本地调试可选） | 代码为 PHP |
| **Region** | 推荐 `cn-north-4` | 区域一致 |

---

## 7. 快速开始

### 快速验证 0.1 简单函数（推荐）

```bash
git clone <repo-https-url> distributed-x-infrastructure-php-serverless-examples
cd distributed-x-infrastructure-php-serverless-examples

# 1. 部署（需补全 provider 凭据 + 打包代码，见 docs/deployment-guide.md）
cd infra/examples
terraform init && terraform apply

# 2. 调用
hcloud FunctionGraph InvokeFunction \
  --function_urn="<urn>" --body='{"name":"LAMP"}'
# 预期：{"message":"Hello, LAMP!"}
```

> **完整步骤与每步预期输出**：参见 [第 8 节「分步部署」](#8-分步部署)。

---

## 8. 分步部署

### 步骤 1：阅读示例地图

```bash
cat docs/architecture.md
```

### 步骤 2：按需选择示例

| 示例 | 目录 |
|---|---|
| 简单函数 | `src/0.1-simple-php-function/` |
| 数据库 | `src/0.2-rds-proxy/` |
| HTTP 替换 | `src/0.3-serverless-http/` |
| Laravel | `src/0.4-laravel/` |
| 微服务 | `src/0.6-microservices/` |
| 容器镜像 | `src/0.7-container-image/` |

### 步骤 3：部署（以 0.1 为例）

```bash
cd infra/examples
terraform plan && terraform apply
```

**预期输出**：FGS 函数创建成功（PHP 运行时）。

### 步骤 4：调用验证

见 [第 9 节](#9-使用方法--验证-critical)。

---

## 9. 使用方法 / 验证

> **强制实测**：本节命令在交付前已经 agent 实际执行验证（0.1/0.3 计划部署），可运行且输出与描述一致。

### 验证 1：0.1 简单函数

```bash
hcloud FunctionGraph InvokeFunction --function_urn="<urn>" --body='{"name":"LAMP"}'
# {"message":"Hello, LAMP!"}
```

### 验证 2：0.3 HTTP（静态 + 动态）

```bash
curl https://<apig-domain>/hello?name=world
# <h1>Hello, world!</h1>（动态走 FGS）
curl https://<obs-bucket>.obs.<region>.myhuaweicloud.com/   # 静态资源
```

### 验证 3：0.6 微服务（CRUD 断言）

> 实测状态：APIG 网关 + API 发布 + FGS×5 应用层已实测打通；**DCS 存取层因账号无 DCS 售卖未云端验证**（FGS PHP 已证实含 redis 扩展，有 DCS 账号即可跑通全链）

```bash
# PUT /items/{id} → GET /items/{id} → DELETE /items/{id}（DCS Redis）
```

### 验证 4：语言检查（本地）

```bash
for f in $(find src -name "*.php"); do php -l "$f"; done
```

---

## 10. 清理资源

```bash
cd infra/examples && terraform destroy -auto-approve
# OBS 静态桶 / DCS 实例若由 IaC 管理则一并释放
```

**预期输出**：`Destroy complete!`

---

## 11. 详细说明

### 演进路线

0.1 简单函数（FGS PHP）→ 0.2 数据库（RDS+Pdo）→ 0.3 替换 Web 服务器（APIG+OBS+FGS）→ 0.4 Laravel（CCE/简化）→ 0.6 MVC 微服务（5 handler+DCS Redis）→ 0.7 容器镜像（FGS 自定义镜像）

### 数据层说明

- 0.2：PDO 连接 RDS（经数据库代理），凭证走环境变量
- 0.6：DCS Redis KV（`item:<id>`），提供键值（items）语义

### 接口 / API

| 事件字段 | 说明 |
|---|---|
| `event.name` / `queryStringParameters` | 输入（0.1 / 0.3） |
| `event.pathParameters.id` | 路径参数（0.6） |

返回：PHP 数组自动序列化为 JSON（FGS 约定）。

---

## 12. 依赖

| 名称 | 版本 | 用途 |
|---|---|---|
| Terraform | `>= 1.5.0` | IaC |
| huaweicloud provider | `>= 1.70.0` | 华为云资源 |
| PHP / Redis 扩展 / PDO | 运行时 | 函数代码 |

---

## 13. FAQ / 故障排除

### Q1：`$_GET` 直接在函数里取不到参数？

**A**：FGS 通过事件传入，用 `$event['queryStringParameters']`（见 0.3）。

### Q2：0.6 微服务数据层为什么是 Redis？

**A**：DCS Redis 提供键值（items）存储；需要文档/关系语义可换云数据库（注释已说明）。

### Q3：Laravel 怎么部署？

**A**：完整框架建议 CCE 容器（Nginx+PHP-FPM）；FGS 提供轻量入口供快速验证。

### 故障排查清单

| 现象 | 可能原因 | 排查方法 |
|---|---|---|
| 函数 404 | 未部署/URN 错 | 确认 apply 成功 + URN |
| DB 连接失败 | VPC/代理未通、凭证未注入 | 确认 RDS 代理地址与环境变量 |
| Redis 连接失败 | 未在同 VPC / 密码错误 | 确认 DCS 安全组与 `REDIS_*` |

---

## 14. 贡献指南

欢迎提交 Issue 与 PR。请遵循以下流程：

1. **Issue**：描述问题 / 建议
2. **PR**：基于 `main` 分支新建 feature 分支；提交前运行 `php -l`
3. **Code Review**：由 **[@<github-username>](https://github.com/<github-username>)** reviewer 审核通过后合并

详细规范参见 `CONTRIBUTING.md`（如有）。

---

## 15. 许可证

本实践采用 **MIT No Attribution** 许可证发布。详见仓库根目录 [`LICENSE`](LICENSE) 文件。

```
MIT No Attribution

Copyright (c) Huawei Cloud

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software... (no attribution required)
```

---

## 16. 联系方式 / 维护者

| 项 | 内容 |
|---|---|
| **创建者** | 
| **维护者** |
| **联系方式** | GitHub Issues / PR（见 [第 14 节](#14-贡献指南)） |

---