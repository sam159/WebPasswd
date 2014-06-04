<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('breadcrumb') %}
<li class="current unavailable"><a>{{$passwd->getDomain()}}</a></li>
{%t EndSection() %}

{%t StartSection('content') %}
{{t Render('topmenu') }}

<h2>Really delete the entry for {{$passwd->getDomain()}}?</h2>

<form action="{{action_url('Delete','domain='.urlencode($passwd->getDomain()))}}" method="POST">
  <div class="row">
    <div class="large-6 columns text-right">
      <a class="button" href="{{action_url('View','domain='.urlencode($passwd->getDomain()))}}">
        No, take me back
      </a>
    </div>
    <div class="large-6 columns text-left">
      <input type="submit" class="button alert" value="Yes, continue"/>
    </div>
  </div>
</form>

{%t EndSection() %}