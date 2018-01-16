<ul class="nav nav-tabs">
    {if condition="checkPath('reimburse/index')"}
    <li><a href="{:Url('reimburse/index')}">报销列表</a></li>
    {/if}
    {if condition="checkPath('reimburse/reimburseAdd')"}
    <li class="active"><a href="{:Url('reimburse/reimburseAdd')}">添加报销</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('reimburse/reimburseAdd')}" method="post">
    {include file="form:form_reimburse" /}
</form>
