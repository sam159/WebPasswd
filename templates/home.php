<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('content') %}
{{t Render('topmenu') }}


<ul id="domain-list">
  {% foreach($book as $passwd): %}
  <li>
    <a href="{{action_url('View')}}&domain={{urlencode($passwd->getDomain())}}">
      {{$passwd->getDomain()}}
    </a>
  </li>
  {% endforeach %}
</ul>
<div>
  <a href="{{action_url('View')}}" class="button">
    + New
  </a>
</div>

<div>
  <a href="javascript:var u=encodeURIComponent(window.location.host); window.open('{{base_href()}}?action=View&domain='+u,'WebPasswd','width=400,height=500');" class="button tiny">Bookmarklet</a>
</div>

{%t EndSection() %}