<ul class="nav nav-tabs">
    {if condition="checkPath('machine/index')"}
    <li><a href="{:Url('machine/index')}">配件列表</a></li>
    {/if}
    {if $type == 1}
    {if condition="checkPath('machine/machineIn')"}
    <li><a href="{:Url('machine/machineIn')}">进货记录</a></li>
    {/if}
    {else}
    {if condition="checkPath('machine/machineOut')"}
    <li><a href="{:Url('machine/machineOut')}">领用记录</a></li>
    {/if}
    {/if}
    {if condition="checkPath('machine/operateEdit',['type'=>$type])"}
    <li class="active"><a href="{:Url('machine/operateEdit',['type'=>$type])}">修改配件{if $type == 1}进货{else}领用{/if}</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('machine/operateEdit',['type'=>$type,'id'=>$info['id']])}" method="post">
    {include file="form:form_in_out" /}
</form>
