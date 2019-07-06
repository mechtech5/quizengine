<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  protected $fillable = ['topic_id', 'ques', 'options', 'ans'];
}
