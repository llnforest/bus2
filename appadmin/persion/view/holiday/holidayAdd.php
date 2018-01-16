<ul class="nav nav-tabs">
    {if condition="checkPath('holiday/index')"}
    <li><a href="{:Url('holiday/index')}">请假列表</a></li>
    {/if}
    {if condition="checkPath('holiday/holidayAdd')"}
    <li class="active"><a href="{:Url('holiday/holidayAdd')}">添加请假</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('holiday/holidayAdd')}" method="post">
    {include file="form:form_holiday" /}
</form>
