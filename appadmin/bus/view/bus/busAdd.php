<ul class="nav nav-tabs">
    {if $style == 'bus'}
    {if condition="checkPath('bus/index')"}
    <li><a href="{:Url('bus/index')}">车辆列表</a></li>
    {/if}
    {elseif $style == 'order'}
    {if condition="checkPath('reserve/order/index')"}
    <li><a href="{:Url('reserve/order/index')}">订单管理</a></li>
    {/if}
    {if condition="checkPath('reserve/order/orderAdd')"}
    <li><a href="{:Url('reserve/order/orderAdd')}">添加订单</a></li>
    {/if}
    {if condition="checkPath('reserve/order/selectBus')"}
    <li><a href="{:Url('reserve/order/selectBus')}">选择派单</a></li>
    {/if}
    {/if}
    {if condition="checkPath('bus/bus/busAdd')"}
    <li class="active"><a href="{:Url('bus/bus/busAdd',['style'=>$style])}">添加车辆</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('bus/bus/busAdd')}" method="post">
    {include file="form:form_bus" /}
</form>
