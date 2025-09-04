<?php
/**
 * 从INI文件加载配置的示例
 * 演示如何使用INI配置文件来初始化SDK
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\K3CloudApi;

try {
    // 从INI文件加载配置
    $config = Config::fromIni(__DIR__ . '/../config/config.example.ini');
    
    // 创建API实例
    $api = new K3CloudApi($config);
    
    echo "=== 配置加载成功 ===\n";
    echo "服务器地址: " . $config->getServerUrl() . "\n";
    echo "账套ID: " . $config->getAcctId() . "\n";
    echo "用户名: " . $config->getUsername() . "\n";
    echo "应用ID: " . $config->getAppId() . "\n";
    echo "语系ID: " . $config->getLcid() . "\n";
    echo "组织编码: " . $config->getOrgNum() . "\n";
    echo "连接超时: " . $config->getConnectTimeout() . "秒\n";
    echo "请求超时: " . $config->getRequestTimeout() . "秒\n";
    
    if ($config->getProxy()) {
        echo "代理设置: " . $config->getProxy() . "\n";
    }
    
    echo "\n=== 配置验证完成 ===\n";
    
} catch (\InvalidArgumentException $e) {
    echo "配置错误: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "其他错误: " . $e->getMessage() . "\n";
    exit(1);
}
