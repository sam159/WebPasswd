<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('breadcrumb') %}
<li class="current unavailable"><a>Settings</a></li>
{%t EndSection() %}

{%t StartSection('content') %}
{{t Render('topmenu') }}

<h2>Change Password</h2>

{% if ($passwordMessage):  %}
<div data-alert class="alert-box {{$passwordMessage['style']}}">
  {{$passwordMessage['text']}}
  <a href="javascript:void(0);" class="close">&times;</a>
</div>
{% endif %}

<form action="{{action_url('Settings','form=password')}}" method="post">
  <div class="row">
    <div class="large-12 columns">
      <label>Current Password
        <input type="password" name="current"/>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-6 columns">
      <label>New Password
        <input type="password" name="new"/>
      </label>
    </div>
    <div class="large-6 columns">
      <label>Confirm Password
        <input type="password" name="confirm"/>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <input type="submit" value="Change" class="button"/>
    </div>
  </div>
</form>

{%t EndSection() %}