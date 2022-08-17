<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Checklist extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public const STATUS_ENUM = [
        'nao_enviado' => 1,
        'enviado' => 2,
        'aceito' => 3,
        'analisado' => 4,
        'recusado' => 5,
    ];
}
