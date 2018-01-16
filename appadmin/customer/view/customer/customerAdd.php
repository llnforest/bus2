<ul class="nav nav-tabs">
    {if $skip_type == 'order'}
        {if condition="checkPath('order/index')"}
        <li><a href="{:Url('reserve/order/index')}">订单管理</a></li>
        {/if}
        {if condition="checkPath('order/orderAdd')"}
        <li><a href="{:Url('reserve/order/orderAdd')}">添加订单</a></li>
        {/if}
    {else}
        {if condition="checkPath('customer/index')"}
        <li><a href="{:Url('customer/index')}">客户列表</a></li>
        {/if}
    {/if}
    {if condition="checkPath('customer/customerAdd')"}
    <li class="active"><a href="{:Url('customer/customerAdd')}">添加客户</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('customer/customerAdd')}" method="post">
    {include file="form:form_customer" /}
</form>
