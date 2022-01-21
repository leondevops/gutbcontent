<?php

namespace Vnlab\Gutbcontent\Inc\Pages\Admin;

class SettingsManagerPage
{
  public string $id; // $option_name, $field_id - calling at Admin.php
  // public string $option_group;
  //public string $option_name;
  // public string $field_id;
  public string $title; // $field_title - calling at Admin.php
  public string $classname; // $field_classname - calling at Admin.php

  public function __construct(){

  }

  public static function createObj(string $id, string $title, string $classname): SettingsManagerPage
  {
    $settingPage = new self();
    $settingPage->id = $id;
    $settingPage->title = $title;
    $settingPage->classname = $classname;

    return $settingPage;
  }
}