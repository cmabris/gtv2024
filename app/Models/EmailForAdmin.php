<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailForAdmin extends Model
{
    use HasFactory;

    protected $table = 'email_for_admin';

    protected $guarded = ['id'];
}
