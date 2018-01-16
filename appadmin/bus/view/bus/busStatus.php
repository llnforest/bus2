{__NOLAYOUT__}
{include file="publics:topCss"}
<div class="container-fluid  text-center"  style="padding-top:12px;">
    <div id="alert"></div>
           {if $info.status != 1}
           <button class="layui-btn btn-post" post-url="{:url('bus/busStatus',['id'=>$info.id,'status'=>1])}">正常</button>
           {/if}
           {if $info.status != 2}
           <button class="layui-btn layui-btn-normal btn-post" post-url="{:url('bus/busStatus',['id'=>$info.id,'status'=>2])}" >维修</button>
           {/if}
           {if $info.status != 3}
           <button class="layui-btn layui-btn-warm btn-post" post-url="{:url('bus/busStatus',['id'=>$info.id,'status'=>3])}">报废</button>
           {/if}
           {if $info.status != 0}
           <button class="layui-btn layui-btn-danger btn-post" post-url="{:url('bus/busStatus',['id'=>$info.id,'status'=>0])}">停用</button>
           {/if}
</div>
{include file="publics:bottomJs"}