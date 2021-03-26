<?php

namespace models;

use core\BaseModel;

class CommentModel extends BaseModel
{
    public $id;
    public $date;
    public $status;
    public $text;
    public $like;
    public $dislike;
    public $user_id;
    public $record_id;

    static $table = 'comments';

    //const ROLE = ['administrator' => 'Administrator', 'follower' => 'Follower', 'author' => 'Author'];

    public function rules()
    {
        return [
            // 'required' => ['text'],
            // 'string' => ['text']   // перевірка чи є стрічкою
            // 'email' => ['email'],
        ];                                                                                              
    }

}