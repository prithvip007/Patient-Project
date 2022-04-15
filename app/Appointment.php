<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointments';
    protected $fillable = ['petient_id','start_time', 'end_time', 'desc','fees', 'fee_paid', 'currency'];
}
