<ul class="nav nav-tabs">
    {if condition="checkPath('check/index')"}
    <li><a href="{:Url('check/index')}">年检列表</a></li>
    {/if}
    {if condition="checkPath('check/checkAdd')"}
    <li class="active"><a href="{:Url('check/checkAdd')}">添加年检</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('check/checkAdd')}" method="post">
    {include file="form:form_check" /}
</form>
