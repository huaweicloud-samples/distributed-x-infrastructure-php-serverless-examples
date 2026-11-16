# 0.2 关系数据库（RDS 代理）

**源示例**：0.2-Relational-Database-RDS-Proxy-Example（Aurora MySQL + RDS Proxy + IAM 认证令牌）
**华为云形态**：RDS for MySQL + 数据库代理 + FGS PHP（PDO）

- 连接：RDS 数据库代理地址（`DB_HOST/DB_PORT`），凭证经 FGS 环境变量传入（不落代码）
- 差异：IAM 签名式认证令牌 → 账号密码 + VPC 私网/代理（省去签名流程）
