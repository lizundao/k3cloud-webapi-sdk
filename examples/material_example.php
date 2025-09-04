<?php
/**
 * 物料管理示例
 * 演示如何使用SDK进行物料的增删改查操作
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\K3CloudApi;

// 创建配置
$config = new Config([
    'server_url' => 'https://apiexp.open.kingdee.com/k3cloud/',
    'acct_id' => 'your-account-id',
    'username' => 'your-username',
    'app_id' => 'your-app-id',
    'app_secret' => 'your-app-secret',
    'lcid' => 2052,
    'org_num' => '100'
]);

// 创建API实例
$api = new K3CloudApi($config);

// 生成物料编号
$materialNumber = "WL" . date("Ymdhis", time());

echo "=== 物料管理示例 ===\n";
echo "物料编号: {$materialNumber}\n\n";

try {
    // 1. 保存物料
    echo "1. 保存物料...\n";
    $materialData = [
        'NeedUpDateFields' => [],
        'NeedReturnFields' => [],
        'IsDeleteEntry' => 'true',
        'SubSystemId' => '',
        'IsVerifyBaseDataField' => 'false',
        'IsEntryBatchFill' => 'true',
        'ValidateFlag' => 'true',
        'NumberSearch' => 'true',
        'IsAutoAdjustField' => 'false',
        'Model' => [
            'FName' => "测试物料_{$materialNumber}",
            'FNumber' => $materialNumber,
            'FImgStorageType' => 'A',
            'FCreateOrgId' => ['FNumber' => '100'],
            'FUseOrgId' => ['FNumber' => '100'],
            'FSubHeadEntity' => ['FTimeUnit' => 'H'],
            'SubHeadEntity' => [
                'FErpClsID' => '1',
                'FFeatureItem' => '1',
                'FCategoryID' => ['FNumber' => 'CHLB01_SYS'],
                'FTaxType' => ['FNumber' => 'WLDSFL01_SYS'],
                'FTaxRateId' => ['FNUMBER' => 'SL02_SYS'],
                'FBaseUnitId' => ['FNumber' => 'Pcs'],
                'FIsPurchase' => true,
                'FIsInventory' => true,
                'FIsSale' => true,
                'FWEIGHTUNITID' => ['FNUMBER' => 'kg'],
                'FVOLUMEUNITID' => ['FNUMBER' => 'm']
            ]
        ]
    ];

    $response = $api->save('BD_MATERIAL', $materialData);
    $result = json_decode($response, true);
    
    if ($result['Result']['ResponseStatus']['IsSuccess']) {
        $materialId = $result['Result']['Id'];
        echo "✓ 物料保存成功，ID: {$materialId}\n";
    } else {
        echo "✗ 物料保存失败: " . $result['Result']['ResponseStatus']['Errors'][0]['Message'] . "\n";
        exit(1);
    }

    // 2. 提交物料
    echo "\n2. 提交物料...\n";
    $submitData = [
        'CreateOrgId' => 0,
        'Numbers' => [$materialNumber],
        'Ids' => '',
        'SelectedPostId' => 0,
        'NetworkCtrl' => '',
        'IgnoreInterationFlag' => ''
    ];

    $response = $api->submit('BD_MATERIAL', $submitData);
    $result = json_decode($response, true);
    
    if ($result['Result']['ResponseStatus']['IsSuccess']) {
        echo "✓ 物料提交成功\n";
    } else {
        echo "✗ 物料提交失败: " . $result['Result']['ResponseStatus']['Errors'][0]['Message'] . "\n";
    }

    // 3. 审核物料
    echo "\n3. 审核物料...\n";
    $auditData = [
        'CreateOrgId' => 0,
        'Numbers' => [$materialNumber],
        'Ids' => '',
        'InterationFlags' => '',
        'NetworkCtrl' => '',
        'IsVerifyProcInst' => '',
        'IgnoreInterationFlag' => '',
        'UseBatControlTimes' => 'false'
    ];

    $response = $api->audit('BD_MATERIAL', $auditData);
    $result = json_decode($response, true);
    
    if ($result['Result']['ResponseStatus']['IsSuccess']) {
        echo "✓ 物料审核成功\n";
    } else {
        echo "✗ 物料审核失败: " . $result['Result']['ResponseStatus']['Errors'][0]['Message'] . "\n";
    }

    // 4. 查询物料
    echo "\n4. 查询物料...\n";
    $queryData = [
        'FormId' => 'BD_MATERIAL',
        'FieldKeys' => 'FNumber,FName,FCreateOrgId',
        'FilterString' => "FNumber='{$materialNumber}'",
        'OrderString' => '',
        'TopRowCount' => 0,
        'StartRow' => 0
    ];

    $response = $api->query('BD_MATERIAL', $queryData);
    $result = json_decode($response, true);
    
    if ($result['Result']['ResponseStatus']['IsSuccess']) {
        echo "✓ 物料查询成功\n";
        if (!empty($result['Result']['Result']['Rows'])) {
            $material = $result['Result']['Result']['Rows'][0];
            echo "  物料名称: " . $material['FName'] . "\n";
            echo "  物料编号: " . $material['FNumber'] . "\n";
        }
    } else {
        echo "✗ 物料查询失败: " . $result['Result']['ResponseStatus']['Errors'][0]['Message'] . "\n";
    }

    echo "\n=== 物料管理示例完成 ===\n";

} catch (Exception $e) {
    echo "✗ 发生异常: " . $e->getMessage() . "\n";
    exit(1);
}
