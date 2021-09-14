<?php

namespace DobbyWang\ToolBoxes\FileBoxes;

use DobbyWang\ToolBoxes\Constants\FileBoxConstant;
use DobbyWang\ToolBoxes\Exceptions\FileBoxException;
use Intervention\Image\Facades\Image;

class ImageBox extends FileBoxAbstract implements FileBoxInterface
{

    /**
     * @param  object  $file
     * @param  string  $path
     * @param  bool    $isValid
     *
     * @return array|mixed
     * @throws FileBoxException
     */
    public function uploadFile( object $file , string $path , $isValid = true )
    {

        $extra = $this->extra;

        $status = false;
        if ( $isValid && $file->isValid() ) {
            $status = true;
        }

        if ( !$isValid ) {
            $status = true;
        }

        if ( $status ) {
            // 儲存上傳原始圖檔
            $hash_name = $this->put( $path , $file );

            // 檔案存放完整路徑
            $file_path = $this->get( $hash_name );

            // 添加縮圖預先快取
            $file_cache = Image::cache( function ( $file ) use ( $file_path ) {
                return $file->make( $file_path )
                    ->resize( 100 , null , function ( $constraint ) {
                        $constraint->aspectRatio();
                    } )
                    ->orientate();
            } , 10080 );

            // 設定縮圖檔案名稱
            $thumbnail = basename( $hash_name );
            $thumbnail = preg_replace( '/\\.[^.\\s]{3,4}$/' , '' , $thumbnail );

            // 儲存預覽圖檔
            $this->put( str_replace( $thumbnail , $thumbnail . '.100.auto' , $hash_name ) , $file_cache );

            // 檢查圖片類型
            $isImage = in_array( $file->getMimeType() , FileBoxConstant::$imageMimeTypeEnum );

            if ( $isImage ) {
                $width  = Image::make( $file )->width();
                $height = Image::make( $file )->height();
            } else {
                $width  = null;
                $height = null;
            }


            $extra['original_name'] = urldecode( $file->getClientOriginalName() );
            $extra['mime_type']     = $file->getMimeType();
            $extra['width']         = $width;
            $extra['height']        = $height;
            $extra['size']          = $file->getSize();
            $extra['hash_name']     = $hash_name;
            return $extra;
        }

        throw new FileBoxException( "File does not exist at path {$path}." );
    }

    /**
     * @inheritDoc
     */
    public function resizeFile( array $originSize , array $setSize )
    {
        // TODO: Implement resizeFile() method.
    }

    /**
     * @inheritDoc
     */
    public function previewFile( array $setSize )
    {
        // TODO: Implement previewFile() method.
    }

    /**
     * @inheritDoc
     */
    public function cacheFile( array $setSize )
    {
        // TODO: Implement cacheFile() method.
    }

    /**
     * @inheritDoc
     */
    public function downloadFileByLink( array $urls )
    {
        // TODO: Implement downloadFileByLink() method.
    }
}
