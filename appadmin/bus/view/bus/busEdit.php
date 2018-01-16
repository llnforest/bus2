<ul class="nav nav-tabs">
    {if condition="checkPath('bus/index')"}
    <li><a href="{:Url('bus/index')}">车辆列表</a></li>
    {/if}
    {if condition="checkPath('bus/busAdd')"}
    <li><a href="{:Url('bus/busAdd')}">添加车辆</a></li>
    {/if}
    {if condition="checkPath('bus/busEdit')"}
    <li class="active"><a href="{:Url('bus/busEdit')}">修改车辆</a></li>
    {/if}
</ul>
<form  class="form-horizontal" action="{:url('bus/busEdit',['id'=>$info.id])}" method="post">
    {include file="form:form_bus" /}
</form>
