<ul class="nav nav-tabs">
    {if condition="checkPath('corporation/index')"}
    <li><a href="{:Url('corporation/index')}">车辆归属</a></li>
    {/if}
    {if condition="checkPath('corporation/corporationAdd')"}
    <li><a href="{:Url('corporation/corporationAdd')}">添加归属</a></li>
    {/if}
    {if condition="checkPath('corporation/corporationEdit')"}
    <li class="active"><a href="{:Url('corporation/corporationEdit')}">修改归属</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('corporation/corporationEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_corporation" /}
</form>
