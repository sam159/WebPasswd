<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('breadcrumb') %}
<li class="current"><a href="install.php">Installation</a></li>
{%t EndSection() %}

{%t StartSection('content') %}

<div data-alert class="alert-box alert">

  <p>It looks like your passwords file already exists, you may now delete this file</p>
  <p>To proceed with a new installation please remove the current passwords file or specify a different location in the config</p>

</div>


{%t EndSection() %}