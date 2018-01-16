<ul class="nav nav-tabs">
    {if condition="checkPath('oil/index')"}
    <li><a href="{:Url('oil/index')}">油卡列表</a></li>
    {/if}
    {if condition="checkPath('oil/addOilIn')"}
    <li class="active"><a href="{:Url('oil/addOilIn')}">充值油卡</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('oil/addOilIn')}" method="post">
    {include file="form:form_oil_in" /}
</form>
