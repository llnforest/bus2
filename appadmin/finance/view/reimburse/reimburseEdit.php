<ul class="nav nav-tabs">
    {if condition="checkPath('reimburse/index')"}
    <li><a href="{:Url('reimburse/index')}">报销列表</a></li>
    {/if}
    {if condition="checkPath('reimburse/reimburseAdd')"}
    <li><a href="{:Url('reimburse/reimburseAdd')}">添加报销</a></li>
    {/if}
    {if condition="checkPath('reimburse/reimburseEdit')"}
    <li class="active"><a href="{:Url('reimburse/reimburseEdit')}">修改报销</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('reimburse/reimburseEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_reimburse" /}
</form>
