<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('head') %}
{%t EndSection() %}

{%t StartSection('breadcrumb') %}
<li class="current unavailable"><a>{{($passwd->getDomain()?$passwd->getDomain():'New Entry')}}</a></li>
{%t EndSection() %}

{%t StartSection('content') %}
{{t Render('topmenu') }}

<div>
  <a href="{{action_url()}}" class="button tiny">Back</a>
  <a href="{{action_url('Delete','domain='.urlencode($passwd->getDomain()))}}" class="button alert tiny">Delete</a>
</div>

{% if ($saved): %}
<div data-alert class="alert-box info">
  Changes Saved
  <a href="#" class="close">&times;</a>
</div>
{% endif %}

<form action="{{action_url('View','domain='.urlencode($passwd->getDomain()))}}" method="POST">
  <div class="row">
    <div class="large-12 columns">
      <label>Website
        <div class="row collapse">
          <div class="small-2 large-1 columns">
            <span class="prefix">http://</span>
          </div>
          <div class="small-10 large-11 columns">
              <input type="text" id="field-domain" name="domain" value="{{$passwd->getDomain()}}" placeholder="Domain Name"/>
          </div>
        </div>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-6 columns">
      <label>Username
        <input type="text" id="field-username" name="username" value="{{$passwd->getUsername()}}" placeholder="Username"/>
      </label>
    </div>
    <div class="large-6 columns">
      <label>Password
        <input type="password" autocomplete="off" id="field-password" name="password" value="{{$passwd->getPassword()}}" placeholder="Password"/>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>Notes
        <textarea id="field-notes" name="notes">{{$passwd->getNotes()}}</textarea>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <input class="button" type="submit" value="Save"/>
    </div>
  </div>
</form>

{%t EndSection() %}