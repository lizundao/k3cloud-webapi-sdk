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
     * @param array $headers 请求头
     * @return string 响应内容
     * @throws HttpException
     */
    public function post(string $url, array $data = [], array $headers = []): string
    {
        $this->setRequestHeaders($headers);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        
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
     * 设置请求头
     *
     * @param array $headers 请求头数组
     */
    private function setRequestHeaders(array $headers): void
    {
        $defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-KDApi-AcctID: ' . $this->config->getAcctId(),
            'X-KDApi-UserName: ' . $this->config->getUsername(),
            'X-KDApi-AppID: ' . $this->config->getAppId(),
            'X-KDApi-AppSec: ' . $this->config->getAppSecret(),
            'X-KDApi-LCID: ' . $this->config->getLcid(),
            'X-KDApi-OrgNum: ' . $this->config->getOrgNum()
        ];

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
            throw new HttpException("HTTP错误 {$httpCode}: {$response}");
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
