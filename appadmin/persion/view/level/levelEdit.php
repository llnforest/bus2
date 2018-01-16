<ul class="nav nav-tabs">
    {if condition="checkPath('level/index')"}
    <li><a href="{:Url('level/index')}">岗位列表</a></li>
    {/if}
    {if condition="checkPath('level/levelAdd')"}
    <li><a href="{:Url('level/levelAdd')}">添加岗位</a></li>
    {/if}
    {if condition="checkPath('level/levelEdit')"}
    <li class="active"><a href="{:Url('level/levelEdit')}">修改岗位</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('level/levelEdit',['id'=>$info['id']])}" method="post">
    {include file="form:form_level" /}
</form>
