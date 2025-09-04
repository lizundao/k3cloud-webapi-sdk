<?php

namespace Lizundao\K3CloudSDK\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\K3CloudApi;

/**
 * 库存查询集成测试
 * 注意：这是集成测试，需要真实的金蝶服务器配置
 */
class InventoryTest extends TestCase
{
    private $api;
    private $config;

    protected function setUp(): void
    {
        // 从配置文件加载真实配置
        $configPath = __DIR__ . '/../../config/config.ini';
        
        if (!file_exists($configPath)) {
            $this->markTestSkipped('配置文件不存在，请复制 config.example.ini 为 config.ini 并填入真实配置');
        }

        try {
            $this->config = Config::fromIni($configPath);
            $this->api = new K3CloudApi($this->config);
        } catch (\Exception $e) {
            $this->markTestSkipped('配置加载失败: ' . $e->getMessage());
        }
    }

    /**
     * 测试查询库存数据
     */
    public function testQueryInventory()
    {
        $this->assertNotNull($this->api, 'API实例未初始化');

        // 构建查询参数
        $queryData = [
            'FormId' => 'STK_Inventory',
            'FieldKeys' => 'FNumber,FName,FQty,FBaseQty,FStockOrgId,FStockStatusId,FMaterialId',
            'FilterString' => '', // 可以添加过滤条件，如 "FQty > 0"
            'OrderString' => 'FNumber',
            'TopRowCount' => 10, // 限制返回前10条记录
            'StartRow' => 0
        ];

        try {
            $response = $this->api->query('STK_Inventory', $queryData);
            $this->assertNotEmpty($response, '响应不能为空');

            $result = json_decode($response, true);
            $this->assertIsArray($result, '响应应该是数组格式');

            // 检查响应结构
            if (isset($result['Result']['ResponseStatus']['IsSuccess'])) {
                $isSuccess = $result['Result']['ResponseStatus']['IsSuccess'];
                
                if ($isSuccess) {
                    echo "\n=== 库存查询成功 ===\n";
                    
                    if (isset($result['Result']['Result']['Rows'])) {
                        $rows = $result['Result']['Result']['Rows'];
                        echo "查询到 " . count($rows) . " 条库存记录\n\n";
                        
                        foreach ($rows as $index => $row) {
                            echo "记录 " . ($index + 1) . ":\n";
                            echo "  物料编号: " . ($row['FNumber'] ?? 'N/A') . "\n";
                            echo "  物料名称: " . ($row['FName'] ?? 'N/A') . "\n";
                            echo "  库存数量: " . ($row['FQty'] ?? 'N/A') . "\n";
                            echo "  基本单位数量: " . ($row['FBaseQty'] ?? 'N/A') . "\n";
                            echo "  库存组织: " . ($row['FStockOrgId'] ?? 'N/A') . "\n";
                            echo "  库存状态: " . ($row['FStockStatusId'] ?? 'N/A') . "\n";
                            echo "  物料ID: " . ($row['FMaterialId'] ?? 'N/A') . "\n";
                            echo "\n";
                        }
                    } else {
                        echo "未找到库存数据\n";
                    }
                } else {
                    $errors = $result['Result']['ResponseStatus']['Errors'] ?? [];
                    $errorMsg = !empty($errors) ? $errors[0]['Message'] : '未知错误';
                    echo "查询失败: " . $errorMsg . "\n";
                }
            } else {
                echo "响应格式异常: " . $response . "\n";
            }

        } catch (\Exception $e) {
            $this->fail('查询库存时发生异常: ' . $e->getMessage());
        }
    }

    /**
     * 测试查询特定物料的库存
     */
    public function testQueryInventoryByMaterial()
    {
        $this->assertNotNull($this->api, 'API实例未初始化');

        // 查询特定物料编号的库存（请根据实际情况修改物料编号）
        $materialNumber = 'WL001'; // 请替换为实际的物料编号

        $queryData = [
            'FormId' => 'STK_Inventory',
            'FieldKeys' => 'FNumber,FName,FQty,FBaseQty,FStockOrgId,FStockStatusId',
            'FilterString' => "FNumber='{$materialNumber}'",
            'OrderString' => 'FNumber',
            'TopRowCount' => 0,
            'StartRow' => 0
        ];

        try {
            $response = $this->api->query('STK_Inventory', $queryData);
            $result = json_decode($response, true);

            if (isset($result['Result']['ResponseStatus']['IsSuccess']) && 
                $result['Result']['ResponseStatus']['IsSuccess']) {
                
                echo "\n=== 查询物料 {$materialNumber} 的库存 ===\n";
                
                if (isset($result['Result']['Result']['Rows'])) {
                    $rows = $result['Result']['Result']['Rows'];
                    echo "找到 " . count($rows) . " 条记录\n";
                    
                    foreach ($rows as $row) {
                        echo "物料编号: " . ($row['FNumber'] ?? 'N/A') . "\n";
                        echo "物料名称: " . ($row['FName'] ?? 'N/A') . "\n";
                        echo "库存数量: " . ($row['FQty'] ?? 'N/A') . "\n";
                        echo "库存组织: " . ($row['FStockOrgId'] ?? 'N/A') . "\n";
                    }
                } else {
                    echo "未找到物料 {$materialNumber} 的库存记录\n";
                }
            }

        } catch (\Exception $e) {
            echo "查询特定物料库存时发生异常: " . $e->getMessage() . "\n";
        }
    }

    /**
     * 测试查询有库存的物料
     */
    public function testQueryInventoryWithStock()
    {
        $this->assertNotNull($this->api, 'API实例未初始化');

        $queryData = [
            'FormId' => 'STK_Inventory',
            'FieldKeys' => 'FNumber,FName,FQty,FBaseQty,FStockOrgId',
            'FilterString' => 'FQty > 0', // 只查询有库存的
            'OrderString' => 'FQty DESC', // 按库存数量降序
            'TopRowCount' => 5, // 只返回前5条
            'StartRow' => 0
        ];

        try {
            $response = $this->api->query('STK_Inventory', $queryData);
            $result = json_decode($response, true);

            if (isset($result['Result']['ResponseStatus']['IsSuccess']) && 
                $result['Result']['ResponseStatus']['IsSuccess']) {
                
                echo "\n=== 查询有库存的物料（前5条） ===\n";
                
                if (isset($result['Result']['Result']['Rows'])) {
                    $rows = $result['Result']['Result']['Rows'];
                    
                    foreach ($rows as $index => $row) {
                        echo ($index + 1) . ". " . ($row['FNumber'] ?? 'N/A') . 
                             " - " . ($row['FName'] ?? 'N/A') . 
                             " (库存: " . ($row['FQty'] ?? 'N/A') . ")\n";
                    }
                }
            }

        } catch (\Exception $e) {
            echo "查询有库存物料时发生异常: " . $e->getMessage() . "\n";
        }
    }
}
