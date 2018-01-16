<ul class="nav nav-tabs">
    {if condition="checkPath('oil/index')"}
    <li><a href="{:Url('oil/index')}">油卡列表</a></li>
    {/if}
    {if condition="checkPath('oil/oilAdd')"}
    <li><a href="{:Url('oil/oilAdd')}">添加油卡</a></li>
    {/if}
    {if condition="checkPath('oil/oilIn')"}
    <li class="active"><a href="{:Url('oil/oilIn')}">充值记录</a></li>
    {/if}
    {if condition="checkPath('oil/oilOut')"}
    <li><a href="{:Url('oil/oilOut')}">加油记录</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group layui-form">
                        <select name="oil_id" class="form-control" lay-verify="">
                            <option value="">油卡名称</option>
                            {foreach $oil as $v}
                            <option value="1" {if input('oil_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="充值起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="充值截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="80">油卡名称</th>
                <th width="80">充值面值<span order="a.money" class="order-sort"> </span></th>
                <th width="80">充值金额<span order="a.true_money" class="order-sort"> </span></th>
                <th width="50">充值日期<span order="a.in_date" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.oil_name}</td>
                    <td>{$v.money}</td>
                    <td>{$v.true_money}</td>
                    <td>{$v.in_date}</td>
                    <td>
                        {if condition="checkPath('oil/oilInDelete',['id'=>$v['id']])"}
                            <span  class="span-post" post-msg="确定要删除吗" post-url="{:url('oil/oilInDelete',['id'=>$v['id']])}">删除</span>
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