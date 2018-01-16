<ul class="nav nav-tabs">
    {if condition="checkPath('customer/index')"}
    <li><a href="{:Url('customer/index')}">客户列表</a></li>
    {/if}
    {if condition="checkPath('customer/customerAdd')"}
    <li><a href="{:Url('customer/customerAdd')}">添加客户</a></li>
    {/if}
    {if condition="checkPath('customer/customerEdit')"}
    <li class="active"><a href="{:Url('customer/customerEdit')}">修改客户</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('customer/customerEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_customer" /}
</form>
