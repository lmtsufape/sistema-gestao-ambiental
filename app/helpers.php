<?php

use Illuminate\Support\Facades\Storage;

function delete_file($path, $disk = 'local'){
    if ($path != null && Storage::disk($disk)->exists($path)) {
        Storage::disk($disk)->delete($path);
    }
}
