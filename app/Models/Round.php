<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
  protected $fillable = ['code', 'topic_id', 'player_1', 'player_2', 'score_1', 'score_2', 'winner'];
}
