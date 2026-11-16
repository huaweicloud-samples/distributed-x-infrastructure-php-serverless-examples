# 0.3 HTTP 服务器替换（OBS 静态桶 + APIG 动态函数）
# 静态资源：OBS 静态托管（index.html/assets），按需叠加 CDN
resource "huaweicloud_obs_bucket" "static" {
  bucket = "lamp-static-example"   # 请改为全局唯一
  acl    = "public-read"
  website {
    index_document = "index.html"
  }
}
# 动态请求：APIG → FGS PHP（完整配置见 docs/deployment-guide.md）
resource "huaweicloud_fgs_function" "php_dynamic" {
  name        = "php-http-dynamic"
  runtime     = "PHP7.3"
  handler     = "index.index"
  memory_size = 128
  timeout     = 30
}
