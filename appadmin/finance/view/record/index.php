<ul class="nav nav-tabs">
    {if condition="checkPath('record/index')"}
    <li class="active"><a href="{:Url('record/index')}">发车单</a></li>
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
                        <select name="order_type" class="form-control" lay-verify="">
                            <option value="">订单类型</option>
                            <option value="1" {if input('order_type') == 1}selected{/if}>普通</option>
                            <option value="2" {if input('order_type') == 2}selected{/if}>交通</option>
                            <option value="3" {if input('order_type') == 3}selected{/if}>团车</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="corporation_id" class="form-control">
                            <option value="">单位选择</option>
                            {foreach $corporation as $v}
                            <option value="{$v.id}" {if input('corporation_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="回车起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="回车截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                        {if checkPath('record/exportOut')}
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
                <th width="70">车牌号码</th>
                <th width="80">用车人</th>
                <th width="60">金额</th>
                <th width="60">趟数</th>
                <th width="70">包车类型</th>
                <th width="70">包车方式</th>
                <th width="100">用车时间</th>
                <th width="100">用车行程</th>
                <th width="80">单位</th>
                <th width="110">回车时间<span order="update_time" class="order-sort"> </span></th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.order_id}</td>
                    <td><span class="span-primary bus-detail" data-id="{$v.bus_id}">{$v.num}</span></td>
                    <td>
                        {if $v.fir_name}<p><span class="blue">主:</span>{$v.fir_name}</p>{/if}
                        {if $v.sec_name}<p><span class="red">副:</span>{$v.sec_name}</p>{/if}
                    </td>
                    <td>{$v.money}</td>
                    <td>{$v.times}</td>
                    <td>{if $v.order_type == 1}普通班次{elseif $v.order_type == 2}交通车{else}团车{/if}</td>
                    <td>{if $v.money_type == 1}全包{elseif $v.money_type == 2}净价{/if}</td>
                    <td><div><span class="blue">开始:</span>{$v.start_time}</div><div><span class="red">结束:</span>{$v.end_time}</div></td>
                    <td><div><span class="blue">起:</span>{$v.start_prov}{$v.start_city}{$v.start_area}{$v.start_address}</div><div><span class="red">终:</span>{$v.end_prov}{$v.end_city}{$v.end_area}{$v.end_address}</div></td>
                    <td>{$v.corporation_name}</td>
                    <td>{$v.update_time}</td>
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
        $(".download").click(function(){
            url = "{:url('record/exportOut')}?start="+getQueryString('start')+"&end="+getQueryString('end')+"&order_id="+getQueryString('order_id')+"&num="+getQueryString('num')+"&corporation_id="+getQueryString('corporation_id')+"&order_type="+getQueryString('order_type');
            setTimeout(function() {
                window.location.href = url;
            },1000);
        });

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