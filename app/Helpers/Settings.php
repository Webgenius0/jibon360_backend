<?php
namespace App\Helpers;
use App\Models\Setting;
class Settings{

  public static function get(){
    return Setting::latest( 'id' )->first();
  }

}