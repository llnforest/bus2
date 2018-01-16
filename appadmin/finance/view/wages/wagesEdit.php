<ul class="nav nav-tabs">
    {if condition="checkPath('wages/index')"}
    <li><a href="{:Url('wages/index')}">工资列表</a></li>
    {/if}
    {if condition="checkPath('wages/wagesAdd')"}
    <li><a href="{:Url('wages/wagesAdd')}">添加工资</a></li>
    {/if}
    {if condition="checkPath('wages/wagesEdit')"}
    <li class="active"><a href="{:Url('wages/wagesEdit')}">修改工资</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('wages/wagesEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_wages" /}
</form>
