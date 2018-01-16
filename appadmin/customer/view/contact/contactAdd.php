<ul class="nav nav-tabs">
    {if condition="checkPath('contact/index')"}
    <li><a href="{:Url('contact/index')}">往来单位</a></li>
    {/if}
    {if condition="checkPath('contact/contactAdd')"}
    <li class="active"><a href="{:Url('contact/contactAdd')}">添加单位</a></li>
    {/if}
    
</ul>
 <form  class="form-horizontal" action="{:url('contact/contactAdd')}" method="post">
    {include file="form:form_contact" /}
</form>
