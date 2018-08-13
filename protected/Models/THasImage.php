<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Mvc\Application;

trait THasImage
{

    public function uploadImage($formFieldName)
    {
        $request = Application::getInstance()->request;

        if (!$request->existsFilesData() ||
            !$request->isUploaded($formFieldName) ||
            $request->isUploadedArray($formFieldName)
        ) {
            return $this;
        }

        try {
            $uploader = new Uploader($formFieldName);
            $uploader->setPath(self::IMAGE_UPLOAD_PATH);
            $image = $uploader();
            if ($this->{self::IMAGE_PROPERTY}) {
                $this->deleteImage();
            }

            $this->{self::IMAGE_PROPERTY} = $image;
        } catch (Exception $e) {
            $this->{self::IMAGE_PROPERTY} = null;
        }
        return $this;
    }

    public function deleteImage()
    {
        if ($this->{self::IMAGE_PROPERTY}) {
            try {
                Helpers::removeFile(ROOT_PATH_PUBLIC . $this->{self::IMAGE_PROPERTY});
                $this->{self::IMAGE_PROPERTY} = null;
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

}