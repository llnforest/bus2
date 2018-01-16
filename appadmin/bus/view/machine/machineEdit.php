<ul class="nav nav-tabs">
    {if condition="checkPath('machine/index')"}
    <li><a href="{:Url('machine/index')}">配件列表</a></li>
    {/if}
    {if condition="checkPath('machine/machineAdd')"}
    <li><a href="{:Url('machine/machineAdd')}">添加配件</a></li>
    {/if}
    {if condition="checkPath('machine/machineEdit')"}
    <li class="active"><a href="{:Url('machine/machineEdit')}">修改配件</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('machine/machineEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_machine" /}
</form>
