<ul class="nav nav-tabs">
    {if condition="checkPath('bus/index')"}
    <li><a href="{:Url('bus/index')}">车辆列表</a></li>
    {/if}
    {if condition="checkPath('bus/busAdd')"}
    <li><a href="{:Url('bus/busAdd')}">添加车辆</a></li>
    {/if}
    {if condition="checkPath('bus/busList')"}
    <li><a href="{:Url('bus/busList')}">用车记录</a></li>
    {/if}
    {if condition="checkPath('bus/busUser')"}
    <li class="active"><a href="{:Url('bus/busUser')}">股份列表</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" class="form-control" value="{:input('num')}"  placeholder="车牌号码" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="股东姓名" type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                    </div>
                    {if condition="checkPath('bus/importBusUser')"}
                    <div class="btn-group">
                        <div class="btn btn-success import" lay-data="{'url': '{:url('bus/importBusUser')}',accept:'file'}">导入股东</div>
                    </div>
                    {/if}
                    <div class="btn-group">
                        <a class="btn btn-default" href="__ImagePath__/download/template_bus_user.xlsx" download="股东导入表模板.xlsx">下载模板</a>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="80">车牌号码</th>
                <th width="80">股东姓名</th>
                <th width="80">股份比例</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td><span class="span-primary bus-detail" data-id="{$v.bus_id}">{$v.num}</span></td>
                    <td>{$v.name}</td>
                    <td>{if condition="checkPath('bus/editRate',['id'=>$v['id']])"}
                        <input class="form-control change-data select"  post-id="{$v.id}" post-url="{:url('bus/editRate')}" value="{$v.rate}">
                        {else}
                        {$v.editRate}
                        {/if}</td>
                    <td>
                        {if condition="checkPath('bus/busDelete',['id'=>$v['id']])"}
                        <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('bus/busUserDelete',['id'=>$v['id']])}">删除</a>
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {$page}
    </div>
<script>
//    查看详情
    $('.bus-detail').mouseover(function(){
        var id = $(this).attr("data-id");
        openLayer = layer.open({
            type: 2,
            title: '车辆详情',
            shadeClose: true,
            shade: false,
            area: ['400px', '500px'],
            content: "{:url('bus/busInfo','','')}/id/"+id,
        })
    }).mouseout(function(){
        layer.close(openLayer)
    });
</script>