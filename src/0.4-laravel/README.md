# 0.4 Serverless Laravel

**源示例**：0.4 源示例（Serverless Laravel + SAM）（Laravel + SAM）
**华为云形态（推荐）**：CCE 容器部署完整 Laravel（Nginx+PHP-FPM+Artisan）
**华为云形态（快速验证）**：FGS PHP 简化入口（轻量端点，不含完整框架生命周期）

```hcl
# 简化入口示例（完整 Laravel 建议 CCE 容器，见 docs/deployment-guide.md）
resource "huaweicloud_fgs_function" "laravel_hello" {
  name        = "laravel-hello"
  runtime     = "PHP7.3"
  handler     = "index"
  memory_size = 256
  timeout     = 30
}
```

- 差异：SAM（Function+Layer+FPM）→ 容器/FGS；完整框架以容器形态保真（architecture-adaptation.md §3）
