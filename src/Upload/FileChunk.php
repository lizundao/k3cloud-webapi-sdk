<?php

namespace Lizundao\K3CloudSDK\Upload;

/**
 * 文件分块类
 */
class FileChunk
{
    /**
     * @var int 分块索引
     */
    private $chunkIndex;

    /**
     * @var string 分块数据
     */
    private $chunkData;

    /**
     * @var bool 是否为最后一块
     */
    private $isLast;

    /**
     * 构造函数
     *
     * @param int $chunkIndex 分块索引
     * @param string $chunkData 分块数据
     * @param bool $isLast 是否为最后一块
     */
    public function __construct(int $chunkIndex, string $chunkData, bool $isLast = false)
    {
        $this->chunkIndex = $chunkIndex;
        $this->chunkData = $chunkData;
        $this->isLast = $isLast;
    }

    /**
     * 获取分块索引
     *
     * @return int
     */
    public function getChunkIndex(): int
    {
        return $this->chunkIndex;
    }

    /**
     * 获取分块数据
     *
     * @return string
     */
    public function getChunkData(): string
    {
        return $this->chunkData;
    }

    /**
     * 是否为最后一块
     *
     * @return bool
     */
    public function isLast(): bool
    {
        return $this->isLast;
    }

    /**
     * 获取分块大小
     *
     * @return int
     */
    public function getChunkSize(): int
    {
        return strlen($this->chunkData);
    }
}
