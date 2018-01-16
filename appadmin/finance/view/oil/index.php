<ul class="nav nav-tabs">
    {if condition="checkPath('oil/index')"}
    <li class="active"><a href="{:Url('oil/index')}">油卡列表</a></li>
    {/if}
    {if condition="checkPath('oil/oilAdd')"}
    <li><a href="{:Url('oil/oilAdd')}">添加油卡</a></li>
    {/if}
    {if condition="checkPath('oil/oilIn')"}
    <li><a href="{:Url('oil/oilIn')}">充值记录</a></li>
    {/if}
    {if condition="checkPath('oil/oilOut')"}
    <li><a href="{:Url('oil/oilOut')}">加油记录</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="name" value="{:input('name')}" placeholder="油卡名称" class="form-control"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="购买起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="购买截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="80">购买面值<span order="a.money" class="order-sort"> </span></th>
                <th width="80">购买金额<span order="a.ture_money" class="order-sort"> </span></th>
                <th width="80">充值面值<span order="b.in_money" class="order-sort"> </span></th>
                <th width="80">充值金额<span order="b.in_true" class="order-sort"> </span></th>
                <th width="80">加油面值<span order="c.out_money" class="order-sort"> </span></th>
                <th width="80">剩余面值<span order="follow_money" class="order-sort"> </span></th>
                <th width="80">购买日期<span order="a.buy_date" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{$v.money?:0}</td>
                    <td>{$v.true_money?:0}</td>
                    <td>{$v.in_money?:0}</td>
                    <td>{$v.in_true?:0}</td>
                    <td>{$v.out_money?:0}</td>
                    <td>{$v.follow_money?:0}</td>
                    <td>{$v.buy_date?:0}</td>
                    <td>
                        {if condition="checkPath('oil/oilEdit',['id'=>$v['id']])"}
                        <a  href="{:url('oil/oilEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('oil/addOilIn',['id'=>$v['id']])"}
                        <a  href="{:url('oil/addOilIn',['id'=>$v['id']])}">充值</a>
                        {/if}
                        {if condition="checkPath('oil/addOilOut',['id'=>$v['id']])"}
                        <a  href="{:url('oil/addOilOut',['id'=>$v['id']])}">加油</a>
                        {/if}
                        {if condition="checkPath('oil/oilIn',['oil_id'=>$v['id']])"}
                        <a  href="{:url('oil/oilIn',['oil_id'=>$v['id']])}">充值记录</a>
                        {/if}
                        {if condition="checkPath('oil/oilOut',['oil_id'=>$v['id']])"}
                        <a  href="{:url('oil/oilOut',['oil_id'=>$v['id']])}">加油记录</a>
                        {/if}
                        {if condition="checkPath('oil/oilDelete',['id'=>$v['id']])"}
                            <span  class="span-post" post-msg="此操作将同步删除该油卡的充值和加油记录" post-url="{:url('oil/oilDelete',['id'=>$v['id']])}">删除</span>
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