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
    <li><a href="{:Url('record/index')}">调度管理</a></li>
    {/if}
    {if condition="checkPath('record/recordStatistics')"}
    <li class="active"><a href="{:Url('record/recordStatistics')}">调度统计</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" class="form-control" value="{:input('num')}"  placeholder="车牌号码" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="status" class="form-control" lay-verify="">
                            <option value="">全部调度</option>
                            <option value="2" {if input('status') == 2}selected{/if}>成功调度</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="corporation_id" class="form-control">
                            <option value="">选择归属</option>
                            {foreach $corporation as $v}
                            <option value="{$v.id}" {if input('corporation_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
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
                        {if checkPath('record/exportOutStatistics')}
                        <button type="button" class="btn btn-success download">导出</button>
                        {/if}
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="80">车牌号码</th>
                <th width="80">车辆归属</th>
                <th width="80">调度次数</th>
                <th width="80">调度总金额</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td><span class="span-primary bus-detail" data-id="{$v.bus_id}">{$v.num}</span></td>
                    <td>{$v.name}</td>
                    <td>{$v.total_times}</td>
                    <td>{$v.total_money}</td>
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
            url = "{:url('record/exportOutStatistics')}?start="+getQueryString('start')+"&end="+getQueryString('end')+"&num="+getQueryString('num')+"&status="+getQueryString('status')+"&corporation_id="+getQueryString('corporation_id');
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