<ul class="nav nav-tabs">
    {if condition="checkPath('machine/index')"}
    <li><a href="{:Url('machine/index')}">配件列表</a></li>
    {/if}
    {if condition="checkPath('machine/machineAdd')"}
    <li class="active"><a href="{:Url('machine/machineAdd')}">添加配件</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('machine/machineAdd')}" method="post">
    {include file="form:form_machine" /}
</form>
