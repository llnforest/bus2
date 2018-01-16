<ul class="nav nav-tabs">
    {if condition="checkPath('machine/index')"}
    <li><a href="{:Url('machine/index')}">配件列表</a></li>
    {/if}
    {if condition="checkPath('machine/operateAdd',['type'=>$type])"}
    <li class="active"><a href="{:Url('machine/operateAdd',['type'=>$type])}">添加{if $type == 1}进货{else}领用{/if}配件</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('machine/operateAdd',['type'=>$type])}" method="post">
    {include file="form:form_in_out" /}
</form>
