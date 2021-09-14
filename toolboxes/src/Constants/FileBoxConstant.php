<?php

namespace DobbyWang\ToolBoxes\Constants;

class FileBoxConstant
{
    //附加檔案
    const FILE_BOX_TYPE_ATTACH = 'attach';
    //圖檔
    const FILE_BOX_TYPE_IMAGE = 'image';

    const IMAGE_JPEG    = 'image/jpeg';
    const IMAGE_GIF     = 'image/gif';
    const IMAGE_PNG     = 'image/png';
    const IMAGE_BMP     = 'image/bmp';
    const IMAGE_SVG_XML = 'image/svg+xml';

    static $imageMimeTypeEnum = [
        self::IMAGE_JPEG ,
        self::IMAGE_GIF ,
        self::IMAGE_PNG ,
        self::IMAGE_BMP ,
        self::IMAGE_SVG_XML ,
    ];
}
