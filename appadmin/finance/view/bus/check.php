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
    <li class="active"><a href="{:Url('bus/check')}">年检费用</a></li>
    {/if}
    {if condition="checkPath('bus/accident')"}
    <li><a href="{:Url('bus/accident')}">事故理赔</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" value="{:input('num')}" placeholder="车牌号" class="form-control"  type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="contact_id" class="form-control" lay-verify="">
                            <option value="">检测站</option>
                            {foreach $contact as $v}
                            <option value="{$v.id}" {if input('contact_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group">年检日期:</div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="年检起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="年检截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">到期日期:</div>
                    <div class="btn-group">
                        <input name="start_date" value="{:input('start_date')}" placeholder="到期起始日期" dom-class="date-start-end" class="date-time date-start-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end_date" value="{:input('end_date')}" placeholder="到期截止日期" dom-class="date-end-end" class="date-time date-end-end form-control laydate-icon"  type="text">
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
                <th width="60">检测站</th>
                <th width="80">年检日期<span order="a.check_date" class="order-sort"> </span></th>
                <th width="80">到期日期<span order="a.end_date" class="order-sort"> </span></th>
                <th width="60">年检费用<span order="a.fee" class="order-sort"> </span></th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.num}</td>
                    <td>{$v.name}</td>
                    <td>{$v.check_date}</td>
                    <td>{$v.end_date}</td>
                    <td>
                        {if checkPath('bus/editCheckMoney',['type'=>1])}
                        <input type="text" value="{$v.fee != 0?$v.fee:''}" post-url="{:url('bus/editCheckMoney')}" post-id="{$v.id}" class="change-data form-control input-money" placeholder="0">
                        {else}
                        {$v.fee}
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