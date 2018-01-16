<ul class="nav nav-tabs">
    {if condition="checkPath('user/index')"}
    <li><a href="{:Url('user/index')}">员工列表</a></li>
    {/if}
    {if condition="checkPath('user/userAdd')"}
    <li><a href="{:Url('user/userAdd')}">添加员工</a></li>
    {/if}
    {if condition="checkPath('user/userEdit')"}
    <li class="active"><a href="{:Url('user/userEdit')}">修改员工</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('user/userEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_user" /}
</form>
