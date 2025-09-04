# 金蝶K3Cloud WebAPI SDK for PHP

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Packagist](https://img.shields.io/packagist/v/lizundao/k3cloud-webapi-sdk)](https://packagist.org/packages/lizundao/k3cloud-webapi-sdk)

这是一个用于金蝶K3Cloud系统的PHP WebAPI SDK，提供了完整的业务对象操作接口。基于金蝶官方提供的「金蝶PHP SDK V8.2.0」进行开发与Composer化封装。

## 功能特性

- 🚀 完整的K3Cloud WebAPI接口支持
- 📦 符合PSR-4标准的自动加载
- 🔧 灵活的配置管理
- 📝 详细的错误处理和日志记录
- 🧪 完整的单元测试覆盖
- 📚 丰富的示例代码

## 系统要求

- PHP >= 7.0.0
- cURL扩展
- JSON扩展

## 安装

### 通过Composer安装

```bash
composer require lizundao/k3cloud-webapi-sdk
```

### 手动安装

1. 下载源码
2. 运行 `composer install`

## 快速开始

### 1. 安装依赖

```bash
composer install
```

### 2. 配置参数

复制配置文件并修改相关参数：

```bash
cp config/config.example.ini config/config.ini
```

编辑 `config/config.ini` 文件，填入您的金蝶K3Cloud配置信息：

```ini
[config]
; 第三方系统登录授权的账套ID
X-KDApi-AcctID = your_account_id_here
; 第三方系统登录授权的用户
X-KDApi-UserName = your_username_here
; 第三方系统登录授权的应用ID
X-KDApi-AppID = your_app_id_here
; 第三方系统登录授权的应用密钥
X-KDApi-AppSec = your_app_secret_here
; 请求的产品环境地址
X-KDApi-ServerUrl = https://your-domain.com/k3cloud/
; 账套语系，默认2052
X-KDApi-LCID = 2052
```

### 3. 基本使用

```php
<?php
require_once 'vendor/autoload.php';

use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\K3CloudApi;

// 从INI文件加载配置
$config = Config::fromIni(__DIR__ . '/config/config.ini');

// 或者直接创建配置
// $config = new Config([
//     'server_url' => 'https://your-server.com/k3cloud/',
//     'acct_id' => 'your-account-id',
//     'username' => 'your-username',
//     'app_id' => 'your-app-id',
//     'app_secret' => 'your-app-secret',
//     'lcid' => 2052
// ]);

// 创建API实例
$api = new K3CloudApi($config);

// 推荐使用签名登录（更安全）
$loginResult = $api->loginBySign(
    $config->getAcctId(),
    $config->getUsername(),
    $config->getAppId(),
    $config->getAppSecret()
);

// 检查登录结果
$loginData = json_decode($loginResult, true);
if ($loginData['LoginResultType'] == 1) {
    echo "登录成功！\n";
    
    // 查询库存数据
    $queryData = [
        'FormId' => 'STK_Inventory',
        'FilterString' => '',
        'OrderString' => '',
        'TopRowCount' => 10,
        'StartRow' => 0,
        'Limit' => 0,
        'FieldKeys' => 'FID,FMaterialName,FQty'
    ];
    
    $result = $api->executeBillQuery($queryData);
    $data = json_decode($result, true);
    
    if (is_array($data) && !empty($data)) {
        echo "查询成功，获取到 " . count($data) . " 条记录\n";
        foreach ($data as $record) {
            echo "物料: " . $record[1] . " (数量: " . $record[2] . ")\n";
        }
    }
}
```

### 4. 运行测试

```bash
# 运行完整测试
php test_complete.php

# 查看使用示例
php example.php
```

### 物料管理示例

```php
// 保存物料
$materialData = [
    'Model' => [
        'FName' => '测试物料',
        'FNumber' => 'WL001',
        'FCreateOrgId' => ['FNumber' => '100'],
        'FUseOrgId' => ['FNumber' => '100']
    ]
];

$response = $api->save('BD_MATERIAL', $materialData);
echo $response;
```

### 销售订单管理示例

```php
// 保存销售订单
$orderData = [
    'Model' => [
        'FBillTypeID' => ['FNUMBER' => 'XSDD01_SYS'],
        'FDate' => date('Y-m-d'),
        'FSaleOrgId' => ['FNumber' => '100'],
        'FCustId' => ['FNumber' => 'CUST001'],
        'FSaleOrderEntry' => [
            [
                'FMaterialId' => ['FNumber' => 'WL001'],
                'FQty' => 10,
                'FPrice' => 100.00
            ]
        ]
    ]
];

$response = $api->save('SAL_SaleOrder', $orderData);
```

## 配置说明

| 配置项 | 说明 | 必填 |
|--------|------|------|
| server_url | K3Cloud服务器地址 | 是 |
| acct_id | 账套ID | 是 |
| username | 用户名 | 是 |
| app_id | 应用ID | 是 |
| app_secret | 应用密钥 | 是 |
| lcid | 语系ID（默认2052） | 否 |
| org_num | 组织编码 | 否 |
| connect_timeout | 连接超时时间（秒） | 否 |
| request_timeout | 请求超时时间（秒） | 否 |

## 主要接口

### 基础操作
- `save()` - 保存数据
- `batchSave()` - 批量保存数据  
- `submit()` - 提交数据
- `audit()` - 审核数据
- `unaudit()` - 反审核数据
- `delete()` - 删除数据
- `view()` - 查看数据
- `query()` - 查询数据
- `execute()` - 执行自定义操作
- `draft()` - 暂存数据

### 高级操作
- `allocate()` - 分配数据
- `cancelAllocate()` - 取消分配
- `executeOperation()` - 执行操作
- `flexSave()` - 弹性域保存
- `sendMsg()` - 发送消息
- `push()` - 下推数据
- `groupSave()` - 分组保存
- `disassembly()` - 拆单
- `cancelAssign()` - 撤销服务

### 查询和报表
- `queryBusinessInfo()` - 查询单据信息
- `queryGroupInfo()` - 查询分组信息
- `workFlowAudit()` - 工作流审批
- `getSysReportData()` - 获取报表数据

### 组织管理
- `switchOrg()` - 切换组织
- `groupDelete()` - 分组删除

### 附件管理
- `attachmentUpload()` - 上传附件
- `attachmentDownload()` - 下载附件

> **完整API文档**: 查看 [docs/API_REFERENCE.md](docs/API_REFERENCE.md) 获取详细的方法说明和示例代码

### 支持的业务对象
- BD_MATERIAL - 物料
- SAL_SaleOrder - 销售订单
- PUR_PurchaseOrder - 采购订单
- GL_Account - 会计科目
- 更多业务对象请参考金蝶官方文档

## 错误处理

```php
try {
    $response = $api->save('BD_MATERIAL', $data);
    $result = json_decode($response, true);
    
    if ($result['Result']['ResponseStatus']['IsSuccess']) {
        echo "操作成功";
    } else {
        echo "操作失败: " . $result['Result']['ResponseStatus']['Errors'][0]['Message'];
    }
} catch (Exception $e) {
    echo "异常: " . $e->getMessage();
}
```

## 开发

### 运行测试

```bash
composer test
```

### 代码规范检查

```bash
composer cs-check
composer cs-fix
```

## 许可证

MIT License

## 文档

- **快速开始**: 本文档
- **完整API参考**: [docs/API_REFERENCE.md](docs/API_REFERENCE.md)
- **安装指南**: [docs/INSTALL.md](docs/INSTALL.md)

## 支持

如有问题，请提交Issue或联系金蝶技术支持。

## 功能特性

- 🔐 **多种登录方式**: 支持签名登录、应用密钥登录、用户名密码登录
- 📊 **完整API支持**: 支持金蝶K3Cloud所有WebAPI操作
- 🔄 **会话管理**: 自动处理登录会话和状态维护
- 📁 **文件上传**: 支持附件上传和下载功能
- 🔧 **自定义调用**: 支持自定义WebAPI服务和SQL执行
- 🏢 **单点登录**: 支持SSO V1-V4版本
- ⚡ **高性能**: 基于cURL的HTTP客户端，支持并发请求
- 🛡️ **错误处理**: 完善的异常处理机制
- 📝 **配置灵活**: 支持INI文件配置和代码配置

## 项目地址

- **GitHub**: https://github.com/lizundao/k3cloud-webapi-sdk
- **Composer**: https://packagist.org/packages/lizundao/k3cloud-webapi-sdk
- **License**: MIT (see [LICENSE](LICENSE))
