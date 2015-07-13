<?php
namespace App\Services;

use App\Models\File as FileModel;
use Intervention\Image\ImageManagerStatic as Image;
use Request;
use Input;
use Config;
use Exception;

class File extends Base {

    protected $model = null;
    
    private $thumbPrefix = '__thumb__';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = new FileModel();
        $this->s3 = \App::make('aws')->get('s3');
        $this->bucket = Config::get('app.aws_file_bucket');
    }

    /**
     * Delete file from S3 and databse
     *
     * @param int $fileId            
     * @throws Exception
     */
    public function delete($fileId)
    {
        try {
            $file = FileModel::findOrFail($fileId);
            $keys = $this->getKeysFromURL($file->file);

            $result = $this->s3->deleteObjects(array(
                'Bucket' => $this->bucket,
                'Objects' => $keys               
            ));
            
            $file->delete();
        } 

        catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Creates thumbnail and uploads both full size image and thumbnail to storage server
     *
     * @param string $destination            
     * @throws Exception
     */
    public function store($destination)
    {
        if (! Request::hasFile('file')) {
            throw new Exception(trans('app.genericError'));
        }
        
        try {
            $fileName = md5(Input::file('file')->getClientOriginalName());
            $fileExt = Input::file('file')->getClientOriginalExtension();
            $mimeType = Request::file('file')->getMimeType();
            
            $movedFileDir = storage_path() . '/tmp';
            $movedFileName = $fileName . '.' . $fileExt;
            
            $movedFile = $movedFileDir . '/' . $movedFileName;
            $thumbSource = $movedFileDir . '/' . $this->thumbPrefix . $movedFileName;
            
            $object = $destination . '/' . $movedFileName;
            $thumbObject = $destination . '/' . $this->thumbPrefix . $movedFileName;
        } 

        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
        try {
            
            Request::file('file')->move($movedFileDir, $movedFileName);
            $img = Image::make($movedFile);
            $img->resize(150, 150);
            $img->save($thumbSource);
            
            $fileObject = $this->s3->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => $object,
                'SourceFile' => $movedFile,
                'ACL' => 'public-read',
                'ContentType' => $mimeType
            ));
            
            $thumbObject = $this->s3->putObject(array(
                'Bucket' => $this->bucket,
                'Key' => $thumbObject,
                'SourceFile' => $thumbSource,
                'ACL' => 'public-read',
                'ContentType' => $mimeType
            ));
            
            unlink($movedFile);
            unlink($thumbSource);
        } 

        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
        return FileModel::create([
            'file' => $thumbObject['ObjectURL']
        ]);
    }

    /**
     * Parse S3 url and return keys to file and thumb
     *
     * @param string $url            
     * @return array
     */
    private function getKeysFromURL($url)
    {
        $segments = explode('/', $url);
        
        for ($i = 0; $i < 3; $i ++) {
            unset($segments[$i]);
        }
        
        $thumb = array_pop($segments);
        $fileName = str_replace($this->thumbPrefix, '', $thumb);
        
        $path = implode('/', $segments);
        
        return [
            [ 'Key' => $path . '/' . $fileName ],
            [ 'Key' => $path . '/' . $thumb ]
        ];
    }
}
