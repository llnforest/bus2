<ul class="nav nav-tabs">
    {if condition="checkPath('machine/index')"}
    <li><a href="{:Url('machine/index')}">配件列表</a></li>
    {/if}
    {if condition="checkPath('machine/machineAdd')"}
    <li><a href="{:Url('machine/machineAdd')}">添加配件</a></li>
    {/if}
    {if condition="checkPath('machine/machineIn')"}
    <li class="active"><a href="{:Url('machine/machineIn')}">进货记录</a></li>
    {/if}
    {if condition="checkPath('machine/machineOut')"}
    <li><a href="{:Url('machine/machineOut')}">领用记录</a></li>
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
                <th width="80">进货量<span order="a.num" class="order-sort"> </span></th>
                <th width="80">进货费用<span order="money" class="order-sort"> </span></th>
                <th width="50">进货日期<span order="in_date" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.machine_name}</td>
                    <td>{$v.user_name}</td>
                    <td>{$v.num}</td>
                    <td>{$v.money?:'--'}</td>
                    <td>{$v.in_date}</td>
                    <td>
                        {if condition="checkPath('machine/operateEdit',['id'=>$v['id'],'type'=>1])"}
                        <a  href="{:url('machine/operateEdit',['id'=>$v['id'],'type'=>1])}">编辑</a>
                        {/if}
                        {if condition="checkPath('machine/machineInDelete',['id'=>$v['id']])"}
                            <span  class="span-post" post-msg="确定要删除吗" post-url="{:url('machine/machineInDelete',['id'=>$v['id']])}">删除</span>
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