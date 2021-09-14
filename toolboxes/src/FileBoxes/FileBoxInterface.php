<?php

namespace DobbyWang\ToolBoxes\FileBoxes;

interface FileBoxInterface
{
    /**
     * 上傳檔案(圖片)
     *
     * @param  object  $file
     * @param  string  $path
     * @param  bool    $isValid
     *
     * @return mixed
     */
    public function uploadFile( object $file , string $path , $isValid = true );

    /**
     * 檔案(圖片)比例縮放
     *
     * @param  array  $originSize  ( width => int , height => int )
     * @param  array  $setSize     ( width => int | null , height => int | null )
     */
    public function resizeFile( array $originSize , array $setSize );

    /**
     * 預覽檔案(圖片)處理
     *
     * @param  array  $setSize
     *
     * @return mixed
     */
    public function previewFile( array $setSize );

    /**
     * 快取檔案(圖片)處理
     *
     * @param  array  $setSize
     *
     * @return mixed
     */
    public function cacheFile( array $setSize );

    /**
     * 透過連結下載檔案(圖片)
     *
     * @param  array  $urls
     *
     * @return mixed
     */
    public function downloadFileByLink( array $urls );
}
