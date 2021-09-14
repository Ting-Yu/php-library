<?php

namespace DobbyWang\ToolBoxes\FileBoxes;

use DobbyWang\ToolBoxes\Exceptions\FileBoxException;
use Ramsey\Uuid\Uuid;

abstract class FileBoxAbstract
{
    /*
     * 儲存資料格式
     */
    protected $extra = [];

    /**
     * FileBoxAbstract constructor.
     */
    public function __construct()
    {
        $this->extra = [
            'uuid'          => Uuid::uuid4() ,
            'original_name' => '' ,
            'mime_type'     => '' ,
            'width'         => '' ,
            'height'        => '' ,
            'size'          => '' ,
            'hash_name'     => '' ,
            'process_msg'   => '' ,
            'created_at'    => date( 'Y-m-d H:i:s' ) ,
        ];
    }

    /**
     * 切割 hash_name 並保留檔名
     *
     * @param $profile
     *
     * @return string|string[]
     */
    protected function splitHashName( $profile )
    {
        $hash_name = null;
        if ( isset( $profile['hash_name'] ) ) {
            // 取哈希名稱，APP快取辨識用
            $hash_name = basename( $profile['hash_name'] );
            $hash_name = preg_replace( '/\\.[^.\\s]{3,4}$/' , '' , $hash_name );
        }
        return $hash_name;
    }

    /**
     * Write the contents of a file.
     *
     * @param  string  $path
     * @param  string  $contents
     * @param  bool    $lock
     *
     * @return int|bool
     */
    protected function put( $path , $contents , $lock = false )
    {
        return file_put_contents( $path , $contents , $lock ? LOCK_EX : 0 );
    }

    /**
     * Get the contents of a file.
     *
     * @param        $path
     * @param  bool  $lock
     *
     * @return false|string
     * @throws FileBoxException
     */
    public function get( $path , $lock = false )
    {
        if ( $this->isFile( $path ) ) {
            return $lock ? $this->sharedGet( $path ) : file_get_contents( $path );
        }

        throw new FileBoxException( "File does not exist at path {$path}." );
    }

    protected function sharedGet( $path )
    {
        $contents = '';

        $handle = fopen( $path , 'rb' );

        if ( $handle ) {
            try {
                if ( flock( $handle , LOCK_SH ) ) {
                    clearstatcache( true , $path );

                    $contents = fread( $handle , $this->size( $path ) ? : 1 );

                    flock( $handle , LOCK_UN );
                }
            } finally {
                fclose( $handle );
            }
        }

        return $contents;
    }

    /**
     * Get the file type of a given file.
     *
     * @param  string  $path
     *
     * @return string
     */
    protected function type( $path )
    {
        return filetype( $path );
    }

    /**
     * Get the file size of a given file.
     *
     * @param  string  $path
     *
     * @return int
     */
    protected function size( $path )
    {
        return filesize( $path );
    }

    /**
     * Get the file's last modification time.
     *
     * @param  string  $path
     *
     * @return int
     */
    protected function lastModified( $path )
    {
        return filemtime( $path );
    }

    /**
     * Determine if the given path is a directory.
     *
     * @param  string  $directory
     *
     * @return bool
     */
    protected function isDirectory( $directory )
    {
        return is_dir( $directory );
    }

    /**
     * Determine if the given path is readable.
     *
     * @param  string  $path
     *
     * @return bool
     */
    protected function isReadable( $path )
    {
        return is_readable( $path );
    }

    /**
     * Determine if the given path is writable.
     *
     * @param  string  $path
     *
     * @return bool
     */
    protected function isWritable( $path )
    {
        return is_writable( $path );
    }

    /**
     * Determine if the given path is a file.
     *
     * @param  string  $file
     *
     * @return bool
     */
    protected function isFile( $file )
    {
        return is_file( $file );
    }

    /**
     * Find path names matching a given pattern.
     *
     * @param  string  $pattern
     * @param  int     $flags
     *
     * @return array
     */
    protected function glob( $pattern , $flags = 0 )
    {
        return glob( $pattern , $flags );
    }
}
