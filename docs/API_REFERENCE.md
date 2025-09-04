# API 参考文档

## 概述

金蝶K3Cloud WebAPI SDK 提供了完整的业务对象操作接口，支持所有标准的金蝶K3Cloud WebAPI功能。

## 核心类

### K3CloudApi

主要的API类，提供所有业务操作方法。

#### 构造函数

```php
public function __construct(Config $config)
```

**参数:**
- `$config` - 配置对象，包含服务器地址、认证信息等

**示例:**
```php
use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\K3CloudApi;

$config = new Config([
    'server_url' => 'https://your-server.com/k3cloud/',
    'acct_id' => 'your-account-id',
    'username' => 'your-username',
    'app_id' => 'your-app-id',
    'app_secret' => 'your-app-secret'
]);

$api = new K3CloudApi($config);
```

## 基础操作方法

### 保存数据

#### save()

保存单个业务对象数据。

```php
public function save(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识（如：'BD_MATERIAL', 'SAL_SaleOrder'）
- `$data` - 要保存的数据数组

**返回值:**
- 成功时返回JSON格式的响应字符串
- 失败时抛出异常

**示例:**
```php
$materialData = [
    'Model' => [
        'FName' => '测试物料',
        'FNumber' => 'WL001',
        'FCreateOrgId' => ['FNumber' => '100']
    ]
];

