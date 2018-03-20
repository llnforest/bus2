<ul class="nav nav-tabs">
    {if $skip_type == 'bus'}
        {if condition="checkPath('bus/bus/index')"}
        <li><a href="{:Url('bus/bus/index')}">车辆列表</a></li>
        {/if}
        {if condition="checkPath('bus/bus/busAdd')"}
        <li><a href="{:Url('bus/bus/busAdd')}">添加车辆</a></li>
        {/if}
    {else}
        {if condition="checkPath('user/index')"}
        <li><a href="{:Url('user/index')}">员工列表</a></li>
        {/if}
    {/if}
    {if condition="checkPath('user/userAdd')"}
    <li class="active"><a href="{:Url('user/userAdd',['skip_type'=>$skip_type])}">添加员工</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('user/userAdd',['skip_type'=>$skip_type])}" method="post">
    {include file="form:form_user" /}
</form>
