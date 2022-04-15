<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petient extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patients';
    protected $fillable = ['pet_name', 'pet_type', 'owner_name', 'owner_addr', 'owner_phno'];
}
