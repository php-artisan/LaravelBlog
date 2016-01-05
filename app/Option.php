<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name', 'value'];

    static public function get_option($name)
    {
        $option = Option::whereName($name)->get(['value']);
        return $option[0]->value;
    }
}
