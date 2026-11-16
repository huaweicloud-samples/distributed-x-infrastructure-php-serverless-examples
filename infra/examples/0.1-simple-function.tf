# 0.1 简单 PHP 函数（FGS PHP 7.4 原生运行时）
resource "huaweicloud_fgs_function" "php_simple" {
  name        = "php-simple"
  runtime     = "PHP7.3"
  handler     = "index.index"
  memory_size = 128
  timeout     = 30
  # code_type = "inline"（示例：真实部署请打包上传 src/0.1-simple-php-function/）
}
