<ul class="nav nav-tabs">
    {if input('style') == 1}
    {if condition="checkPath('order/index')"}
    <li><a href="{:Url('order/index')}">订单管理</a></li>
    {/if}
    {if condition="checkPath('order/orderAdd')"}
    <li><a href="{:Url('order/orderAdd')}">添加订单</a></li>
    {/if}
    {/if}
    {if condition="checkPath('record/index')"}
    <li class="active"><a href="{:Url('record/index')}">调度管理</a></li>
    {/if}
    {if condition="checkPath('record/recordStatistics')"}
    <li><a href="{:Url('record/recordStatistics')}">调度统计</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="order_id" class="form-control" value="{:input('order_id')}"  placeholder="订单编号" type="text" {if input('style') == 1}readonly{/if}>
                    </div>
                    <div class="btn-group">
                        <input name="num" class="form-control" value="{:input('num')}"  placeholder="车牌号码" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="status" class="form-control" lay-verify="">
                            <option value="">调度状态</option>
                            <option value="0" {if input('status') === '0'}selected{/if}>待接单</option>
                            <option value="1" {if input('status') == 1}selected{/if}>租用途中</option>
                            <option value="2" {if input('status') == 2}selected{/if}>已回车</option>
                            <option value="3" {if input('status') == 3}selected{/if}>取消接单</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="order_type" class="form-control" lay-verify="">
                            <option value="">订单类型</option>
                            <option value="1" {if input('order_type') == 1}selected{/if}>普通</option>
                            <option value="2" {if input('order_type') == 2}selected{/if}>交通</option>
                            <option value="3" {if input('order_type') == 3}selected{/if}>团车</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="派单起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="派单截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="60">订单编号</th>
                <th width="70">车牌号码</th>
                <th width="80">调度状态</th>
                <th width="80">出发日期</th>
                <th width="80">回车日期</th>
                <th width="130">派单时间<span order="create_time" class="order-sort"> </span></th>
                <th width="130">调度时间<span order="update_time" class="order-sort"> </span></th>
                <th width="60">趟数</th>
                <th width="60">公里</th>
                <th width="60">人数</th>
                <th width="60">金额</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.order_id}</td>
                    <td><span class="span-primary bus-detail" data-id="{$v.bus_id}">{$v.num}</span></td>
                    <td>{if $v.status == 1}租用途中{elseif $v.status == 2}<span class="blue">已回车</span>{elseif $v.status == 3}<span class="grey">取消接单</span>{else}<span class="red">待接单</span>{/if}
                    ({if $v.order_type == 1}普通{elseif $v.order_type == 2}交通{else}团车{/if})
                    </td>
                    <td>{$v.start_date}</td>
                    <td>{$v.end_date}</td>
                    <td>{$v.create_time}</td>
                    <td>{$v.update_time}</td>
                    <td>{if checkPath('record/editDatas',['type'=>1]) && !in_array($v.status,[2,3])}<input type="text" value="{$v.times != 0?$v.times:''}" post-url="{:url('record/editDatas',['type'=>1])}" post-id="{$v.id}" class="change-data form-control input-money" placeholder="0">{else}{$v.times != 0?$v.times:'--'}{/if}</td>
                    <td>{if checkPath('record/editDatas',['type'=>2]) && !in_array($v.status,[2,3]) && $v.order_type == 3}}<input type="text" value="{$v.km != 0?$v.km:''}" post-url="{:url('record/editDatas',['type'=>2])}" post-id="{$v.id}" class="change-data form-control input-money" placeholder="0">{else}{$v.km != 0?$v.km:'--'}{/if}</td>
                    <td>{if checkPath('record/editDatas',['type'=>3]) && !in_array($v.status,[2,3]) && $v.order_type != 2}<input type="text" value="{$v.number != 0?$v.number:''}" post-url="{:url('record/editDatas',['type'=>3])}" post-id="{$v.id}" class="change-data form-control input-money" placeholder="0">{else}{$v.number != 0?$v.number:'--'}{/if}</td>
                    <td>{if checkPath('record/editDatas',['type'=>4]) && !in_array($v.status,[2,3])}<input type="text" value="{$v.money != 0?$v.money:''}" post-url="{:url('record/editDatas',['type'=>4])}" post-id="{$v.id}" class="change-data form-control input-money" placeholder="0">{else}{$v.money != 0?$v.money:'--'}{/if}</td>
                    <td>
                        {if condition="checkPath('record/editStatus',['id'=>$v['id']]) && $v.status == 0"}
                            <span class="span-post" post-url="{:url('record/editReceive',['style'=>input('style'),'order_id'=>input('order_id'),'id'=>$v['id']])}">接单出发</span>
                        {/if}
                        {if condition="checkPath('record/editStatus',['id'=>$v['id']]) && $v.status == 1"}
                            <span class="span-post" post-url="{:url('record/editBack',['style'=>input('style'),'order_id'=>input('order_id'),'id'=>$v['id']])}">已回车</span>
                        {/if}
                        {if condition="checkPath('record/editOff',['id'=>$v['id']]) && !in_array($v.status,[2,3])"}
                            <span class="span-post" post-url="{:url('record/editOff',['style'=>input('style'),'order_id'=>input('order_id'),'id'=>$v['id']])}">取消接单</span>
                        {/if}
                        {if condition="checkPath('record/recordFollow',['id'=>$v['id']])"}
                        <a  href="{:url('record/recordFollow',['id'=>$v['id']])}">调度备注</a>
                        {/if}
                        {if condition="checkPath('record/recordDelete',['id'=>$v['id']]) && $v.status == 3"}
                            <span  class="span-post" post-msg="确定要删除吗" post-url="{:url('record/recordDelete',['style'=>input('style'),'order_id'=>input('order_id'),'id'=>$v['id']])}">删除</span>
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
<style>
    .input-money{
        width:60px !important;
    }
</style>
<script>
    $(function(){
        //查看详情
        $('.bus-detail').mouseover(function(){
            var id = $(this).attr("data-id");
            openLayer = layer.open({
                type: 2,
                title: '车辆详情',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('bus/bus/busInfo','','')}/id/"+id,
            })
        }).mouseout(function(){
            layer.close(openLayer)
        });

    })
</script>