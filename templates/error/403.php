<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{% $context['title'] = "Error 403 | Unauthorised" %}
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('content') %}
<h2>Sorry, the page or resource you requested requires additional privileges</h2>
{% if ($message): %}
<p>{{$message}}</p>
{% endif %}
{%t EndSection() %}