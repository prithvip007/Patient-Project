<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patients';
    protected $fillable = ['pat_name', 'pat_type', 'owner_name', 'owner_addr', 'owner_phno'];
}
