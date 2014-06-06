<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('breadcrumb') %}
<li class="current"><a href="install.php">Installation</a></li>
{%t EndSection() %}

{%t StartSection('content') %}

{% if ($writeError): %}
<div class="alert-box alert" data-alert>
  Cannot write to the password file location, please check the write permissions
  <a href="#" class="close">&times;</a>
</div>
{% endif %}

{% if ($message): %}
<div data-alert class="alert-box alert {{$message['style']}}">
  {{$message['text']}}
  <a href="#" class="close">&times;</a>
</div>
{% endif %}

<h2>Install WebPasswd</h2>

<div class="row">
  <div class="large-12 columns">
    <label>
      Username (for reference, as defined in config.php)
      <input type="text" readonly value="{{$username}}"/>
    </label>
  </div>
</div>
<form action="" method="post">
  <div class="row">
    <div class="large-6 columns">
      <label>
        New Password
        <input type="password" name="new"/>
      </label>
    </div>
    <div class="large-6 columns">
      <label>
        Confirm Password
        <input type="password" name="confirm"/>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>
        <input type="submit" value="Install" class="button"/>
      </label>
    </div>
  </div>
</form>

{%t EndSection() %}