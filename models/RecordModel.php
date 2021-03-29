<?php

namespace models;

use core\BaseModel;

class RecordModel extends BaseModel
{
    public $id;
    public $date;
    public $status;
    public $text;
    public $like;
    public $dislike;
    public $user_id;

    static $table = 'records';
    
    public function rules()
    {
        return [
            // 'required' => ['text'],
            // 'string' => ['text']   // перевірка чи є стрічкою
        ];                                                                                              
    }

}