<?php

namespace Lizundao\K3CloudSDK;

use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\Http\HttpClient;
use Lizundao\K3CloudSDK\Exception\HttpException;

/**
 * 金蝶K3Cloud WebAPI 主类
 */
class K3CloudApi
{
    /**
     * @var Config 配置对象
     */
    private $config;

    /**
     * @var HttpClient HTTP客户端
     */
    private $httpClient;

    /**
     * 构造函数
     *
     * @param Config $config 配置对象
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClient($config);
    }

    /**
     * 保存数据
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function save(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Save.common.kdsvc';
        
        // 按照原始SDK的格式构建参数
        $parameters = [$formId, $data];
        $postData = '{"parameters":' . json_encode($parameters) . '}';

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 提交数据
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function submit(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Submit.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 审核数据
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function audit(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Audit.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 删除数据
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function delete(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Delete.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 查询数据
     *
     * @param string $formId 表单ID
     * @param array $data 查询条件
     * @return string 响应结果
     * @throws HttpException
     */
    public function query(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.ExecuteBillQuery.common.kdsvc';
        
        // 按照官方Postman格式，查询参数包装在parameters数组中
        $postData = json_encode(['parameters' => [$data]]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 执行单据查询（原始SDK方法名）
     *
     * @param array $data 查询条件
     * @return string 响应结果
     * @throws HttpException
     */
    public function executeBillQuery(array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.ExecuteBillQuery.common.kdsvc';
        
        // 按照官方Postman格式，查询参数包装在parameters数组中
        $postData = json_encode(['parameters' => [$data]]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 执行自定义操作
     *
     * @param string $uri 操作URI
     * @param string $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function execute(string $uri, string $data): string
    {
        $url = $this->config->getServerUrl() . $uri;
        
        $postData = [
            'data' => $data
        ];

        return $this->httpClient->post($url, $postData);
    }

    /**
     * 分配数据
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function allocate(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Allocate.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 取消分配
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function cancelAllocate(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.CancelAllocate.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 批量保存
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function batchSave(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.BatchSave.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 反审核
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function unaudit(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.UnAudit.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 查看
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function view(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.View.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 暂存
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function draft(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Draft.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 执行操作
     *
     * @param string $formId 表单ID
     * @param string $opNumber 操作编码
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function executeOperation(string $formId, string $opNumber, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.ExcuteOperation.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId、opNumber和data
        $postData = json_encode([
            'parameters' => [$formId, $opNumber, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 弹性域保存
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function flexSave(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.FlexSave.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 发送消息
     *
     * @param array|string $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function sendMsg($data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.SendMsg.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含data
        $postData = json_encode([
            'parameters' => [is_array($data) ? json_encode($data) : $data]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 下推
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function push(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Push.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 分组保存
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function groupSave(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.GroupSave.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 拆单
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function disassembly(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.Disassembly.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 查询单据信息
     *
     * @param array|string $data 查询条件
     * @return string 响应结果
     * @throws HttpException
     */
    public function queryBusinessInfo($data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.QueryBusinessInfo.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含data
        $postData = json_encode([
            'parameters' => [is_array($data) ? json_encode($data) : $data]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 查询分组信息
     *
     * @param array|string $data 查询条件
     * @return string 响应结果
     * @throws HttpException
     */
    public function queryGroupInfo($data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.QueryGroupInfo.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含data
        $postData = json_encode([
            'parameters' => [is_array($data) ? json_encode($data) : $data]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 工作流审批
     *
     * @param array|string $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function workFlowAudit($data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.WorkflowAudit.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含data
        $postData = json_encode([
            'parameters' => [is_array($data) ? json_encode($data) : $data]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 分组删除
     *
     * @param array|string $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function groupDelete($data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.GroupDelete.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含data
        $postData = json_encode([
            'parameters' => [is_array($data) ? json_encode($data) : $data]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 切换组织
     *
     * @param array|string $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function switchOrg($data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.SwitchOrg.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含data
        $postData = json_encode([
            'parameters' => [is_array($data) ? json_encode($data) : $data]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 撤销服务
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function cancelAssign(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.CancelAssign.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 获取报表数据
     *
     * @param string $formId 表单ID
     * @param array $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function getSysReportData(string $formId, array $data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.GetSysReportData.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含formId和data
        $postData = json_encode([
            'parameters' => [$formId, json_encode($data)]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 上传附件
     *
     * @param array|string $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function attachmentUpload($data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.AttachmentUpload.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含data
        $postData = json_encode([
            'parameters' => [is_array($data) ? json_encode($data) : $data]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 下载附件
     *
     * @param array|string $data 数据
     * @return string 响应结果
     * @throws HttpException
     */
    public function attachmentDownload($data): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.AttachmentDownLoad.common.kdsvc';
        
        // 按照Postman格式：parameters数组中包含data
        $postData = json_encode([
            'parameters' => [is_array($data) ? json_encode($data) : $data]
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 获取配置对象
     *
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * 获取HTTP客户端
     *
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    // ==================== 认证相关方法 ====================

    /**
     * 用户登录验证
     *
     * @param string $acctId 账套ID
     * @param string $username 用户名
     * @param string $password 密码
     * @param int $lcid 语言ID，默认2052
     * @return string 响应结果
     * @throws HttpException
     */
    public function validateUser(string $acctId, string $username, string $password, int $lcid = 2052): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.AuthService.ValidateUser.common.kdsvc';
        
        $postData = json_encode([
            'parameters' => [$acctId, $username, $password, $lcid]
        ]);

        return $this->httpClient->post($url, [], $postData, [], true);
    }

    /**
     * AppSecret登录
     *
     * @param string $acctId 账套ID
     * @param string $username 用户名
     * @param string $appId 应用ID
     * @param string $appSecret 应用密钥
     * @param int $lcid 语言ID，默认2052
     * @return string 响应结果
     * @throws HttpException
     */
    public function loginByAppSecret(string $acctId, string $username, string $appId, string $appSecret, int $lcid = 2052): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.AuthService.LoginByAppSecret.common.kdsvc';
        
        $postData = json_encode([
            'parameters' => [$acctId, $username, $appId, $appSecret, $lcid]
        ]);

        $result = $this->httpClient->post($url, [], $postData, [], true);
        
        // 解析登录结果，提取会话ID
        $this->parseLoginResult($result);
        
        return $result;
    }

    /**
     * 集成秘钥文件登录
     *
     * @param string $passport 集成秘钥文件内容
     * @param int $lcid 语言ID，默认2052
     * @return string 响应结果
     * @throws HttpException
     */
    public function loginBySimplePassport(string $passport, int $lcid = 2052): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.AuthService.LoginBySimplePassport.common.kdsvc';
        
        $postData = json_encode([
            'parameters' => [$passport, $lcid]
        ]);

        return $this->httpClient->post($url, [], $postData, [], true);
    }

    /**
     * 登录并指定当前组织
     *
     * @param string $acctId 账套ID
     * @param string $username 用户名
     * @param string $password 密码
     * @param int $lcid 语言ID，默认2052
     * @param string $orgNumber 组织编码
     * @return string 响应结果
     * @throws HttpException
     */
    public function validateUserByOrgNumber(string $acctId, string $username, string $password, int $lcid = 2052, string $orgNumber = ''): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.AuthService.ValidateUserByOrgNumber.common.kdsvc';
        
        $parameters = [$acctId, $username, $password, $lcid];
        if (!empty($orgNumber)) {
            $parameters[] = $orgNumber;
        }
        
        $postData = json_encode([
            'parameters' => $parameters
        ]);

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 注销登录
     *
     * @return string 响应结果
     * @throws HttpException
     */
    public function logout(): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.AuthService.Logout.common.kdsvc';
        
        $postData = '';

        return $this->httpClient->post($url, [], $postData);
    }

    // ==================== 自定义WebAPI调用 ====================

    /**
     * 自定义业务服务调用
     *
     * @param string $jsonString 请求参数JSON字符串
     * @param string $projectNamespace 项目命名空间
     * @param string $projectClassName 项目类名
     * @param string $projectClassMethod 项目方法名
     * @return string 响应结果
     * @throws HttpException
     */
    public function customBusinessServiceByParameters(
        string $jsonString,
        string $projectNamespace,
        string $projectClassName,
        string $projectClassMethod
    ): string {
        $url = $this->config->getServerUrl() . "{$projectNamespace}.{$projectClassName}.{$projectClassMethod},{$projectNamespace}.common.kdsvc";
        
        $postData = $jsonString;

        return $this->httpClient->post($url, [], $postData);
    }

    /**
     * 自定义业务服务调用（使用数组参数）
     *
     * @param array $parameters 请求参数数组
     * @param string $projectNamespace 项目命名空间
     * @param string $projectClassName 项目类名
     * @param string $projectClassMethod 项目方法名
     * @return string 响应结果
     * @throws HttpException
     */
    public function customBusinessService(
        array $parameters,
        string $projectNamespace,
        string $projectClassName,
        string $projectClassMethod
    ): string {
        $jsonString = json_encode(['parameters' => $parameters]);
        return $this->customBusinessServiceByParameters($jsonString, $projectNamespace, $projectClassName, $projectClassMethod);
    }

    /**
     * 执行SQL查询
     *
     * @param string $sql SQL语句
     * @param string $projectNamespace 项目命名空间，默认GlobalServiceCustom.WebApi
     * @param string $projectClassName 项目类名，默认DataServiceHandler
     * @param string $projectClassMethod 项目方法名，默认ExecuteDynamicObject
     * @return string 响应结果
     * @throws HttpException
     */
    public function executeSql(
        string $sql,
        string $projectNamespace = 'GlobalServiceCustom.WebApi',
        string $projectClassName = 'DataServiceHandler',
        string $projectClassMethod = 'ExecuteDynamicObject'
    ): string {
        return $this->customBusinessService([$sql], $projectNamespace, $projectClassName, $projectClassMethod);
    }

    /**
     * 生成SHA256签名
     *
     * @param array $params 参数数组
     * @return string 签名结果
     */
    private function generateSHA256Signature(array $params): string
    {
        // 排序参数
        sort($params, SORT_STRING);
        
        // 拼接字符串
        $string = implode('', $params);
        
        // 生成SHA256签名
        return hash('sha256', $string);
    }

    /**
     * 签名登录
     *
     * @param string $acctId 账套ID
     * @param string $username 用户名
     * @param string $appId 应用ID
     * @param string $appSecret 应用密钥
     * @param int $lcid 语言ID，默认2052
     * @return string 响应结果
     * @throws HttpException
     */
    public function loginBySign(string $acctId, string $username, string $appId, string $appSecret, int $lcid = 2052): string
    {
        $url = $this->config->getServerUrl() . 'Kingdee.BOS.WebApi.ServicesStub.AuthService.LoginBySign.common.kdsvc';
        
        // 生成时间戳
        $timestamp = time();
        
        // 生成签名
        $signature = $this->generateSHA256Signature([
            $acctId,
            $username,
            $appId,
            $appSecret,
            (string)$timestamp
        ]);
        
        $postData = json_encode([
            'parameters' => [$acctId, $username, $appId, (string)$timestamp, $signature, $lcid]
        ]);

        $result = $this->httpClient->post($url, [], $postData, [], true);
        
        // 解析登录结果，提取会话ID
        $this->parseLoginResult($result);
        
        return $result;
    }

    /**
     * 解析登录结果，提取会话ID
     *
     * @param string $loginResult 登录结果JSON字符串
     */
    private function parseLoginResult(string $loginResult): void
    {
        try {
            $data = json_decode($loginResult, true);
            if ($data && isset($data['KDSVCSessionId'])) {
                $this->httpClient->setSessionId($data['KDSVCSessionId']);
            }
        } catch (\Exception $e) {
            // 忽略解析错误
        }
    }

    /**
     * 获取单点登录助手
     *
     * @return \Lizundao\K3CloudSDK\SSO\SSOHelper
     */
    public function getSSOHelper(): \Lizundao\K3CloudSDK\SSO\SSOHelper
    {
        return new \Lizundao\K3CloudSDK\SSO\SSOHelper($this->config);
    }
}
