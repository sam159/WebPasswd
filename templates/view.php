<?php if(!defined("DIR_TEMPLATES")) {echo "This file cannot be accessed directly";exit();} ?>
{%t SetMaster('master') %}

{%t StartSection('script') %}
<script src="assets/js/pw-gen.js"></script>
{%t EndSection() %}

{%t StartSection('breadcrumb') %}
<li class="current unavailable"><a>{{($passwd->getDomain()?$passwd->getDomain():'New Entry')}}</a></li>
{%t EndSection() %}

{%t StartSection('content') %}
{{t Render('topmenu') }}


<div id="password-gen" class="reveal-modal tiny" data-reveal>
    <h2>Generate New Password</h2>
    <form data-abide="ajax">
        <div class="row">
            <div class="large-12 columns">
                <label>
                    Password Length
                    <input type="text" value="10" id="pw-length" required pattern="number"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <label>Character Classes</label>
                <input type="checkbox" id="pw-class-az-uc" checked="checked"/> <label for="pw-class-az-uc">A-Z</label>
                <input type="checkbox" id="pw-class-az-lc" checked="checked"/> <label for="pw-class-az-lc">a-z</label>
                <input type="checkbox" id="pw-class-09" checked="checked"/> <label for="pw-class-09">0-9</label>
                <input type="checkbox" id="pw-class-special"/> <label for="pw-class-special">Special</label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <label>
                    Minimum Digits
                    <input type="text" value="1" id="pw-digits-min" required pattern="number"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input type="checkbox" id="pw-avoid-ambigious"><label for="pw-avoid-ambigious">Avoid ambigious characters</label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input type="checkbox" id="pw-require-all-classes" checked="checked"><label for="pw-require-all-classes">Require every character type</label>
            </div>
        </div>
        <fieldset>
            <div class="row">
                <div class="large-8 columns small-centered">
                    <input type="text" id="pw-generated">
                </div>
            </div>
            <div class="row">
                <div class="large-8 columns small-centered text-center">
                    <ul class="button-group stack-for-small row">
                        <li class="small-6">
                            <a href="javascript:void(0);" id="pw-generate-new" class="button expand secondary">
                                Generate
                            </a>
                        </li>
                        <li class="small-6">
                            <button type="submit" class="button expand">Apply</button>
                        </li>
                    </ul>
                </div>
            </div>
        </fieldset>
    </form>
    <a class="close-reveal-modal">&#215;</a>
</div>

<form action="{{action_url('View','domain='.urlencode($passwd->getDomain()))}}" method="POST">
    <div>
      <a href="{{action_url()}}" class="button tiny">&#171; Back</a>
      <input class="button tiny" type="submit" value="Save"/>
      <a href="{{action_url('Delete','domain='.urlencode($passwd->getDomain()))}}" class="button alert tiny">Delete</a>
    </div>

    {% if ($saved): %}
    <div data-alert class="alert-box info">
      Changes Saved
      <a href="#" class="close">&times;</a>
    </div>
    {% endif %}


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
      <label class="password-label">Password
          <div class="row collapse">
              <div class="small-11 columns">
                <input type="password" autocomplete="off" id="field-password" name="password" value="{{$passwd->getPassword()}}" placeholder="Password"/>
              </div>
              <div class="small-1 columns">
                  <span class="postfix">
                    <a href="javascript:void(0);" id="new-password" data-reveal-id="password-gen">
                      <img src="assets/img/refresh.png" alt="Create"/>
                    </a>
                  </span>
              </div>
          </div>
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