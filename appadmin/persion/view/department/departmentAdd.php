<ul class="nav nav-tabs">
    {if condition="checkPath('department/index')"}
    <li><a href="{:Url('department/index')}">部门列表</a></li>
    {/if}
    {if condition="checkPath('department/departmentAdd')"}
    <li class="active"><a href="{:Url('department/departmentAdd')}">添加部门</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('department/departmentAdd')}" method="post">
    {include file="form:form_department" /}
</form>
