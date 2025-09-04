<?php

namespace Lizundao\K3CloudSDK\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Lizundao\K3CloudSDK\Config\Config;

class ConfigTest extends TestCase
{
    public function testConfigCreationWithValidData()
    {
        $configData = [
            'server_url' => 'https://test.com/k3cloud/',
            'acct_id' => 'test123',
            'username' => 'testuser',
            'app_id' => 'testapp',
            'app_secret' => 'testsecret'
        ];

        $config = new Config($configData);

        $this->assertEquals('https://test.com/k3cloud/', $config->getServerUrl());
        $this->assertEquals('test123', $config->getAcctId());
        $this->assertEquals('testuser', $config->getUsername());
        $this->assertEquals('testapp', $config->getAppId());
        $this->assertEquals('testsecret', $config->getAppSecret());
        $this->assertEquals(2052, $config->getLcid()); // 默认值
        $this->assertEquals('100', $config->getOrgNum()); // 默认值
    }

    public function testConfigCreationWithMissingRequiredFields()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $configData = [
            'server_url' => 'https://test.com/k3cloud/',
            // 缺少必填字段
        ];

        new Config($configData);
    }

    public function testConfigCreationWithInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $configData = [
            'server_url' => 'invalid-url',
            'acct_id' => 'test123',
            'username' => 'testuser',
            'app_id' => 'testapp',
            'app_secret' => 'testsecret'
        ];

        new Config($configData);
    }

    public function testConfigUrlNormalization()
    {
        $configData = [
            'server_url' => 'https://test.com',
            'acct_id' => 'test123',
            'username' => 'testuser',
            'app_id' => 'testapp',
            'app_secret' => 'testsecret'
        ];

        $config = new Config($configData);
        
        // 应该自动添加 /k3cloud/ 后缀
        $this->assertEquals('https://test.com/k3cloud/', $config->getServerUrl());
    }

    public function testConfigGetters()
    {
        $configData = [
            'server_url' => 'https://test.com/k3cloud/',
            'acct_id' => 'test123',
            'username' => 'testuser',
            'app_id' => 'testapp',
            'app_secret' => 'testsecret',
            'lcid' => 1033,
            'org_num' => '200',
            'connect_timeout' => 180,
            'request_timeout' => 180
        ];

        $config = new Config($configData);

        $this->assertEquals(1033, $config->getLcid());
        $this->assertEquals('200', $config->getOrgNum());
        $this->assertEquals(180, $config->getConnectTimeout());
        $this->assertEquals(180, $config->getRequestTimeout());
    }

    public function testConfigSetMethod()
    {
        $config = new Config([
            'server_url' => 'https://test.com/k3cloud/',
            'acct_id' => 'test123',
            'username' => 'testuser',
            'app_id' => 'testapp',
            'app_secret' => 'testsecret'
        ]);

        $config->set('custom_field', 'custom_value');
        $this->assertEquals('custom_value', $config->get('custom_field'));
    }

    public function testConfigAllMethod()
    {
        $configData = [
            'server_url' => 'https://test.com/k3cloud/',
            'acct_id' => 'test123',
            'username' => 'testuser',
            'app_id' => 'testapp',
            'app_secret' => 'testsecret'
        ];

        $config = new Config($configData);
        $allConfig = $config->all();

        $this->assertArrayHasKey('server_url', $allConfig);
        $this->assertArrayHasKey('acct_id', $allConfig);
        $this->assertArrayHasKey('username', $allConfig);
        $this->assertArrayHasKey('app_id', $allConfig);
        $this->assertArrayHasKey('app_secret', $allConfig);
    }
}
