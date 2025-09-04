<?php

namespace Lizundao\K3CloudSDK\SSO;

use Lizundao\K3CloudSDK\Config\Config;

/**
 * 金蝶云星空单点登录助手类
 * 支持V1-V4版本的单点登录
 */
class SSOHelper
{
    /**
     * @var Config 配置对象
     */
    private $config;

    /**
     * @var array 单点登录参数
     */
    private $ssoParams = [];

    /**
     * @var array 单点登录URL对象
     */
    private $ssoLoginUrlObject = [];

    /**
     * @var string 时间戳
     */
    private $timestamp;

    /**
     * @var string 参数JSON
     */
    private $argJson;

    /**
     * @var string 参数Base64编码
     */
    private $argJsonBase64;

    /**
     * 构造函数
     *
     * @param Config $config 配置对象
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * 获取单点登录URL V4版本
     *
     * @param string $username 用户名
     * @return array 单点登录相关信息
     */
    public function getSsoUrlsV4(string $username): array
    {
        $this->timestamp = time();
        
        // 构建单点登录参数
        $this->ssoParams = [
            'dbid' => $this->config->getAcctId(),
            'appid' => $this->config->getAppId(),
            'username' => $username,
            'timestamp' => $this->timestamp,
            'signeddata' => $this->generateSignatureV4($username)
        ];

        $this->argJson = json_encode($this->ssoParams);
        $this->argJsonBase64 = base64_encode($this->argJson);

        // 构建各种入口链接
        $baseUrl = rtrim($this->config->getServerUrl(), '/');
        $this->ssoLoginUrlObject = [
            'silverlightUrl' => $baseUrl . '/Silverlight/Login.aspx?arg=' . $this->argJsonBase64,
            'html5Url' => $baseUrl . '/HTML5/Login.aspx?arg=' . $this->argJsonBase64,
            'wpfUrl' => $baseUrl . '/WPF/Login.aspx?arg=' . $this->argJsonBase64
        ];

        return [
            'ssoParams' => $this->ssoParams,
            'ssoLoginUrlObject' => $this->ssoLoginUrlObject,
            'timestamp' => $this->timestamp,
            'argJson' => $this->argJson,
            'argJsonBase64' => $this->argJsonBase64
        ];
    }

    /**
     * 获取单点登录URL V3版本
     *
     * @param string $username 用户名
     * @return array 单点登录相关信息
     */
    public function getSsoUrlsV3(string $username): array
    {
        $this->timestamp = time();
        
        $this->ssoParams = [
            'dbid' => $this->config->getAcctId(),
            'appid' => $this->config->getAppId(),
            'username' => $username,
            'timestamp' => $this->timestamp,
            'signeddata' => $this->generateSignatureV3($username)
        ];

        $this->argJson = json_encode($this->ssoParams);
        $this->argJsonBase64 = base64_encode($this->argJson);

        $baseUrl = rtrim($this->config->getServerUrl(), '/');
        $this->ssoLoginUrlObject = [
            'silverlightUrl' => $baseUrl . '/Silverlight/Login.aspx?arg=' . $this->argJsonBase64,
            'html5Url' => $baseUrl . '/HTML5/Login.aspx?arg=' . $this->argJsonBase64,
            'wpfUrl' => $baseUrl . '/WPF/Login.aspx?arg=' . $this->argJsonBase64
        ];

        return [
            'ssoParams' => $this->ssoParams,
            'ssoLoginUrlObject' => $this->ssoLoginUrlObject,
            'timestamp' => $this->timestamp,
            'argJson' => $this->argJson,
            'argJsonBase64' => $this->argJsonBase64
        ];
    }

    /**
     * 获取单点登录URL V2版本
     *
     * @param string $username 用户名
     * @return array 单点登录相关信息
     */
    public function getSsoUrlsV2(string $username): array
    {
        $this->timestamp = time();
        
        $this->ssoParams = [
            'dbid' => $this->config->getAcctId(),
            'appid' => $this->config->getAppId(),
            'username' => $username,
            'timestamp' => $this->timestamp,
            'signeddata' => $this->generateSignatureV2($username)
        ];

        $this->argJson = json_encode($this->ssoParams);
        $this->argJsonBase64 = base64_encode($this->argJson);

        $baseUrl = rtrim($this->config->getServerUrl(), '/');
        $this->ssoLoginUrlObject = [
            'silverlightUrl' => $baseUrl . '/Silverlight/Login.aspx?arg=' . $this->argJsonBase64,
            'html5Url' => $baseUrl . '/HTML5/Login.aspx?arg=' . $this->argJsonBase64,
            'wpfUrl' => $baseUrl . '/WPF/Login.aspx?arg=' . $this->argJsonBase64
        ];

        return [
            'ssoParams' => $this->ssoParams,
            'ssoLoginUrlObject' => $this->ssoLoginUrlObject,
            'timestamp' => $this->timestamp,
            'argJson' => $this->argJson,
            'argJsonBase64' => $this->argJsonBase64
        ];
    }

