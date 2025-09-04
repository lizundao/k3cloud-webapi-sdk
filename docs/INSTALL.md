# 安装说明

## 系统要求

- PHP >= 7.0.0
- cURL扩展
- JSON扩展
- Composer

## 安装步骤

### 方法一：通过Composer安装（推荐）

```bash
composer require lizundao/k3cloud-webapi-sdk
```

### 方法二：手动安装

#### 1. 克隆项目

```bash
git clone https://github.com/lizundao/k3cloud-webapi-sdk.git
cd k3cloud-webapi-sdk
```

#### 2. 安装依赖

```bash
composer install
```

#### 3. 配置

复制配置文件示例并修改：

```bash
cp config/config.example.ini config/config.ini
```

编辑 `config/config.ini` 文件，填入你的金蝶K3Cloud配置信息：

```ini
[config]
X-KDApi-AcctID = your-account-id
X-KDApi-UserName = your-username
X-KDApi-AppID = your-app-id
X-KDApi-AppSec = your-app-secret
X-KDApi-ServerUrl = https://your-server.com/k3cloud/
X-KDApi-LCID = 2052
X-KDApi-OrgNum = 100
X-KDApi-ConnectTimeout = 360
X-KDApi-RequestTimeout = 360
```

#### 4. 验证安装

运行示例代码验证安装：

```bash
php examples/config_from_ini_example.php
```

## 开发环境设置

### 1. 安装开发依赖

```bash
composer install --dev
```

### 2. 运行测试

```bash
composer test
```

### 3. 代码规范检查

```bash
composer cs-check
composer cs-fix
```

## 使用方式

### 基本使用

```php
<?php
require_once 'vendor/autoload.php';

use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\K3CloudApi;

// 创建配置
$config = new Config([
    'server_url' => 'https://your-server.com/k3cloud/',
    'acct_id' => 'your-account-id',
    'username' => 'your-username',
    'app_id' => 'your-app-id',
    'app_secret' => 'your-app-secret'
]);

// 创建API实例
$api = new K3CloudApi($config);

// 使用API
$response = $api->save('BD_MATERIAL', $data);
```

### 从INI文件加载配置

```php
<?php
require_once 'vendor/autoload.php';

use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\K3CloudApi;

// 从INI文件加载配置
$config = Config::fromIni('config/config.ini');

// 创建API实例
$api = new K3CloudApi($config);
```

## 故障排除

### 常见问题

1. **cURL扩展未安装**
   - 错误：`Call to undefined function curl_init()`
   - 解决：安装PHP cURL扩展

2. **JSON扩展未安装**
   - 错误：`Call to undefined function json_encode()`
   - 解决：安装PHP JSON扩展

3. **配置验证失败**
   - 错误：`配置项 'xxx' 不能为空`
   - 解决：检查配置文件，确保所有必填项都已填写

4. **网络连接失败**
   - 错误：`cURL错误`
   - 解决：检查网络连接、防火墙设置、代理配置

### 调试模式

启用调试模式查看详细错误信息：

```php
// 设置错误报告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 捕获异常
try {
    $response = $api->save('BD_MATERIAL', $data);
} catch (Exception $e) {
    echo "错误: " . $e->getMessage() . "\n";
    echo "文件: " . $e->getFile() . "\n";
    echo "行号: " . $e->getLine() . "\n";
}
```

## 支持

如果遇到问题，请：

1. 检查系统要求是否满足
2. 查看错误日志
3. 运行测试验证安装
4. 提交Issue或联系技术支持
