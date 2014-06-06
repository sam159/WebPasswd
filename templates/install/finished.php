<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('breadcrumb') %}
<li class="current"><a href="install.php">Installation</a></li>
{%t EndSection() %}

{%t StartSection('content') %}

<h2>All Done!</h2>

<p>
  The passwords file has been setup with the password supplied, you can now login.
</p>
<p>
  For added security you can now delete the install.php file as it is not longer necessary.
</p>

<div class="small-centered">
  <a href="{{action_url('Login')}}" class="button">Login</a>
</div>

{%t EndSection() %}