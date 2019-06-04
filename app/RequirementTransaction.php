<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequirementTransaction extends Model
{
    protected $fillable = [ 'requirement_id', 'user_id'];
}
