<ul class="nav nav-tabs">
    {if condition="checkPath('bus/index')"}
    <li><a href="{:Url('bus/index')}">车辆列表</a></li>
    {/if}
    {if condition="checkPath('bus/busAdd')"}
    <li><a href="{:Url('bus/busAdd')}">添加车辆</a></li>
    {/if}
    {if condition="checkPath('bus/busList')"}
    <li class="active"><a href="{:Url('bus/busList')}">用车记录</a></li>
    {/if}
    {if condition="checkPath('bus/busUser')"}
    <li><a href="{:Url('bus/busUser')}">股份列表</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" class="form-control" value="{:input('num')}"  placeholder="车牌号码" type="text" readonly>
                    </div>
                    <div class="btn-group">
                        <input name="order_id" class="form-control" value="{:input('order_id')}"  placeholder="订单编号" type="text">
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
                <th width="80">订单编号</th>
                <th width="80">车牌号码</th>
                <th width="60">调度状态</th>
                <th width="60">出发日期</th>
                <th width="60">回车日期</th>
                <th width="130">派单时间<span order="create_time" class="order-sort"> </span></th>
                <th width="130">调度时间<span order="update_time" class="order-sort"> </span></th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.order_id}</td>
                    <td>{$v.num}</td>
                    <td>{if $v.status == 1}租用途中{elseif $v.status == 2}<span class="blue">已回车</span>{elseif $v.status == 3}<span class="grey">取消接单</span>{else}<span class="red">待接单</span>{/if}</td>
                    <td>{$v.start_date}</td>
                    <td>{$v.end_date}</td>
                    <td>{$v.create_time}</td>
                    <td>{$v.update_time}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {$page}
    </div>