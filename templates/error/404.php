<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{% $context['title'] = "Error 404 | Not Found" %}
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('content') %}
<h2>Sorry, the page or resource you requested could not be found</h2>
{% if ($message): %}
<p>{{$message}}</p>
{% endif %}
{%t EndSection() %}