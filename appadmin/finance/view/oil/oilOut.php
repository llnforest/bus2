<ul class="nav nav-tabs">
    {if condition="checkPath('oil/index')"}
    <li><a href="{:Url('oil/index')}">油卡列表</a></li>
    {/if}
    {if condition="checkPath('oil/oilAdd')"}
    <li><a href="{:Url('oil/oilAdd')}">添加油卡</a></li>
    {/if}
    {if condition="checkPath('oil/oilIn')"}
    <li><a href="{:Url('oil/oilIn')}">充值记录</a></li>
    {/if}
    {if condition="checkPath('oil/oilOut')"}
    <li class="active"><a href="{:Url('oil/oilOut')}">加油记录</a></li>
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
                        <input name="num" value="{:input('num')}" placeholder="加油车辆" class="form-control"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="加油起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="加油截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="80">加油车辆</th>
                <th width="80">加油站</th>
                <th width="80">加油金额<span order="a.fee" class="order-sort"> </span></th>
                <th width="50">加油日期<span order="a.out_date" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.oil_name}</td>
                    <td>{$v.bus_num}</td>
                    <td>{$v.contact_name}</td>
                    <td>{$v.fee}</td>
                    <td>{$v.out_date}</td>
                    <td>
                        {if condition="checkPath('oil/oilOutDelete',['id'=>$v['id']])"}
                            <span  class="span-post" post-msg="确定要删除吗" post-url="{:url('oil/oilOutDelete',['id'=>$v['id']])}">删除</span>
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