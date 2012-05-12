<h1 class="header"> {lang mkey='header' skey='cv_visibility'} </h1>

{if $message != "" } <br />{$message}<br /> {/if}

<br />
<div class="cv_contain">
<p>{lang mkey='label' skey='downloadcv'}</p>
<input type="button" onclick="redirect_to('{$BASE_URL}employer/download_cv/?id={$id}&amp;u={$employee_id}'); " value="{lang mkey='button' skey='DownloadCV'}" class="button" />
<br /><br />
</div>

<br /><br />


<div class="cv_header">{lang mkey='searchResult' skey='h1'}</div>

<div class="cv_contain">

<label class="label">{lang mkey='label' skey='cv_1'}</label>
<br />
{$exper}
<hr />

<label class="label">{lang mkey='label' skey='cv_2'}</label>
<br />
{$educ}
<hr />

<label class="label">{lang mkey='label' skey='cv_3'}</label>
<br />
{$salary}
<hr />

<label class="label">{lang mkey='label' skey='cv_4'}</label>
<br />
{$availabe}
<hr />

<label class="label">{lang mkey='label' skey='cv_5'}</label>
<br />
	{$str_date}
<hr />

<label class="label">{lang mkey='label' skey='cv_6'}</label>
<br />
{$position}
<br /><br /> 
</div>

<br /><br /> 

<div class="cv_header">{lang mkey='searchResult' skey='h2'}</div>
<div class="cv_contain">

<label class="label">{lang mkey='label' skey='cv_7'}</label>
<br />
{$rjt}
<hr />

<label class="label">{lang mkey='label' skey='cv_8'}</label>
<br />
{$re}
<hr />

<label class="label">{lang mkey='label' skey='cv_9'}</label>
<br />
{$riw}
<hr />

<label class="label">{lang mkey='label' skey='cv_10'}</label>
<br />
{$careers}
<br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='searchResult' skey='h3'}</div>
<div class="cv_contain">
<label class="label">{lang mkey='label' skey='cv_11'}</label>

<br />{$ljt}
<br />{$ljt2}
<hr />

<label class="label">{lang mkey='label' skey='cv_12'}</label>
<br />
{$li}
<hr />

<label class="label">{lang mkey='label' skey='cv_13'}</label>
<br />
{$job_type}

<hr />

<label class="label">{lang mkey='label' skey='cv_18'}</label>
<br />
{$ljs}

<br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='searchResult' skey='h4'}</div>
<div class="cv_contain">
<label class="label">{lang mkey='label' skey='cv_14'}</label>
<br />
{$city}, {$county}, {$state}, {$country}
<hr />

<label class="label">{lang mkey='label' skey='cv_15'}</label>
<br />
{$aya}
<hr />

<label class="label">{lang mkey='label' skey='cv_16'}</label>
<br />
{$wtr}
<hr />

<label class="label">{lang mkey='label' skey='cv_17'}</label>
<br />
{$wtt}
<br /><br />
</div>

<br /><br />

<div class="cv_header">{lang mkey='searchResult' skey='h5'}</div>
<div class="cv_contain">
	{$notes}
  <br /><br />
</div>
