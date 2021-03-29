<?php

namespace models;

use core\BaseModel;

class UserModel extends BaseModel
{
    public $id;
    public $email;
    public $nick;
    public $password;
    public $url_avatar;
    public $role;

    static $table = 'users';

    const ROLE = ['administrator' => 'Administrator', 'follower' => 'Follower', 'author' => 'Author'];

    public function rules()
    {
        return [
            'required' => ['email', 'nick', 'password'],
            'email' => ['email'],
            'string' => ['nick', 'password']
        ];                                                                                              
    }

    // if (strlen($this->{$fields[0]}) < 2 || strlen($this->{$fields[0]}) > 25) {
    //     $error_message .= $fields[0] . ' too short are too long. Please correct!! <br>'; 
    //     $error = true;
    // }
    // if (strlen($this->{$fields[1]}) < 5 ) {
    //     $error_message .= $fields[1] . ' too short. Please correct!! <br>'; 
    //     $error = true;
    // }
    // if (!preg_match("#[0-9]+#", $this->{$fields[1]})) {
    //     $error_message .= $fields[1] . ' must include at least one number!! <br>'; 
    //     $error = true;
    // }
    // if (!preg_match("#[a-zA-Z]+#", $this->{$fields[1]})) {
    //     $error_message .= $fields[1] . ' must include at least one letter!! <br>';
    // }
}