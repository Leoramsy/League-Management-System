<?php

namespace App\Models;

use App\Models\EditorInterface;
use App\Http\Traits\EditorTrait;
use Illuminate\Database\Eloquent\Model;

abstract class Editor extends Model implements EditorInterface {
    
    use EditorTrait;

    /**
     * Constants 
     */
    const ACTION_CREATE = "create";
    const ACTION_EDIT = "edit";
    const ACTION_READ = "read";
    const ACTION_REMOVE = "remove";
    const ACTION_SYSTEM = "system";

}
