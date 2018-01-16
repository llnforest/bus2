<ul class="nav nav-tabs">
    {if condition="checkPath('oil/index')"}
    <li><a href="{:Url('oil/index')}">油卡列表</a></li>
    {/if}
    {if condition="checkPath('oil/oilAdd')"}
    <li><a href="{:Url('oil/oilAdd')}">添加油卡</a></li>
    {/if}
    {if condition="checkPath('oil/oilEdit')"}
    <li class="active"><a href="{:Url('oil/oilEdit')}">修改油卡</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('oil/oilEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_oil" /}
</form>
