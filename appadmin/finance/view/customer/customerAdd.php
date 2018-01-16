<ul class="nav nav-tabs">
    {if condition="checkPath('customer/index')"}
    <li><a href="{:Url('customer/index')}">客户总账</a></li>
    {/if}
    {if condition="checkPath('customer/customerList')"}
    <li><a href="{:Url('customer/customerList')}">账单列表</a></li>
    {/if}
    {if condition="checkPath('customer/customerAdd')"}
    <li class="active"><a href="{:Url('customer/customerAdd')}">添加账单</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('customer/customerAdd')}" method="post">
    {include file="form:form_customer" /}
</form>
