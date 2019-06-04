<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequirementStatusTransaction extends Model
{
    protected $fillable = [ 'customer_status_id', 'requirement_id', 'user_id'];
}
