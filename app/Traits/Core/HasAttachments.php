<?php

namespace App\Traits\Core;

use App\Models\Core\Attachment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAttachments
{
    public function attachmentable():MorphMany{
        return $this->morphMany(Attachment::class,'attachmentable');
    }
}
