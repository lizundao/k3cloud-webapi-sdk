<?php

namespace Lizundao\K3CloudSDK\Http;

use Lizundao\K3CloudSDK\Config\Config;
use Lizundao\K3CloudSDK\Exception\HttpException;

/**
 * HTTP客户端类
 */
class HttpClient
{
    /**
     * @var Config 配置对象
     */
    private $config;

    /**
     * @var resource|\CurlHandle cURL句柄
     */
    private $ch;

    /**
     * @var string|null 会话ID
     */
    private $sessionId;

    /**
     * 构造函数
     *
     * @param Config $config 配置对象
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->initCurl();
    }

    /**
     * 初始化cURL
     */
    private function initCurl(): void
    {
        $this->ch = curl_init();
        
        // 设置基本选项
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        
        // 设置超时
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->config->getConnectTimeout());
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->config->getRequestTimeout());
        
        // 设置代理
        if ($proxy = $this->config->getProxy()) {
            curl_setopt($this->ch, CURLOPT_PROXY, $proxy);
        }
    }

    /**
     * 发送POST请求
     *
     * @param string $url 请求URL
     * @param array $data 请求数据
     * @param string|array $postData 原始POST数据
     * @param array $headers 请求头
     * @param bool $skipAuth 是否跳过自动添加认证头
     * @return string 响应内容
     * @throws HttpException
     */
    public function post(string $url, array $data = [], $postData = null, array $headers = [], bool $skipAuth = false): string
    {
        $this->setRequestHeaders($headers, $skipAuth);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        
        if ($postData !== null) {
            // 使用原始POST数据
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postData);
        } else {
            // 使用数组数据，转换为JSON
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = $this->execute();
        $this->checkResponse($response);
        
        return $response;
    }

    /**
     * 发送GET请求
     *
     * @param string $url 请求URL
     * @param array $headers 请求头
     * @return string 响应内容
     * @throws HttpException
     */
    public function get(string $url, array $headers = []): string
    {
        $this->setRequestHeaders($headers);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        
        $response = $this->execute();
        $this->checkResponse($response);
        
        return $response;
    }

    /**
     * 设置会话ID
     *
     * @param string $sessionId 会话ID
     */
    public function setSessionId(string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    /**
     * 获取会话ID
     *
     * @return string|null
     */
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    /**
     * 设置请求头
     *
     * @param array $headers 请求头数组
     * @param bool $skipAuth 是否跳过自动添加认证头
     */
    private function setRequestHeaders(array $headers, bool $skipAuth = false): void
    {
        $defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        // 如果不是登录接口，添加认证头
        if (!$skipAuth) {
            $authHeaders = [
                'X-KDApi-AcctID: ' . $this->config->getAcctId(),
                'X-KDApi-UserName: ' . $this->config->getUsername(),
                'X-KDApi-AppID: ' . $this->config->getAppId(),
                'X-KDApi-AppSec: ' . $this->config->getAppSecret(),
                'X-KDApi-LCID: ' . $this->config->getLcid(),
                'X-KDApi-OrgNum: ' . $this->config->getOrgNum()
            ];
            
            // 如果有会话ID，添加会话头
            if ($this->sessionId) {
                $authHeaders[] = 'kdservice-sessionid: ' . $this->sessionId;
            }
            
            $defaultHeaders = array_merge($defaultHeaders, $authHeaders);
        }

        $allHeaders = array_merge($defaultHeaders, $headers);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $allHeaders);
    }

    /**
     * 执行cURL请求
     *
     * @return string
     * @throws HttpException
     */
    private function execute(): string
    {
        $response = curl_exec($this->ch);
        
        if ($response === false) {
            $error = curl_error($this->ch);
            $errno = curl_errno($this->ch);
            throw new HttpException("cURL错误 ({$errno}): {$error}");
        }
        
        return $response;
    }

    /**
     * 检查响应
     *
     * @param string $response 响应内容
     * @throws HttpException
     */
    private function checkResponse(string $response): void
    {
        $httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        
        if ($httpCode >= 400) {
            throw new HttpException("HTTP错误 {$httpCode}: {$response}", $httpCode);
        }
        
        // 检查是否是HTML错误页面
        if (strpos($response, '<!DOCTYPE html>') !== false || strpos($response, '<html') !== false) {
            throw new HttpException("服务器返回HTML错误页面: {$response}", $httpCode);
        }
    }

    /**
     * 获取HTTP状态码
     *
     * @return int
     */
    public function getHttpCode(): int
    {
        return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }

    /**
     * 获取响应信息
     *
     * @return array
     */
    public function getInfo(): array
    {
        return curl_getinfo($this->ch);
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        if (is_resource($this->ch) || $this->ch instanceof \CurlHandle) {
            curl_close($this->ch);
        }
    }
}
