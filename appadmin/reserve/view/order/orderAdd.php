<ul class="nav nav-tabs">
    {if condition="checkPath('order/index')"}
    <li><a href="{:Url('order/index')}">订单管理</a></li>
    {/if}
    {if condition="checkPath('order/orderAdd')"}
    <li class="active"><a href="{:Url('order/orderAdd')}">添加订单</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('order/orderAdd')}" method="post">
    {include file="form:form_order" /}
</form>
