<ul class="nav nav-tabs">
    {if condition="checkPath('protect/index')"}
    <li><a href="{:Url('protect/index')}">维修保养</a></li>
    {/if}
    {if condition="checkPath('protect/protectAdd')"}
    <li class="active"><a href="{:Url('protect/protectAdd')}">添加维保</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('protect/protectAdd')}" method="post">
    {include file="form:form_protect" /}
</form>
