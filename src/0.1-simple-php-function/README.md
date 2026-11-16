# 0.1 简单 PHP 函数

**示例**：0.1-SimplePhpFunction（自定义运行时 bootstrap + 依赖层）
**华为云形态**：FGS PHP 7.4 原生函数（免 bootstrap）

- 入口：`index.php` 的 `index($event, $context)`；handler 配置 `index.index`（文件.函数，实测）
- 部署：见 `infra/examples/0.1-simple-function.tf`
- 验证：
  ```bash
  hcloud FunctionGraph InvokeFunction --function_urn="<urn>" --body='{"name":"LAMP"}'
  # 预期：{"message":"Hello, LAMP!"}
  ```
- 差异：自定义运行时 bootstrap → FGS 原生 PHP（运行时机制相同，代码同语言直转）
