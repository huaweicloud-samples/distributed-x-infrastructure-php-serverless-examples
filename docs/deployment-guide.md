# 使用指导书

## 1. 前置条件

- 华为云账号 + FGS/APIG/OBS/RDS 权限；Terraform ≥ 1.5 + huaweicloud provider

## 2. 示例地图

| 示例 | 华为云资源 | 验证 |
|---|---|---|
| 0.1 简单函数 | FGS PHP | hcloud InvokeFunction → Hello |
| 0.2 RDS 代理 | RDS MySQL + 代理 + FGS(VPC) | 调用 → DB 问候语 |
| 0.3 HTTP 替换 | APIG + FGS + OBS 静态 | 访问 APIG 域名 + 静态站 |
| 0.4 Laravel | CCE 或 FGS 简化 | 访问应用 |
| 0.6 微服务 | APIG + FGS×5 + DCS Redis | CRUD 断言 |
| 0.7 容器镜像 | SWR + FGS 自定义镜像 | 调用函数 |

## 3. 快速验证（0.1）

```bash
export HW_ACCESS_KEY=... HW_SECRET_KEY=...
cd infra
terraform init && terraform apply   # 需先补全 provider 与函数打包
# 上传代码：将 src/0.1-simple-php-function 打包为 php-simple.zip
# 调用
hcloud FunctionGraph InvokeFunction --function_urn="<urn>" --body='{"name":"LAMP"}'
# 预期：{"message":"Hello, LAMP!"}
```

## 4. 0.6 微服务数据层

DCS Redis（小规格）替代 NoSQL 文档存储：`REDIS_HOST/PORT/AUTH` 经 FGS 环境变量传入；KV 模式 `item:<id>`。

## 5. 清理

```bash
terraform destroy -auto-approve
# 静态桶 / DCS 实例若由 IaC 管理则一并释放；手工资源在控制台解绑
```
