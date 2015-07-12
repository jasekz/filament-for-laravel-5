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
            $thumbSource = $movedFileDir . '/thumb_' . $movedFileName;
            
            $object = $destination . '/' . $movedFileName;
            $thumbObject = $destination . '/thumb_' . $movedFileName;
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
}
