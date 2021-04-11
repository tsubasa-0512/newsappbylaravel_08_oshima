<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    public function user() {
        return $this->belongsTo('App\Models\User');
      }

    protected $fillable = [
        'title', 
        'url', 
        'thumbnail', 
        'published', 
        'tag',
        'user_id', 
    ];
}
