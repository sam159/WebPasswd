<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{% $context['title'] = "Error 500" %}
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('content') %}
<h2>Sorry, there was an error processing your request.</h2>
{% if ($message): %}
<p>{{$message}}</p>
{% endif %}
{%t EndSection() %}