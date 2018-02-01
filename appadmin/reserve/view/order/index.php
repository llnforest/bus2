<ul class="nav nav-tabs">
    {if condition="checkPath('order/index')"}
    <li class="active"><a href="{:Url('order/index')}">订单管理</a></li>
    {/if}
    {if condition="checkPath('order/orderAdd')"}
    <li><a href="{:Url('order/orderAdd')}">添加订单</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="id" class="form-control" value="{:input('id')}"  placeholder="订单编号" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="客户名称" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="">结账类型</option>
                            <option value="1" {if input('type') == 1}selected{/if}>全包</option>
                            <option value="2" {if input('type') == 2}selected{/if}>净价</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="status" class="form-control" lay-verify="">
                            <option value="">订单状态</option>
                            <option value="0" {if input('status') === '0'}selected{/if}>待派单</option>
                            <option value="1" {if input('status') == 1}selected{/if}>已派单</option>
                            <option value="2" {if input('status') == 2}selected{/if}>交易成功</option>
                            <option value="3" {if input('status') == 3}selected{/if}>交易取消</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="结束日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                        {if checkPath('order/exportOut')}
                        <button type="button" class="btn btn-success download">导出</button>
                        {/if}
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="60">订单编号</th>
                <th width="70">客户名称</th>
                <th width="55">状态</th>
                <th width="70">订单类型</th>
                <th width="70">结账类型</th>
                <th width="70">总额</th>
                <th width="70">结账类目</th>
                <th width="100">行车时间<span order="start_date" class="order-sort"> </span></th>
                <th width="115">行车路线</th>
                <th width="45">人数</th>
                <th width="70">设备要求</th>
                <th width="45">备注</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td><span class="span-primary order-detail" data-id="{$v.id}">{$v.id}</span></td>
                    <td>{$v.name}</td>
                    <td>{if $v.status == 1}已派单{elseif $v.status == 2}<span class="blue">交易成功</span>{elseif $v.status == 3}<span class="grey">交易取消</span>{else}<span class="red">待派单</span>{/if}</td>
                    <td>{if $v.order_type == 1}普通班次{elseif $v.order_type == 2}交通车{else}团车{/if}</td>
                    <td>{if $v.type == 1}全包{elseif $v.type == 2}净价{/if}</td>
                    <td>
                        {if $v.order_type == 1}
                        <p>合同:{$v.total_money}</p>
                            {if $v.status == 2}
                            <p>付款:{$v.true_money}</p>
                            {/if}
                        {else}
                            {if $v.status == 2}
                            <p>合同:{$v.total_money}</p>
                            <p>付款:{$v.true_money}</p>
                            {elseif $v.status == 3}
                            <p>合同:{$v.total_money}</p>
                            {else}
                            --
                            {/if}
                        {/if}
                        {if $v.return_money}<span class="span-primary rg-margin" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                                  data-content="返利{$v.return_money}元">返利</span>{/if}
                        {if $v.taxation}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                                  data-content="税款{$v.taxation}元">税款</span>{/if}
                    </td>
                    <td>
                        {if $v.xianshou}<p>现收:{$v.xianshou}</p>{/if}
                        {if $v.duishou}<p>队收:{$v.duishou}</p>{/if}
                        {if ($v.order_type == 1 || $v.status == 2) && $v.total_money-$v.xianshou-$v.duishou != 0}<p class="red">未收:{$v.total_money-$v.xianshou-$v.duishou}</p>{/if}
                    </td>
                    <td><div>出发:{$v.start_date|date_create|date_format='Y-m-d H:i'}</div><div>结束:{$v.end_date|date_create|date_format='Y-m-d H:i'}</div></td>
                    <td><div><span class="blue">起:</span>{$v.start_prov}{$v.start_city}{$v.start_area}{$v.start_address}</div><div><span class="red">终:</span>{$v.end_prov}{$v.end_city}{$v.end_area}{$v.end_address}</div></td>
                    <td>{if ($v.order_type == 1 || $v.status == 2) && $v.order_type != 2}
                        {$v.num}
                        {else}
                        --
                        {/if}
                    </td>
                    <td>
                        {if $v.is_air}空凋 {/if} {if $v.is_tv}电视 {/if} {if $v.is_microphone}麦克风 {/if} {if $v.is_bathroom}卫生间{/if}
                    </td>
                    <td>{if $v.remark}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                                  data-content="{$v.remark}">明细</span>{/if}</td>
                    <td>
                        {if condition="checkPath('order/selectBus',['id'=>$v['id']]) && $v.status == 0"}
                        <a  href="{:url('order/selectBus',['id'=>$v['id']])}">单次派车</a>
                        {/if}
                        {if condition="checkPath('order/selectAnyBus',['id'=>$v['id']]) && $v.status == 0"}
                        <a  href="{:url('order/selectAnyBus',['id'=>$v['id']])}">分批派车</a>
                        {/if}
                        {if condition="checkPath('order/orderSend',['id'=>$v['id']]) && $v.status == 0 && $v.record_id"}
                        <span class="span-post" post-msg="确定已派车完成了吗" post-url="{:url('order/orderSend',['id'=>$v['id']])}">确认派车</span>
                        {/if}
                        {if condition="checkPath('record/index',['order_id'=>$v['id']])"}
                        <a  href="{:url('record/index',['style' => 1,'order_id'=>$v['id']])}">调度记录</a>
                        {/if}
                        {if condition="checkPath('order/orderFollow',['id'=>$v['id']])"}
                        <a  href="{:url('order/orderFollow',['id'=>$v['id']])}">备注</a>
                        {/if}
                        {if condition="checkPath('order/orderStatus',['id'=>$v['id']]) && $v.status == 0"}
                            <span class="span-post" post-msg="确定要关闭订单吗" post-url="{:url('order/editStatus',['id'=>$v['id']])}">关闭订单</span>
                        {/if}
                        {if condition="checkPath('order/orderEdit',['id'=>$v['id']]) && $v.is_sure == 0 && $v.status != 3"}
                        <a  href="{:url('order/orderEdit',['id'=>$v['id']])}">修改</a>
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
    $(function(){
        $(".download").click(function(){
            url = "{:url('order/exportOut')}?start="+getQueryString('start')+"&end="+getQueryString('end')+"&name="+getQueryString('name')+"&id="+getQueryString('id')+"&status="+getQueryString('status')+"&type="+getQueryString('type');
            setTimeout(function() {
                window.location.href = url;
            },1000);
        });
        //查看详情
        $('.order-detail').click(function(){
            var id = $(this).attr("data-id");
            openLayer = layer.open({
                type: 2,
                title: '订单详情',
                shadeClose: true,
                shade: false,
                area: ['400px', '420px'],
                content: "{:url('order/orderInfo','','')}/id/"+id,
            })
        })
    })
</script>