<?php

namespace DobbyWang\ToolBoxes\FileBoxes;

use DobbyWang\ToolBoxes\Exceptions\FileBoxException;

class AttachBox extends FileBoxAbstract implements FileBoxInterface
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
            // 儲存上傳原始檔案
            $hash_name = $this->put( $path , $file );

            $width  = null;
            $height = null;

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
