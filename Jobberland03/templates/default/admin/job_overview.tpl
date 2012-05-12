<div class="header">&nbsp;</div>

{if $message != "" } {$message} {/if}

<p>
    <strong>Total Job Posting:</strong>  {$total_posting}
</p>

<table width="80%" border="0" cellspacing="0" cellpadding="0" class="job_overview_table">
  <tr>
    <td colspan="4"><strong>Jobs approved: </strong> {$total_active_approved + $total_not_active_approved}</td>
  </tr>
  
  <tr class="highlight_job bold" >
    <td>&nbsp;</td>
    <td>Active</td>
    <td>Not Active</td>
    <td>Total</td>
  </tr>
    
  <tr>
    <td>Today</td>
    <td>{$total_active_approval_today}</td>
    <td>{$total_not_active_approval_today}</td>
    <td>{$total_active_approval_today+$total_not_active_approval_today}</td>
  </tr>
  
  <tr class="highlight_job">
    <td>This Week</td>
    <td>{$total_active_approval_week}</td>
    <td>{$total_not_active_approval_week}</td>
    <td>{$total_active_approval_week+$total_not_active_approval_week}</td>
  </tr>
  
  <tr>
    <td>This Month</td>
    <td>{$total_active_approval_month}</td>
    <td>{$total_not_active_approval_month}</td>
    <td>{$total_active_approval_month+$total_not_active_approval_month}</td>
  </tr>
  
  <tr class="highlight_job">
    <td><strong>Totals</strong></td>
    <td>{$total_active_approved}</td>
    <td>{$total_not_active_approved}</td>
    <td>{$total_active_approved+$total_not_active_approved}</td>
  </tr>
  
</table>

{** Pending *}

<br />
 <table width="80%" border="0" cellspacing="0" cellpadding="0" class="job_overview_table">
  <tr>
    <td colspan="4"><strong>Jobs Pending: </strong> {$total_active_pending + $total_not_active_pending}</td>
  </tr>
  
  <tr class="highlight_job bold" >
    <td>&nbsp;</td>
    <td>Active</td>
    <td>Not Active</td>
    <td>Total</td>
  </tr>
    
  <tr>
    <td>Today</td>
    <td>{$total_active_pending_today}</td>
    <td>{$total_not_active_pending_today}</td>
    <td>{$total_active_pending_today + $total_not_active_pending_today}</td>
  </tr>
  
  <tr class="highlight_job">
    <td>This Week</td>
    <td>{$total_active_pending_week}</td>
    <td>{$total_not_active_pending_week}</td>
    <td>{$total_active_pending_week + $total_not_active_pending_week}</td>
  </tr>
  
  <tr>
    <td>This Month</td>
    <td>{$total_active_pending_month}</td>
    <td>{$total_not_active_pending_month}</td>
    <td>{$total_active_pending_month + $total_not_active_pending_month}</td>
  </tr>
  
  <tr class="highlight_job">
    <td><strong>Totals</strong></td>
    <td>{$total_active_pending}</td>
    <td>{$total_not_active_pending}</td>
    <td>{$total_active_pending + $total_not_active_pending}</td>
  </tr>
  
</table>  

{** Rejected *}
<br />
 <table width="80%" border="0" cellspacing="0" cellpadding="0" class="job_overview_table">
  <tr>
    <td colspan="4"><strong>Jobs Rejected: </strong> {$total_active_rejected + $total_not_active_rejected}</td>
  </tr>
  
  <tr class="highlight_job bold" >
    <td>&nbsp;</td>
    <td>Active</td>
    <td>Not Active</td>
    <td>Total</td>
  </tr>
    
  <tr>
    <td>Today</td>
    <td>{$total_active_rejected_today}</td>
    <td>{$total_not_active_rejected_today}</td>
    <td>{$total_active_rejected_today + $total_not_active_rejected_today}</td>
  </tr>
  
  <tr class="highlight_job">
    <td>This Week</td>
    <td>{$total_active_rejected_week}</td>
    <td>{$total_not_active_rejected_week}</td>
    <td>{$total_active_rejected_week + $total_not_active_rejected_week}</td>
  </tr>
  
  <tr>
    <td>This Month</td>
    <td>{$total_active_rejected_month}</td>
    <td>{$total_not_active_rejected_month}</td>
    <td>{$total_active_rejected_month + $total_not_active_rejected_month}</td>
  </tr>
  
  <tr class="highlight_job">
    <td><strong>Totals</strong></td>
    <td>{$total_active_rejected}</td>
    <td>{$total_not_active_rejected}</td>
    <td>{$total_active_rejected + $total_not_active_rejected}</td>
  </tr>
  
</table>     


{** Expired *}
<br />
 <table width="80%" border="0" cellspacing="0" cellpadding="0" class="job_overview_table">
  <tr>
    <td colspan="4"><strong>Jobs Expired: </strong> {$total_active_expired + $total_not_active_expired}</td>
  </tr>
  
  <tr class="highlight_job bold" >
    <td>&nbsp;</td>
    <td>Active</td>
    <td>Not Active</td>
    <td>Total</td>
  </tr>
    
  <tr>
    <td>Today</td>
    <td>{$total_active_expired_today}</td>
    <td>{$total_not_active_expired_today}</td>
    <td>{$total_active_expired_today + $total_not_active_expired_today}</td>
  </tr>
  
  <tr class="highlight_job">
    <td>This Week</td>
    <td>{$total_active_expired_week}</td>
    <td>{$total_not_active_expired_week}</td>
    <td>{$total_active_expired_week + $total_not_active_expired_week}</td>
  </tr>
  
  <tr>
    <td>This Month</td>
    <td>{$total_active_expired_month}</td>
    <td>{$total_not_active_expired_month}</td>
    <td>{$total_active_expired_month + $total_not_active_expired_month}</td>
  </tr>
  
  <tr class="highlight_job">
    <td><strong>Totals</strong></td>
    <td>{$total_active_expired}</td>
    <td>{$total_not_active_expired}</td>
    <td>{$total_active_expired + $total_not_active_expired}</td>
  </tr>
  
</table>  
