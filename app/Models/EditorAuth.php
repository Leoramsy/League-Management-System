<?php

namespace App\Models;

use App\Http\Traits\EditorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class EditorAuth extends Authenticatable implements EditorInterface {
    
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
