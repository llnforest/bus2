<ul class="nav nav-tabs">
    {if condition="checkPath('accident/index')"}
    <li><a href="{:Url('accident/index')}">事故列表</a></li>
    {/if}
    {if condition="checkPath('accident/accidentAdd')"}
    <li class="active"><a href="{:Url('accident/accidentAdd')}">添加事故</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('accident/accidentAdd')}" method="post">
    {include file="form:form_accident" /}
</form>