    /**
     * 获取单点登录URL V1版本
     *
     * @param string $username 用户名
     * @return array 单点登录相关信息
     */
    public function getSsoUrlsV1(string $username): array
    {
        $this->timestamp = time();
        
        $this->ssoParams = [
            'dbid' => $this->config->getAcctId(),
            'appid' => $this->config->getAppId(),
            'username' => $username,
            'timestamp' => $this->timestamp,
            'signeddata' => $this->generateSignatureV1($username)
        ];

        $this->argJson = json_encode($this->ssoParams);
        $this->argJsonBase64 = base64_encode($this->argJson);

        $baseUrl = rtrim($this->config->getServerUrl(), '/');
        $this->ssoLoginUrlObject = [
            'silverlightUrl' => $baseUrl . '/Silverlight/Login.aspx?arg=' . $this->argJsonBase64,
            'html5Url' => $baseUrl . '/HTML5/Login.aspx?arg=' . $this->argJsonBase64,
            'wpfUrl' => $baseUrl . '/WPF/Login.aspx?arg=' . $this->argJsonBase64
        ];

        return [
            'ssoParams' => $this->ssoParams,
            'ssoLoginUrlObject' => $this->ssoLoginUrlObject,
            'timestamp' => $this->timestamp,
            'argJson' => $this->argJson,
            'argJsonBase64' => $this->argJsonBase64
        ];
    }

    /**
     * 生成V4版本签名
     *
     * @param string $username 用户名
     * @return string 签名
     */
    private function generateSignatureV4(string $username): string
    {
        $data = $this->config->getAcctId() . $this->config->getAppId() . $username . $this->timestamp;
        return hash_hmac('sha256', $data, $this->config->getAppSecret());
    }

    /**
     * 生成V3版本签名
     *
     * @param string $username 用户名
     * @return string 签名
     */
    private function generateSignatureV3(string $username): string
    {
        $data = $this->config->getAcctId() . $this->config->getAppId() . $username . $this->timestamp;
        return hash_hmac('sha1', $data, $this->config->getAppSecret());
    }

    /**
     * 生成V2版本签名
     *
     * @param string $username 用户名
     * @return string 签名
     */
    private function generateSignatureV2(string $username): string
    {
        $data = $this->config->getAcctId() . $this->config->getAppId() . $username . $this->timestamp;
        return md5($data . $this->config->getAppSecret());
    }

    /**
     * 生成V1版本签名
     *
     * @param string $username 用户名
     * @return string 签名
     */
    private function generateSignatureV1(string $username): string
    {
        $data = $this->config->getAcctId() . $this->config->getAppId() . $username . $this->timestamp;
        return md5($data);
    }

    /**
     * 获取数据中心ID
     *
     * @return string
     */
    public function getDbid(): string
    {
        return $this->ssoParams['dbid'] ?? '';
    }

    /**
     * 获取应用ID
     *
     * @return string
     */
    public function getAppid(): string
    {
        return $this->ssoParams['appid'] ?? '';
    }

    /**
     * 获取用户名称
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->ssoParams['username'] ?? '';
    }

    /**
     * 获取时间戳
     *
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp ?? '';
    }

    /**
     * 获取签名
     *
     * @return string
     */
    public function getSigneddata(): string
    {
        return $this->ssoParams['signeddata'] ?? '';
    }

    /**
     * 获取请求参数（JSON格式）
     *
     * @return string
     */
    public function getArgJson(): string
    {
        return $this->argJson ?? '';
    }

    /**
     * 获取参数格式化（Base64）
     *
     * @return string
     */
    public function getArgJsonBase64(): string
    {
        return $this->argJsonBase64 ?? '';
    }

    /**
     * 获取Silverlight入口链接
     *
     * @return string
     */
    public function getSilverlightUrl(): string
    {
        return $this->ssoLoginUrlObject['silverlightUrl'] ?? '';
    }

    /**
     * 获取HTML5入口链接
     *
     * @return string
     */
    public function getHtml5Url(): string
    {
        return $this->ssoLoginUrlObject['html5Url'] ?? '';
    }

    /**
     * 获取客户端入口链接
     *
     * @return string
     */
    public function getWpfUrl(): string
    {
        return $this->ssoLoginUrlObject['wpfUrl'] ?? '';
    }
}
