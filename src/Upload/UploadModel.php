<?php

namespace Lizundao\K3CloudSDK\Upload;

/**
 * 文件上传模型
 */
class UploadModel
{
    /**
     * @var string 表单ID
     */
    private $formId;

    /**
     * @var string 内部ID
     */
    private $interId;

    /**
     * @var string 单据编号
     */
    private $billNO;

    /**
     * @var string 别名文件名
     */
    private $aliasFileName;

    /**
     * 构造函数
     *
     * @param string $formId 表单ID
     * @param string $interId 内部ID
     * @param string $billNO 单据编号
     * @param string $aliasFileName 别名文件名
     */
    public function __construct(string $formId = '', string $interId = '', string $billNO = '', string $aliasFileName = '')
    {
        $this->formId = $formId;
        $this->interId = $interId;
        $this->billNO = $billNO;
        $this->aliasFileName = $aliasFileName;
    }

    /**
     * 获取表单ID
     *
     * @return string
     */
    public function getFormId(): string
    {
        return $this->formId;
    }

    /**
     * 设置表单ID
     *
     * @param string $formId
     * @return self
     */
    public function setFormId(string $formId): self
    {
        $this->formId = $formId;
        return $this;
    }

    /**
     * 获取内部ID
     *
     * @return string
     */
    public function getInterId(): string
    {
        return $this->interId;
    }

    /**
     * 设置内部ID
     *
     * @param string $interId
     * @return self
     */
    public function setInterId(string $interId): self
    {
        $this->interId = $interId;
        return $this;
    }

    /**
     * 获取单据编号
     *
     * @return string
     */
    public function getBillNO(): string
    {
        return $this->billNO;
    }

    /**
     * 设置单据编号
     *
     * @param string $billNO
     * @return self
     */
    public function setBillNO(string $billNO): self
    {
        $this->billNO = $billNO;
        return $this;
    }

    /**
     * 获取别名文件名
     *
     * @return string
     */
    public function getAliasFileName(): string
    {
        return $this->aliasFileName;
    }

    /**
     * 设置别名文件名
     *
     * @param string $aliasFileName
     * @return self
     */
    public function setAliasFileName(string $aliasFileName): self
    {
        $this->aliasFileName = $aliasFileName;
        return $this;
    }
}
