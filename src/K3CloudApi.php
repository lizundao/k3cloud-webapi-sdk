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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.Save';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.Submit';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.Audit';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.Delete';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.ExecuteBillQuery';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.Allocate';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.CancelAllocate';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.BatchSave';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.UnAudit';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.View';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.Draft';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.ExcuteOperation';
        
        $postData = [
            'formid' => $formId,
            'op_number' => $opNumber,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.FlexSave';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.SendMsg';
        
        $postData = [
            'data' => is_array($data) ? json_encode($data) : $data
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.Push';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.GroupSave';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.Disassembly';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.QueryBusinessInfo';
        
        $postData = [
            'data' => is_array($data) ? json_encode($data) : $data
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.QueryGroupInfo';
        
        $postData = [
            'data' => is_array($data) ? json_encode($data) : $data
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.WorkflowAudit';
        
        $postData = [
            'data' => is_array($data) ? json_encode($data) : $data
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.GroupDelete';
        
        $postData = [
            'data' => is_array($data) ? json_encode($data) : $data
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.SwitchOrg';
        
        $postData = [
            'data' => is_array($data) ? json_encode($data) : $data
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.CancelAssign';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.GetSysReportData';
        
        $postData = [
            'formid' => $formId,
            'data' => json_encode($data)
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.AttachmentUpload';
        
        $postData = [
            'data' => is_array($data) ? json_encode($data) : $data
        ];

        return $this->httpClient->post($url, $postData);
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
        $url = $this->config->getServerUrl() . 'Kingdee.K3.SCM.WebApi.ServicesStub.DynamicFormService.AttachmentDownLoad';
        
        $postData = [
            'data' => is_array($data) ? json_encode($data) : $data
        ];

        return $this->httpClient->post($url, $postData);
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
}
