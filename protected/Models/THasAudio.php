<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Html\Helpers;
use T4\Http\Uploader;
use T4\Mvc\Application;

trait THasAudio
{

    public function uploadAudio($formFieldName)
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
            $uploader->setPath(self::AUDIO_UPLOAD_PATH);
            $file = $uploader();

            if ($this->{self::AUDIO_PROPERTY}) {
                $this->deleteFile();
            }
            $this->{self::AUDIO_PROPERTY} = $file;
        } catch (Exception $e) {
            $this->{self::AUDIO_PROPERTY} = null;
        }
        return $this;
    }

    public function deleteAudio()
    {
        if ($this->{self::AUDIO_PROPERTY}) {
            try {
                \T4\Fs\Helpers::removeFile(ROOT_PATH_PUBLIC . $this->{self::AUDIO_PROPERTY});
                $this->{self::AUDIO_PROPERTY} = null;
            } catch (\T4\Fs\Exception $e) {
                return false;
            }
        }
        return true;
    }

}