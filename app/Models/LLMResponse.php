<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LLMResponse extends Model
{
    protected $fillable = [
        'noob_id',
        'event_type',
        'event_details',
    ];

    protected $table = 'llm_responses';

    /**
     * Get the noob that owns the LLM response.
     */
    public function noob()
    {
        return $this->belongsTo(Noob::class);
    }
}
