<ul class="nav nav-tabs">
    {if condition="checkPath('illegal/index')"}
    <li><a href="{:Url('illegal/index')}">违章列表</a></li>
    {/if}
    {if condition="checkPath('illegal/illegalAdd')"}
    <li class="active"><a href="{:Url('illegal/illegalAdd')}">添加违章</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('illegal/illegalAdd')}" method="post">
    {include file="form:form_illegal" /}
</form>
