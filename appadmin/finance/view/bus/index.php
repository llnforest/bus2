<ul class="nav nav-tabs">
    {if condition="checkPath('bus/index')"}
    <li class="active"><a href="{:Url('bus/index')}">进货配件费用</a></li>
    {/if}
    {if condition="checkPath('bus/illegal')"}
    <li><a href="{:Url('bus/illegal')}">违章罚款费用</a></li>
    {/if}
    {if condition="checkPath('bus/protect')"}
    <li><a href="{:Url('bus/protect')}">维修保养费用</a></li>
    {/if}
    {if condition="checkPath('bus/check')"}
    <li><a href="{:Url('bus/check')}">年检费用</a></li>
    {/if}
    {if condition="checkPath('bus/accident')"}
    <li><a href="{:Url('bus/accident')}">事故理赔</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group layui-form">
                        <select name="machine_id" class="form-control" lay-verify="">
                            <option value="">往来单位</option>
                            {foreach $machine as $v}
                            <option value="1" {if input('machine_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="user_name" value="{:input('user_name')}" placeholder="进货员工" class="form-control"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="进货起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="进货截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="80">配件名称</th>
                <th width="80">进货员工</th>
                <th width="80">进货量<span order="num" class="order-sort"> </span></th>
                <th width="80">进货日期<span order="in_date" class="order-sort"> </span></th>
                <th width="50">进货费用<span order="money" class="order-sort"> </span></th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.machine_name}</td>
                    <td>{$v.user_name}</td>
                    <td>{$v.num}</td>
                    <td>{$v.in_date}</td>
                    <td>
                        {if checkPath('bus/editMachineMoney',['type'=>1])}
                        <input type="text" value="{$v.money != 0?$v.money:''}" post-url="{:url('bus/editMachineMoney')}" post-id="{$v.id}" class="change-data form-control input-money" placeholder="0">
                        {else}
                        {$v.money}
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