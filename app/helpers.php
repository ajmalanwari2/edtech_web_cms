<?php

use Illuminate\Support\Str;



if (!function_exists('storeFiles')) {
    function storeFiles($request, $file_names, $document_id)
    {
        $path_array = [];
        foreach ($file_names as $type) {
            if ($request->hasFile($type)) {

                $path = 'storage/uploads/' . $type . '/';

                $extension = $request->file($type)->getClientOriginalExtension();
                if (in_array($extension, ['jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG'])) {
                    $fileName = $document_id . '-' . time() . '.' . $extension;
                    //create the folder if it does not exist
                    if (!file_exists(base_path() . '/storage/app/public/uploads/' . $type)) {
                        mkdir(base_path() . '/storage/app/public/uploads/' . $type, 0777, true);
                    }
                    //then move the file
                    $request->file($type)->move(
                        base_path() . '/storage/app/public/uploads/' . $type,
                        $fileName
                    );

                    $path_array[$type] = $path . $fileName;
                }else{
                    throw new \Exception('file type is not supported');
                }
            }else{
                throw new \Exception('there is not file attached');
            }
        }
        
        return $path_array;
    }
}



if (!function_exists('mulistoreFiles')) {
    function mulistoreFiles($request, $file_names, $folder_name, $document_id)
    {
        $path_array = [];
        foreach ($file_names as $type) {
            if ($request->hasFile($type)) {

                $path = 'storage/uploads/' . $folder_name . '/';

                $extension = $request->file($type)->getClientOriginalExtension();
                if (in_array($extension, ['jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG'])) {
                    $fileName = $document_id . '-' . time() . '.' . $extension;
                    //create the folder if it does not exist
                    if (!file_exists(base_path() . '/storage/app/public/uploads/' . $folder_name)) {
                        mkdir(base_path() . '/storage/app/public/uploads/' . $folder_name, 0777, true);
                    }
                    //then move the file
                    $request->file($type)->move(
                        base_path() . '/storage/app/public/uploads/'. $folder_name,
                        $fileName
                    );

                    $path_array[$type] = $path . $fileName;
                }else{
                    throw new \Exception('file type is not supported');
                }
            }else{
                throw new \Exception('there is not file attached');
            }
        }
        
        return $path_array;
    }
}


if (!function_exists('storePDFFiles')) {
    function storePDFFiles($request, $file_names, $document_id)
    {
        
        $path_array = [];
        foreach ($file_names as $type) {
            if ($request->hasFile($type)) {

                $path = 'storage/uploads/' . $type . '/';

                $extension = $request->file($type)->getClientOriginalExtension();
                $fileSize = $request->file($type)->getSize();
                if (in_array($extension, ['PDF', 'pdf'])) {
                    $file = $request->file($type);
                    $fileName = $document_id . '-' . time() . '.' . $extension;
                    //create the folder if it does not exist
                    if (!file_exists(base_path() . '/storage/app/public/uploads/' . $type)) {
                        mkdir(base_path() . '/storage/app/public/uploads/' . $type, 0777, true);
                    }
                    //then move the file
                    $file->move(
                        base_path() . '/storage/app/public/uploads/' . $type,
                        $fileName
                    );

                    $path_array[$type] = [
                        'path' => $path . $fileName,
                        'size' => $fileSize,
                    ];
                } else {
                    throw new \Exception('file type is not supported');
                }
            } else {
                throw new \Exception('there is no file attached');
            }
        }

        return $path_array;
    }
}



if (!function_exists('storeAudioFiles')) {
    function storeAudioFiles($request, $file_names, $document_id)
    {
        $path_array = [];
        foreach ($file_names as $type) {
            if ($request->hasFile($type)) {
                $path = 'storage/uploads/' . $type . '/';
                $extension = $request->file($type)->getClientOriginalExtension();
                $fileSize = $request->file($type)->getSize();
                if (in_array($extension, ['mp3'])) {
                    $fileName = $document_id . '-' . time() . '.' . $extension;
                    //create the folder if it does not exist
                    if (!file_exists(base_path() . '/storage/app/public/uploads/' . $type)) {
                        mkdir(base_path() . '/storage/app/public/uploads/' . $type, 0777, true);
                    }
                    //then move the file
                    $request->file($type)->move(
                        base_path() . '/storage/app/public/uploads/' . $type,
                        $fileName
                    );

                    $path_array[$type] = [
                        'path' => $path . $fileName,
                        'size' => $fileSize,
                    ];
                }else{
                    throw new \Exception('file type is not supported only MP3 file is allowed');
                }
            }else{
                throw new \Exception('there is not file attached');
            }
        }
        
        return $path_array;
    }
}

if (!function_exists('getUserCreationRequestCount')) {
    function getUserCreationRequestCount()
    {
        $count = DB::select("select count(*) as count from user_creation_requests where is_approved is NULL");
        // \Log::info($count);
        
        return $count[0]->count;
    }
}

if (!function_exists('getProvinceName')) {
    function getProvinceName($id)
    {
        $count = DB::select("select name from provinces where id=".$id);
        // \Log::info($count);
        
        return $count[0]->name;
    }
}

if (!function_exists('getDistrictName')) {
    function getDistrictName($id)
    {
        $count = DB::select("select name from districts where id=".$id);
        // \Log::info($count);
        
        return $count[0]->name;
    }
}