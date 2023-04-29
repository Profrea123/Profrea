<?php

namespace App\models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_box extends Model
{
    use HasFactory;
    public $table = 'chat_box';
    public $timestamps = false; //it will tell laravel that we don't need updated at filed in this table, otherwise laravel suppose that every table has update_at 
    protected $fillable = ['cb_id', 'user_id', 'reply_to', 'reply_on', 'status', 'message', 'created_at'];
}

?>