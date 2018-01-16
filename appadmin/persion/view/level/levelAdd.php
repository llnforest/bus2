<ul class="nav nav-tabs">
    {if condition="checkPath('level/index')"}
    <li><a href="{:Url('level/index')}">岗位列表</a></li>
    {/if}
    {if condition="checkPath('level/levelAdd')"}
    <li class="active"><a href="{:Url('level/levelAdd')}">添加岗位</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('level/levelAdd')}" method="post">
    {include file="form:form_level" /}
</form>
