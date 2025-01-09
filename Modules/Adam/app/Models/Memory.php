<?php

namespace Modules\Adam\Models;

use Modules\Adam\Enums\Memory as MemoryEnum;
use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    protected $fillable = [
        'noob_id',
        'text',
        'type',
    ];

    protected function casts()
    {
        return [
            'type' => MemoryEnum::class,
        ];
    }

    public function noob()
    {
        return $this->belongsTo(Noob::class);
    }
}
