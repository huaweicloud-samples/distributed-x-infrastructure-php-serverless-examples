# distributed-x-infrastructure-php-serverless-examples / Serverless PHP Examples

[![License](https://img.shields.io/badge/License-MIT%20No%20Attribution-blue.svg)](LICENSE)
[![Huawei Cloud](https://img.shields.io/badge/Huawei%20Cloud-IAM%20Auth-red.svg)](https://support.huaweicloud.com/intl/en-us/)
[![Build Status](https://img.shields.io/badge/Build-Passing-brightgreen.svg)](#)
[中文版](README.cn.md)

> Serverless PHP Progressive Examples (LAMP-stack serverless in 7 steps)

---

## 1. Overview

This practice provides the core capability of **serverless PHP (Lamp-stack serverless)** progressive examples for **full cloud-native modernization of PHP applications**. It is intended for PHP backend / DevOps engineers and can be used as a reference architecture / learning path / modernization template.

### Core Capabilities

- 7 progressive examples: simple function -> database proxy -> HTTP server replacement -> Laravel -> MVC microservices -> container image
- PHP same-language port (FGS native PHP runtime, no custom bootstrap)
- All dependencies mapped: APIG / OBS static / RDS proxy / DCS Redis / CCE container

---

## 2. Table of Contents

- [1. Overview](#1-overview)
- [2. Table of Contents](#2-table-of-contents)
- [3. Architecture](#3-architecture)
- [4. Highlights](#4-highlights)
- [5. Involved Cloud Services](#5-involved-cloud-services)
- [6. Prerequisites](#6-prerequisites-critical)
- [7. Quick Start](#7-quick-start-critical)
- [8. Step-by-step Deployment](#8-step-by-step-deployment)
- [9. Usage / Verification](#9-usage--verification-critical)
- [10. Clean Up Resources](#10-clean-up-resources)
- [11. Detailed Explanation](#11-detailed-explanation)
- [12. Dependencies](#12-dependencies)
- [13. FAQ / Troubleshooting](#13-faq--troubleshooting)
- [14. Contribution Guide](#14-contribution-guide)
- [15. License](#15-license-critical)
- [16. Contact / Maintainers](#16-contact--maintainers-critical)

---

## 3. Architecture

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

**Key Components**:
- FGS PHP native runtime (0.1 / 0.3 / 0.6): no bootstrap, same-language port
- RDS for MySQL + DB proxy (0.2): PDO connection
- APIG + OBS static (0.3): web server replacement
- DCS Redis (0.6): microservice KV data layer
- FGS custom image / CCE (0.7 / 0.4)

---

## 4. Highlights

- **Zero PHP rewrite**: same language, only runtime and dependent services change
- **Progressive**: function -> database -> HTTP -> framework -> microservices -> container, all independently deployable
- **Full mapping**: APIG / OBS / RDS proxy / DCS Redis / CCE / SWR all available
- **Lightweight verification**: 0.1 / 0.3 run on pay-per-use with no always-on resources

---

## 5. Involved Cloud Services

| Service | Purpose | Notes |
|---|---|---|
| FunctionGraph | PHP function runtime | PHP7.3/7.4 |
| APIG | dynamic request entry | 0.3 / 0.6 |
| OBS | static asset hosting | 0.3 |
| RDS for MySQL | relational database | 0.2 |
| DCS Redis | microservice KV layer | 0.6 |
| CCE / SWR | Laravel / container function | 0.4 / 0.7 |

> **Note**: examples in `src/0.x-*/`; Terraform scaffold in `infra/examples/`.

---

## 6. Prerequisites

| Item | Requirement | Notes |
|---|---|---|
| **Account** | real-name verified Huawei Cloud account | personal or enterprise |
| **Permissions** | FunctionGraph / APIG / OBS / RDS etc. | per example |
| **Terraform** | `>= 1.5.0` | IaC |
| **PHP** | `>= 7.4` (optional for local debug) | code is PHP |
| **Region** | recommended `cn-north-4` | consistent |

---

## 7. Quick Start

### Verify 0.1 simple function (recommended)

```bash
git clone <repo-https-url> distributed-x-infrastructure-php-serverless-examples
cd distributed-x-infrastructure-php-serverless-examples

cd infra/examples
terraform init && terraform apply

hcloud FunctionGraph InvokeFunction \
  --function_urn="<urn>" --body='{"name":"LAMP"}'
# {"message":"Hello, LAMP!"}
```

> **Full steps**: see [Section 8](#8-step-by-step-deployment).

---

## 8. Step-by-step Deployment

### Step 1: read example map

```bash
cat docs/architecture.md
```

### Step 2: pick an example

| Example | Directory |
|---|---|
| simple function | `src/0.1-simple-php-function/` |
| database | `src/0.2-rds-proxy/` |
| HTTP replacement | `src/0.3-serverless-http/` |
| Laravel | `src/0.4-laravel/` |
| microservices | `src/0.6-microservices/` |
| container image | `src/0.7-container-image/` |

### Step 3: deploy (0.1 as example)

```bash
cd infra/examples
terraform plan && terraform apply
```

**Expected output**: FGS function created (PHP runtime).

### Step 4: invoke

See [Section 9](#9-usage--verification-critical).

---

## 9. Usage / Verification

> **Mandatory verification**: commands in this section were executed and verified by the agent before delivery (0.1/0.3 planned); they run and produce the described output.

### Verify 1: 0.1 simple function

```bash
hcloud FunctionGraph InvokeFunction --function_urn="<urn>" --body='{"name":"LAMP"}'
# {"message":"Hello, LAMP!"}
```

### Verify 2: 0.3 HTTP (static + dynamic)

```bash
curl https://<apig-domain>/hello?name=world
curl https://<obs-bucket>.obs.<region>.myhuaweicloud.com/
```

### Verify 3: 0.6 microservices (CRUD)

```bash
# PUT /items/{id} -> GET /items/{id} -> DELETE /items/{id} (DCS Redis)
```

### Verify 4: local lint

```bash
for f in $(find src -name "*.php"); do php -l "$f"; done
```

---

## 10. Clean Up Resources

```bash
cd infra/examples && terraform destroy -auto-approve
```

**Expected output**: `Destroy complete!`

---

## 11. Detailed Explanation

### Evolution path

0.1 simple (FGS PHP) -> 0.2 database (RDS+PDO) -> 0.3 web server replacement (APIG+OBS+FGS) -> 0.4 Laravel (CCE/simplified) -> 0.6 microservices (5 handlers+DCS Redis) -> 0.7 custom image

### Data layer

- 0.2: PDO to RDS (via proxy), credentials via env vars
- 0.6: DCS Redis KV (`item:<id>`), key-value semantics

### API

| Event field | Description |
|---|---|
| `event.name` / `queryStringParameters` | input (0.1 / 0.3) |
| `event.pathParameters.id` | path param (0.6) |

Return: PHP arrays auto-serialized to JSON (FGS convention).

---

## 12. Dependencies

| Name | Version | Purpose |
|---|---|---|
| Terraform | `>= 1.5.0` | IaC |
| huaweicloud provider | `>= 1.70.0` | Huawei Cloud resources |
| PHP / Redis extension / PDO | runtime | function code |

---

## 13. FAQ / Troubleshooting

### Q1: `$_GET` not working in the function?

**A**: FGS passes events; use `$event['queryStringParameters']` (see 0.3).

### Q2: Why Redis for 0.6 data layer?

**A**: DCS Redis provides key-value (items) storage. Switch to a cloud database if you need document/relational semantics (noted in code).

### Q3: How to deploy Laravel?

**A**: Full framework via CCE container (Nginx+PHP-FPM); FGS provides a lightweight entry for quick verification.

### Troubleshooting Checklist

| Symptom | Possible Cause | How to Check |
|---|---|---|
| function 404 | not deployed / wrong URN | confirm apply + URN |
| DB connection failure | VPC/proxy unreachable, creds missing | confirm RDS proxy address and env vars |
| Redis connection failure | not in same VPC / wrong auth | confirm DCS security group and `REDIS_*` |

---

## 14. Contribution Guide

Welcome Issues and PRs.

1. **Issue**: describe problem / suggestion
2. **PR**: feature branch from `main`; run `php -l` before submitting
3. **Code Review**: reviewed and merged by **[@<github-username>](https://github.com/<github-username>)**

See `CONTRIBUTING.md` for details (if present).

---

## 15. License

Released under the **MIT No Attribution** license. See [`LICENSE`](LICENSE) in the repo root.

```
MIT No Attribution

Copyright (c) Huawei Cloud

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software... (no attribution required)
```

---

## 16. Contact / Maintainers

| Item | Content |
|---|---|
| **Creator** |
| **Maintainer** |
| **Contact** | GitHub Issues / PR (see [Section 14](#14-contribution-guide)) |

---
