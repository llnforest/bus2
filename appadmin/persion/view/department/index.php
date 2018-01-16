<ul class="nav nav-tabs">
    {if condition="checkPath('department/index')"}
    <li class="active"><a href="{:Url('department/index')}">部门列表</a></li>
    {/if}
    {if condition="checkPath('department/departmentAdd')"}
    <li><a href="{:Url('department/departmentAdd')}">添加部门</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="部门名称" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="is_bus" class="form-control" lay-verify="">
                            <option value="">全部</option>
                            <option value="1" {if input('is_bus') == 1}selected{/if}>与车有关</option>
                            <option value="0" {if input('is_bus') === '0'}selected{/if}>与车无关</option>
                        </select>
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
                <th>部门名称</th>
                <th width="80">与车关系</th>
                <th width="80">排序</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
           {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{if $v.is_bus == 1}有关{else}无关{/if}</td>
                    <td>{if condition="checkPath('department/orderSort',['id'=>$v['id']])"}
                        <input class="form-control change-data"  post-id="{$v.id}" post-url="{:url('department/orderSort')}" value="{$v.sort}">
                        {else}
                        {$v.sort}
                        {/if}
                    </td>
                    <td>
                        {if condition="checkPath('department/departmentEdit',['id'=>$v['id']])"}
                        <a  href="{:url('department/departmentEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('department/departmentDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('department/departmentDelete',['id'=>$v['id']])}">删除</a>
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