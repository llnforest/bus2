<ul class="nav nav-tabs">
    {if condition="checkPath('machine/index')"}
    <li class="active"><a href="{:Url('machine/index')}">配件列表</a></li>
    {/if}
    {if condition="checkPath('machine/machineAdd')"}
    <li><a href="{:Url('machine/machineAdd')}">添加配件</a></li>
    {/if}
    {if condition="checkPath('machine/machineIn')"}
    <li><a href="{:Url('machine/machineIn')}">进货记录</a></li>
    {/if}
    {if condition="checkPath('machine/machineOut')"}
    <li><a href="{:Url('machine/machineOut')}">领用记录</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="name" value="{:input('name')}" placeholder="配件名称" class="form-control"  type="text">
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
                <th width="80">名称</th>
                <th width="80">进货量<span order="in_num" class="order-sort"> </span></th>
                <th width="80">领用量<span order="out_num" class="order-sort"> </span></th>
                <th width="80">库存量<span order="follow_num" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{$v.in_num?:0}</td>
                    <td>{$v.out_num?:0}</td>
                    <td>{$v.follow_num?:0}</td>
                    <td>
                        {if condition="checkPath('machine/machineEdit',['id'=>$v['id']])"}
                        <a  href="{:url('machine/machineEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('machine/operateAdd',['id'=>$v['id'],'type'=>1])"}
                        <a  href="{:url('machine/operateAdd',['id'=>$v['id'],'type'=>1])}">进货</a>
                        {/if}
                        {if condition="checkPath('machine/operateAdd',['id'=>$v['id'],'type'=>2])"}
                        <a  href="{:url('machine/operateAdd',['id'=>$v['id'],'type'=>2])}">领用</a>
                        {/if}
                        {if condition="checkPath('machine/machineIn',['machine_id'=>$v['id']])"}
                        <a  href="{:url('machine/machineIn',['machine_id'=>$v['id']])}">进货记录</a>
                        {/if}
                        {if condition="checkPath('machine/machineOut',['machine_id'=>$v['id']])"}
                        <a  href="{:url('machine/machineOut',['machine_id'=>$v['id']])}">领用记录</a>
                        {/if}
                        {if condition="checkPath('machine/machineDelete',['id'=>$v['id']])"}
                            <span  class="span-post" post-msg="此操作将同步删除该配件的领用和进货记录" post-url="{:url('machine/machineDelete',['id'=>$v['id']])}">删除</span>
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