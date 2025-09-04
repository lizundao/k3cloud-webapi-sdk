<?php

namespace Lizundao\K3CloudSDK\Upload;

use Lizundao\K3CloudSDK\K3CloudApi;
use Lizundao\K3CloudSDK\Exception\HttpException;

/**
 * 附件上传助手类
 * 支持分块上传功能
 */
class AttachmentHelper
{
    /**
     * 通过文件路径上传附件（直接返回最终结果）
     *
     * @param string $filePath 文件路径
     * @param K3CloudApi $api API实例
     * @param UploadModel $uploadModel 上传模型
     * @param int $chunkSize 分块大小，默认2MB
     * @return string 上传结果
     * @throws HttpException
     */
    public static function attachmentUploadByFilePath(
        string $filePath, 
        K3CloudApi $api, 
        UploadModel $uploadModel, 
        int $chunkSize = 2097152
    ): string {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("文件不存在: {$filePath}");
        }

        $fileSize = filesize($filePath);
        $fileName = basename($filePath);
        $fileContent = file_get_contents($filePath);
        $fileBase64 = base64_encode($fileContent);

        return self::attachmentUploadByBase64($fileBase64, $fileName, $fileSize, $api, $uploadModel, $chunkSize);
    }

    /**
     * 通过Base64流上传附件（直接返回最终结果）
     *
     * @param string $fileBase64 Base64编码的文件内容
     * @param string $fileName 文件名
     * @param int $fileSize 文件大小
     * @param K3CloudApi $api API实例
     * @param UploadModel $uploadModel 上传模型
     * @param int $chunkSize 分块大小，默认2MB
     * @return string 上传结果
     * @throws HttpException
     */
    public static function attachmentUploadByBase64(
        string $fileBase64,
        string $fileName,
        int $fileSize,
        K3CloudApi $api,
        UploadModel $uploadModel,
        int $chunkSize = 2097152
    ): string {
        $totalChunks = ceil($fileSize / $chunkSize);
        $fileId = '';

        for ($i = 0; $i < $totalChunks; $i++) {
            $start = $i * $chunkSize;
            $end = min($start + $chunkSize, $fileSize);
            $chunkData = substr($fileBase64, $start, $end - $start);
            $isLast = ($i === $totalChunks - 1);

            $uploadData = [
                'FileName' => $fileName,
                'FEntryKey' => '',
                'FormId' => $uploadModel->getFormId(),
                'IsLast' => $isLast,
                'InterId' => $uploadModel->getInterId(),
                'BillNO' => $uploadModel->getBillNO(),
                'AliasFileName' => $uploadModel->getAliasFileName(),
                'SendByte' => $chunkData
            ];

            if ($fileId) {
                $uploadData['FileId'] = $fileId;
            }

            $result = $api->attachmentUpload($uploadData);
            $resultData = json_decode($result, true);

            if ($resultData && isset($resultData['Result']['ResponseStatus']['IsSuccess']) && 
                $resultData['Result']['ResponseStatus']['IsSuccess']) {
                
                if (isset($resultData['Result']['FileId'])) {
                    $fileId = $resultData['Result']['FileId'];
                }
            } else {
                throw new HttpException("分块上传失败: " . $result);
            }
        }

        return $result;
    }

    /**
     * 通过文件路径上传附件（获取完整的上传过程）
     *
     * @param string $filePath 文件路径
     * @param K3CloudApi $api API实例
     * @param UploadModel $uploadModel 上传模型
     * @param int $chunkSize 分块大小，默认2MB
     * @param callable|null $progressCallback 进度回调函数
     * @return string 上传结果
     * @throws HttpException
     */
    public static function attachmentUploadByFilePathWithProgress(
        string $filePath,
        K3CloudApi $api,
        UploadModel $uploadModel,
        int $chunkSize = 2097152,
        callable $progressCallback = null
    ): string {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("文件不存在: {$filePath}");
        }

        $fileSize = filesize($filePath);
        $fileName = basename($filePath);
        $fileContent = file_get_contents($filePath);
        $fileBase64 = base64_encode($fileContent);

        return self::attachmentUploadByBase64WithProgress(
            $fileBase64, 
            $fileName, 
            $fileSize, 
            $api, 
            $uploadModel, 
            $chunkSize, 
            $progressCallback
        );
    }

    /**
     * 通过Base64流上传附件（获取完整的上传过程）
     *
     * @param string $fileBase64 Base64编码的文件内容
     * @param string $fileName 文件名
     * @param int $fileSize 文件大小
     * @param K3CloudApi $api API实例
     * @param UploadModel $uploadModel 上传模型
     * @param int $chunkSize 分块大小，默认2MB
     * @param callable|null $progressCallback 进度回调函数
     * @return string 上传结果
     * @throws HttpException
     */
    public static function attachmentUploadByBase64WithProgress(
        string $fileBase64,
        string $fileName,
        int $fileSize,
        K3CloudApi $api,
        UploadModel $uploadModel,
        int $chunkSize = 2097152,
        callable $progressCallback = null
    ): string {
        $totalChunks = ceil($fileSize / $chunkSize);
        $fileId = '';

        for ($i = 0; $i < $totalChunks; $i++) {
            $start = $i * $chunkSize;
            $end = min($start + $chunkSize, $fileSize);
            $chunkData = substr($fileBase64, $start, $end - $start);
            $isLast = ($i === $totalChunks - 1);

            $uploadData = [
                'FileName' => $fileName,
                'FEntryKey' => '',
                'FormId' => $uploadModel->getFormId(),
                'IsLast' => $isLast,
                'InterId' => $uploadModel->getInterId(),
                'BillNO' => $uploadModel->getBillNO(),
                'AliasFileName' => $uploadModel->getAliasFileName(),
                'SendByte' => $chunkData
            ];

            if ($fileId) {
                $uploadData['FileId'] = $fileId;
            }

            $result = $api->attachmentUpload($uploadData);
            $resultData = json_decode($result, true);

            // 调用进度回调
            if ($progressCallback) {
                $chunk = new FileChunk($i, $chunkData, $isLast);
                $progressCallback($chunk, $api);
            }

            if ($resultData && isset($resultData['Result']['ResponseStatus']['IsSuccess']) && 
                $resultData['Result']['ResponseStatus']['IsSuccess']) {
                
                if (isset($resultData['Result']['FileId'])) {
                    $fileId = $resultData['Result']['FileId'];
                }
            } else {
                throw new HttpException("分块上传失败: " . $result);
            }
        }

        return $result;
    }
}
