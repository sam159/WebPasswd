<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('breadcrumb') %}
<li class="current"><a href="{{action_url('Login')}}">Login</a></li>
{%t EndSection() %}

{%t StartSection('content') %}

<h2>Login Required</h2>

{% if ($message): %}
<p>{{$message}}</p>
{% endif %}

<form action="{{action_url('Login')}}" method="POST">
  <div class="row">
    <div class="large-12 columns">
      <input type="text" name="username" value="{{$username}}" placeholder="Username"/>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <input type="password" name="password" placeholder="Password">
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <input type="submit" class="button" value="Login"/>
    </div>
  </div>
</form>

{%t EndSection() %}