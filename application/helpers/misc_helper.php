<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function die_pre($array = array())
{
    die("<pre>die_pre:<br /><br />".print_r($array, TRUE)."<br /><br />/die_pre</pre>");
}

function echo_pre($array = array())
{
    echo "<pre>echo_pre:<br /><br />".print_r($array, TRUE)."<br /><br />/echo_pre</pre>";
}