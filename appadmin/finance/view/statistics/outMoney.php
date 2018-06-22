<ul class="nav nav-tabs">
    {if condition="checkPath('statistics/inMoney')"}
    <li class="active"><a href="{:Url('order/index')}">收款统计</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="id" class="form-control" value="{:input('id')}"  placeholder="系统编号" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="num" class="form-control" value="{:input('num')}"  placeholder="车牌号码" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="起始时间" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="截止时间" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                        {if checkPath('statistics/exportOutMoney')}
                        <button type="button" class="btn btn-success download">导出</button>
                        {/if}
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="80">系统编号</th>
                <th width="80">车牌号码</th>
                <th width="80">车辆归属</th>
                <th width="80">路线</th>
                <th width="80">公里数</th>
                <th width="80">趟数</th>
                <th width="80">付款金额</th>
                <th width="80">现收金额</th>
                <th width="80">税款</th>
                <th width="80">应付金额</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.id}</td>
                    <td>{$v.num}</td>
                    <td>{$v.name}</td>
                    <td><div>出发:{$v.start_date|date_create|date_format='Y-m-d H:i'}</div><div>结束:{$v.end_date|date_create|date_format='Y-m-d H:i'}</div></td>
                    <td>{$v.km}</td>
                    <td>{$v.times}</td>
                    <td>{$v.pay_money}</td>
                    <td>{$v.xianshou}</td>
                    <td>{$v.taxation}</td>
                    <td>{$v.pay_money-$v.taxation-$v.xianshou}
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
            url = "{:url('statistics/exportOutMoney')}?"+$("#searchFrom").serialize();
            window.location.href = url;
        });

    })
</script>