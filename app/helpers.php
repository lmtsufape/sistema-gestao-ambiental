<?php

use Illuminate\Support\Facades\Storage;

/**
 * Deleta o arquivo se o arquivo existe no disco especificado.
 *
 * @param string $path caminho do arquivo
 * @param string $disk (opcional) disco onde o arquivo está localizado, por padrão usa o disco local
 * @return void
 */
function delete_file($path, $disk = 'local'){
    if ($path != null && Storage::disk($disk)->exists($path)) {
        Storage::disk($disk)->delete($path);
    }
}
