<?php

namespace Lizundao\K3CloudSDK\Config;

/**
 * 金蝶K3Cloud配置类
 */
class Config
{
    /**
     * @var array 配置数组
     */
    private $config = [];

    /**
     * @var array 默认配置
     */
    private $defaults = [
        'lcid' => 2052,
        'org_num' => '100',
        'connect_timeout' => 360,
        'request_timeout' => 360,
        'proxy' => null
    ];

    /**
     * 构造函数
     *
     * @param array $config 配置数组
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->defaults, $config);
        $this->validate();
    }

    /**
     * 从INI文件加载配置
     *
     * @param string $filePath INI文件路径
     * @return static
     * @throws \InvalidArgumentException
     */
    public static function fromIni(string $filePath): self
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("配置文件不存在: {$filePath}");
        }

        $iniData = parse_ini_file($filePath, true);
        if ($iniData === false) {
            throw new \InvalidArgumentException("无法解析INI文件: {$filePath}");
        }

        $config = [];
        if (isset($iniData['config'])) {
            $config = $iniData['config'];
        }

        // 映射INI配置到类属性
        $mapping = [
            'X-KDApi-AcctID' => 'acct_id',
            'X-KDApi-UserName' => 'username',
            'X-KDApi-AppID' => 'app_id',
            'X-KDApi-AppSec' => 'app_secret',
            'X-KDApi-ServerUrl' => 'server_url',
            'X-KDApi-LCID' => 'lcid',
            'X-KDApi-OrgNum' => 'org_num',
            'X-KDApi-ConnectTimeout' => 'connect_timeout',
            'X-KDApi-RequestTimeout' => 'request_timeout',
            'X-KDApi-Proxy' => 'proxy'
        ];

        foreach ($mapping as $iniKey => $configKey) {
            if (isset($config[$iniKey])) {
                $config[$configKey] = $config[$iniKey];
            }
        }

        return new self($config);
    }

    /**
     * 获取配置值
     *
     * @param string $key 配置键
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * 设置配置值
     *
     * @param string $key 配置键
     * @param mixed $value 配置值
     * @return $this
     */
    public function set(string $key, $value): self
    {
        $this->config[$key] = $value;
        return $this;
    }

    /**
     * 获取所有配置
     *
     * @return array
     */
    public function all(): array
    {
        return $this->config;
    }

    /**
     * 获取服务器URL
     *
     * @return string
     */
    public function getServerUrl(): string
    {
        return $this->config['server_url'];
    }

    /**
     * 获取账套ID
     *
     * @return string
     */
    public function getAcctId(): string
    {
        return $this->config['acct_id'];
    }

    /**
     * 获取用户名
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->config['username'];
    }

    /**
     * 获取应用ID
     *
     * @return string
     */
    public function getAppId(): string
    {
        return $this->config['app_id'];
    }

    /**
     * 获取应用密钥
     *
     * @return string
     */
    public function getAppSecret(): string
    {
        return $this->config['app_secret'];
    }

    /**
     * 获取语系ID
     *
     * @return int
     */
    public function getLcid(): int
    {
        return $this->config['lcid'];
    }

    /**
     * 获取组织编码
     *
     * @return string
     */
    public function getOrgNum(): string
    {
        return $this->config['org_num'];
    }

    /**
     * 获取连接超时时间
     *
     * @return int
     */
    public function getConnectTimeout(): int
    {
        return $this->config['connect_timeout'];
    }

    /**
     * 获取请求超时时间
     *
     * @return int
     */
    public function getRequestTimeout(): int
    {
        return $this->config['request_timeout'];
    }

    /**
     * 获取代理设置
     *
     * @return string|null
     */
    public function getProxy(): ?string
    {
        return $this->config['proxy'];
    }

    /**
     * 验证配置
     *
     * @throws \InvalidArgumentException
     */
    private function validate(): void
    {
        $required = ['server_url', 'acct_id', 'username', 'app_id', 'app_secret'];
        
        foreach ($required as $field) {
            if (empty($this->config[$field])) {
                throw new \InvalidArgumentException("配置项 '{$field}' 不能为空");
            }
        }

        // 验证服务器URL格式
        if (!filter_var($this->config['server_url'], FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("无效的服务器URL: {$this->config['server_url']}");
        }

        // 确保服务器URL以/k3cloud/结尾
        if (!preg_match('/\/k3cloud\/?$/', $this->config['server_url'])) {
            $this->config['server_url'] = rtrim($this->config['server_url'], '/') . '/k3cloud/';
        }
    }
}
