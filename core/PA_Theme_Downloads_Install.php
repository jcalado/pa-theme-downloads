<?php

/**
 * 
 * Bootloader Install
 * 
 */

class PAThemeDownloadsInstall
{

  public function __construct()
  {
    add_action('widgets_init', array($this, 'setWidgets'), 11);
  }

  function setWidgets()
  {
    unregister_sidebar('front-page');
    unregister_sidebar('index');
    unregister_sidebar('single');
  }
}

$PAThemeDownloadsInstall = new PAThemeDownloadsInstall();
