<ul class="nav nav-tabs">
    {if condition="checkPath('oil/index')"}
    <li><a href="{:Url('oil/index')}">油卡列表</a></li>
    {/if}
    {if condition="checkPath('oil/addOilOut')"}
    <li class="active"><a href="{:Url('oil/addOilOut')}">车辆加油</a></li>
    {/if}
</ul>
 <form  class="form-horizontal" action="{:url('oil/addOilOut')}" method="post">
    {include file="form:form_oil_out" /}
</form>
