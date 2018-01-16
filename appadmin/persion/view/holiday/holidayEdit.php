<ul class="nav nav-tabs">
    {if condition="checkPath('holiday/index')"}
    <li><a href="{:Url('holiday/index')}">请假列表</a></li>
    {/if}
    {if condition="checkPath('holiday/holidayAdd')"}
    <li><a href="{:Url('holiday/holidayAdd')}">添加请假</a></li>
    {/if}
    {if condition="checkPath('holiday/holidayEdit')"}
    <li class="active"><a href="{:Url('holiday/holidayEdit')}">修改请假</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('holiday/holidayEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_holiday" /}
</form>
