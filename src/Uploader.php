<?php
namespace ArnaudTriolet\Crudite;

class Uploader
{
    static public function upload($file, $dest, $filename = "") 
    {
        if (!is_null($file)) {
            $fileOrig = $file->getClientOriginalName();
            $ext = pathinfo($fileOrig, PATHINFO_EXTENSION);
            $base = pathinfo($fileOrig, PATHINFO_FILENAME);
            if (!empty($fileOrig)) {
                if (!empty($filename)) {
                    $newName = "$filename.$ext";
                } else {
                    $newName = $base . "-" . time() . ".$ext";
                }
                $dest = rtrim($dest, "/");
                try {
                    $data = $file->storeAs($dest, $newName, "public");
                    $fileUrl = asset("storage/" . $dest . "/" . $newName);
                } catch (\Throwable $th) {
                    throw $th;
                }

                return $fileUrl;
            }
        }
        return null;
    }
}
