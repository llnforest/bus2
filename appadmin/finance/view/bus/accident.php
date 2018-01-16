<ul class="nav nav-tabs">
    {if condition="checkPath('bus/index')"}
    <li><a href="{:Url('bus/index')}">进货配件费用</a></li>
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
    <li class="active"><a href="{:Url('bus/accident')}">事故理赔</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" value="{:input('num')}" placeholder="车牌号" class="form-control"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="num" value="{:input('name')}" placeholder="驾驶员" class="form-control"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="事发起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="事发截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="80">车牌号</th>
                <th width="80">驾驶员</th>
                <th width="80">维修点</th>
                <th width="60">保险公司</th>
                <th width="50">备注</th>
                <th width="120">事发日期<span order="a.accident_date" class="order-sort"> </span></th>
                <th width="120">创建时间<span order="a.create_time" class="order-sort"> </span></th>
                <th width="60">损失金额<span order="a.lose" class="order-sort"> </span></th>
                <th width="60">保险理赔<span order="a.insurance_money" class="order-sort"> </span></th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.num}</td>
                    <td>{$v.name}</td>
                    <td>{$v.repair_name}</td>
                    <td>{$v.contact_name}</td>
                    <td>{if $v.remark}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                            data-content="{$v.remark}">明细</span>{/if}</td>
                    <td>{$v.accident_date}</td>
                    <td>{$v.create_time}</td>
                    <td>{if checkPath('bus/editAccidentMoney',['type'=>1])}<input type="text" value="{$v.lose != 0?$v.lose:''}" post-url="{:url('bus/editAccidentMoney',['type'=>1])}" post-id="{$v.id}" class="change-data form-control input-money" placeholder="0">{else}{$v.lose}{/if}</td>
                    <td>{if checkPath('bus/editAccidentMoney',['type'=>2])}<input type="text" value="{$v.insurance_money != 0?$v.insurance_money:''}" post-url="{:url('bus/editAccidentMoney',['type'=>2])}" post-id="{$v.id}" class="change-data form-control input-money" placeholder="0">{else}{$v.insurance_money}{/if}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {$page}
    </div>