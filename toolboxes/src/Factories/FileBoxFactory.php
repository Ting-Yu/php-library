<?php

namespace DobbyWang\ToolBoxes\FileBoxes;

use DobbyWang\ToolBoxes\Constants\FileBoxConstant;

class FileBoxFactory
{
    /**
     * @param $fileType
     *
     * @return FileBoxInterface
     */
    public static function setFileBox( $fileType )
    {
        switch ( $fileType ) {
            case FileBoxConstant::FILE_BOX_TYPE_ATTACH:
                return new AttachBox();
                break;
            case FileBoxConstant::FILE_BOX_TYPE_IMAGE:
                return new ImageBox();
                break;
            default:
                break;
        }
    }
}