$response = $api->save('BD_MATERIAL', $materialData);
```

#### batchSave()

批量保存多个业务对象数据。

```php
public function batchSave(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 要批量保存的数据数组

**示例:**
```php
$materialsData = [
    'Model' => [
        [
            'FName' => '物料1',
            'FNumber' => 'WL001'
        ],
        [
            'FName' => '物料2',
            'FNumber' => 'WL002'
        ]
    ]
];

$response = $api->batchSave('BD_MATERIAL', $materialsData);
```

### 数据状态管理

#### submit()

提交数据，将数据状态从"暂存"改为"已提交"。

```php
public function submit(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 提交参数，通常包含单据编号或ID

**示例:**
```php
$submitData = [
    'CreateOrgId' => 0,
    'Numbers' => ['WL001'],
    'Ids' => '',
    'SelectedPostId' => 0
];

$response = $api->submit('BD_MATERIAL', $submitData);
```

#### audit()

审核数据，将数据状态从"已提交"改为"已审核"。

```php
public function audit(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 审核参数

**示例:**
```php
$auditData = [
    'CreateOrgId' => 0,
    'Numbers' => ['WL001'],
    'Ids' => '',
    'InterationFlags' => ''
];

$response = $api->audit('BD_MATERIAL', $auditData);
```

#### unaudit()

反审核数据，将数据状态从"已审核"改为"已提交"。

```php
public function unaudit(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 反审核参数

**示例:**
```php
$unauditData = [
    'CreateOrgId' => 0,
    'Numbers' => ['WL001'],
    'Ids' => ''
];

$response = $api->unaudit('BD_MATERIAL', $unauditData);
```

#### draft()

暂存数据，将数据保存为草稿状态。

```php
public function draft(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 要暂存的数据

**示例:**
```php
$draftData = [
    'Model' => [
        'FName' => '草稿物料',
        'FNumber' => 'WL_DRAFT_001'
    ]
];

$response = $api->draft('BD_MATERIAL', $draftData);
```

### 数据查询

#### query()

执行单据查询。

```php
public function query(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 查询条件

**示例:**
```php
$queryData = [
    'FormId' => 'BD_MATERIAL',
    'FieldKeys' => 'FNumber,FName,FCreateOrgId',
    'FilterString' => "FNumber='WL001'",
    'OrderString' => '',
    'TopRowCount' => 0,
    'StartRow' => 0
];

$response = $api->query('BD_MATERIAL', $queryData);
```

#### view()

查看单个业务对象数据。

```php
public function view(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 查看参数，通常包含单据编号或ID

**示例:**
```php
$viewData = [
    'FormId' => 'BD_MATERIAL',
    'Number' => 'WL001'
];

$response = $api->view('BD_MATERIAL', $viewData);
```

### 数据删除

#### delete()

删除业务对象数据。

```php
public function delete(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 删除参数

**示例:**
```php
$deleteData = [
    'CreateOrgId' => 0,
    'Numbers' => ['WL001'],
    'Ids' => ''
];

$response = $api->delete('BD_MATERIAL', $deleteData);
```

## 高级操作方法

### 数据分配

#### allocate()

分配数据到指定组织。

```php
public function allocate(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 分配参数

**示例:**
```php
$allocateData = [
    'PkIds' => '12345',
    'TOrgIds' => '100002'
];

$response = $api->allocate('BD_MATERIAL', $allocateData);
```

#### cancelAllocate()

取消数据分配。

```php
public function cancelAllocate(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 取消分配参数

**示例:**
```php
$cancelAllocateData = [
    'PkIds' => '12345',
    'TOrgIds' => '100002'
];

$response = $api->cancelAllocate('BD_MATERIAL', $cancelAllocateData);
```

### 操作执行

#### executeOperation()

执行特定的业务操作。

```php
public function executeOperation(string $formId, string $opNumber, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$opNumber` - 操作编码
- `$data` - 操作参数

**示例:**
```php
$operationData = [
    'CreateOrgId' => 0,
    'Numbers' => ['WL001']
];

$response = $api->executeOperation('BD_MATERIAL', 'OP001', $operationData);
```

### 弹性域操作

#### flexSave()

保存弹性域数据。

```php
public function flexSave(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 弹性域数据

**示例:**
```php
$flexData = [
    'Model' => [
        'FNumber' => 'WL001',
        'FlexValues' => [
            'F_001' => '自定义值1',
            'F_002' => '自定义值2'
        ]
    ]
];

$response = $api->flexSave('BD_MATERIAL', $flexData);
```

### 消息和通知

#### sendMsg()

发送消息。

```php
public function sendMsg($data): string
```

**参数:**
- `$data` - 消息数据，可以是数组或字符串

**示例:**
```php
$messageData = [
    'ReceiverIds' => ['user001', 'user002'],
    'Subject' => '测试消息',
    'Content' => '这是一条测试消息'
];

$response = $api->sendMsg($messageData);
```

### 数据流转

#### push()

下推数据到下级单据。

```php
public function push(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 下推参数

**示例:**
```php
$pushData = [
    'SourceBillId' => '12345',
    'TargetFormId' => 'PUR_PurchaseOrder'
];

$response = $api->push('SAL_SaleOrder', $pushData);
```

### 分组操作

#### groupSave()

分组保存数据。

```php
public function groupSave(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 分组数据

**示例:**
```php
$groupData = [
    'GroupId' => 'GROUP001',
    'Models' => [
        ['FName' => '物料1', 'FNumber' => 'WL001'],
        ['FName' => '物料2', 'FNumber' => 'WL002']
    ]
];

$response = $api->groupSave('BD_MATERIAL', $groupData);
```

#### groupDelete()

删除分组数据。

```php
public function groupDelete($data): string
```

**参数:**
- `$data` - 删除分组参数

**示例:**
```php
$groupDeleteData = [
    'GroupId' => 'GROUP001'
];

$response = $api->groupDelete($groupDeleteData);
```

### 单据操作

#### disassembly()

拆单操作。

```php
public function disassembly(string $formId, array $data): string
```

**参数:**
- `$formId` - 业务对象标识
- `$data` - 拆单参数

**示例:**
```php
$disassemblyData = [
    'SourceBillId' => '12345',
    'SplitRules' => [
        'SplitBy' => 'Qty',
        'SplitValue' => 100
    ]
];

$response = $api->disassembly('SAL_SaleOrder', $disassemblyData);
```

## 查询和报表方法

### 业务信息查询

#### queryBusinessInfo()

查询单据业务信息。

```php
public function queryBusinessInfo($data): string
```

**参数:**
- `$data` - 查询参数

**示例:**
```php
$businessQueryData = [
    'FormId' => 'SAL_SaleOrder',
    'BillNo' => 'SO001'
];

$response = $api->queryBusinessInfo($businessQueryData);
```

#### queryGroupInfo()

查询分组信息。

```php
public function queryGroupInfo($data): string
```

**参数:**
- `$data` - 查询参数

**示例:**
```php
$groupQueryData = [
    'GroupId' => 'GROUP001'
];

$response = $api->queryGroupInfo($groupQueryData);
```

### 报表数据

#### getSysReportData()

获取系统报表数据。

```php
public function getSysReportData(string $formId, array $data): string
```

**参数:**
- `$formId` - 报表标识
- `$data` - 报表参数

**示例:**
```php
$reportData = [
    'ReportId' => 'RPT001',
    'Parameters' => [
        'StartDate' => '2024-01-01',
        'EndDate' => '2024-01-31'
    ]
];

$response = $api->getSysReportData('RPT001', $reportData);
```

### 工作流

#### workFlowAudit()

工作流审批。

```php
public function workFlowAudit($data): string
```

**参数:**
- `$data` - 工作流审批参数

**示例:**
```php
$workflowData = [
    'BillId' => '12345',
    'Action' => 'Approve',
    'Comment' => '同意'
];

$response = $api->workFlowAudit($workflowData);
```

## 组织管理方法

### 组织切换

#### switchOrg()

切换当前操作的组织。

```php
public function switchOrg($data): string
```

**参数:**
- `$data` - 组织切换参数

**示例:**
```php
$switchOrgData = [
    'OrgId' => '100002'
];

$response = $api->switchOrg($switchOrgData);
```

## 附件管理方法

### 附件上传下载

#### attachmentUpload()

上传附件。

```php
public function attachmentUpload($data): string
```

**参数:**
- `$data` - 附件上传参数

**示例:**
```php
$uploadData = [
    'BillId' => '12345',
    'FileName' => 'test.pdf',
    'FileContent' => base64_encode(file_get_contents('test.pdf'))
];

$response = $api->attachmentUpload($uploadData);
```

#### attachmentDownload()

下载附件。

```php
public function attachmentDownload($data): string
```

**参数:**
- `$data` - 附件下载参数

**示例:**
```php
$downloadData = [
    'AttachmentId' => 'ATT001'
];

$response = $api->attachmentDownload($downloadData);
```

## 通用执行方法

### execute()

执行自定义操作。

```php
public function execute(string $uri, string $data): string
```

**参数:**
- `$uri` - 操作URI
- `$data` - 操作数据

**示例:**
```php
$customUri = 'Kingdee.K3.SCM.WebApi.ServicesStub.SaveXSaleOrderWebApi.SaveXSaleOrder';
$customData = json_encode([
    'SaleOrderBillNo' => 'SO001',
    'SaleOrderBillId' => '12345'
]);

$response = $api->execute($customUri, $customData);
```

## 错误处理

所有方法在失败时都会抛出 `HttpException` 异常，包含详细的错误信息。

**示例:**
```php
try {
    $response = $api->save('BD_MATERIAL', $data);
    $result = json_decode($response, true);
    
    if ($result['Result']['ResponseStatus']['IsSuccess']) {
        echo "操作成功";
    } else {
        echo "操作失败: " . $result['Result']['ResponseStatus']['Errors'][0]['Message'];
    }
} catch (HttpException $e) {
    echo "HTTP错误: " . $e->getMessage();
} catch (Exception $e) {
    echo "其他错误: " . $e->getMessage();
}
```

## 响应格式

所有API方法都返回JSON格式的字符串，响应结构如下：

**成功响应:**
```json
{
    "Result": {
        "ResponseStatus": {
            "IsSuccess": true,
            "Errors": [],
            "SuccessEntitys": []
        },
        "Id": "12345",
        "Number": "WL001"
    }
}
```

**失败响应:**
```json
{
    "Result": {
        "ResponseStatus": {
            "IsSuccess": false,
            "Errors": [
                {
                    "FieldName": "FName",
                    "Message": "字段不能为空"
                }
            ]
        }
    }
}
```

## 最佳实践

1. **错误处理**: 始终使用try-catch块处理可能的异常
2. **参数验证**: 在调用API前验证必要参数
3. **响应解析**: 检查响应中的 `IsSuccess` 字段判断操作结果
4. **批量操作**: 对于大量数据，使用批量方法提高效率
5. **日志记录**: 记录API调用的请求和响应信息，便于调试
