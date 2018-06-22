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
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="客户名称" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="user_name" class="form-control" value="{:input('user_name')}"  placeholder="客户姓名" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="phone" class="form-control" value="{:input('phone')}"  placeholder="客户联系方式" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="起始时间" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="截止时间" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                        {if checkPath('statistics/exportInMoney')}
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
                <th width="80">客户</th>
                <th width="80">行程</th>
                <th width="80">路线</th>
                <th width="80">合同金额</th>
                <th width="80">现收金额</th>
                <th width="80">队收金额</th>
                <th width="80">未收金额</th>
                <th width="80">备注</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.id}</td>
                    <td>
                        <p>{$v.name}</p>
                        <p>{$v.user_name}</p>
                        <p>{$v.phone}</p>
                    </td>
                    <td><div>出发:{$v.start_date|date_create|date_format='Y-m-d H:i'}</div><div>结束:{$v.end_date|date_create|date_format='Y-m-d H:i'}</div></td>
                    <td><div><span class="blue">起:</span>{$v.start_prov}{$v.start_city}{$v.start_area}{$v.start_address}</div><div><span class="red">终:</span>{$v.end_prov}{$v.end_city}{$v.end_area}{$v.end_address}</div></td>
                    <td>{$v.total_money}</td>
                    <td>{$v.xianshou}</td>
                    <td>{$v.duishou}</td>
                    <td>{$v.total_money-$v.duishou-$v.xianshou}
                    <td>{if $v.remark}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                            data-content="{$v.remark}">明细</span>{/if}</td>
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
            url = "{:url('statistics/exportInMoney')}?"+$("#searchFrom").serialize();
            window.location.href = url;
        });

    })
</script>