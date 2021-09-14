<?php

namespace DobbyWang\ToolBoxes\FileBoxes;

class FileBoxService
{
    /**
     * 使用檔案類型
     *
     * @param  string  $fileType
     *
     * @return FileBoxInterface
     */
    public function useFileBoxType( string $fileType )
    {
        return FileBoxFactory::setFileBox( $fileType );
    }
}
