<ul class="nav nav-tabs">
    {if condition="checkPath('wages/index')"}
    <li class="active"><a href="{:Url('wages/index')}">工资列表</a></li>
    {/if}
    {if condition="checkPath('wages/wagesAdd')"}
    <li><a href="{:Url('wages/wagesAdd')}">添加工资</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="员工姓名" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="发放起始日期" readonly dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="发放结束日期" readonly dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                    </div>
                    {if condition="checkPath('wages/importWages')"}
                    <div class="btn-group">
                        <div class="btn btn-success import" lay-data="{'url': '{:url('wages/importWages')}',accept:'file'}">导入工资</div>
                    </div>
                    {/if}
                    <div class="btn-group">
                        <a class="btn btn-default" href="__ImagePath__/download/template_wages.xlsx" download="工资导入表模板.xlsx">下载模板</a>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="80">员工姓名</th>
                <th width="60">基本工资<span order="a.base_wages" class="order-sort"> </span></th>
                <th width="60">额外工资</th>
                <th width="60">应发工资<span order="a.yingfa" class="order-sort"> </span></th>
                <th width="60">扣除工资</th>
                <th width="60">实际发放<span order="a.shifa" class="order-sort"> </span></th>
                <th width="60">发放日期<span order="a.wages_date" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.user_name}</td>
                    <td>{$v.base_wages}</td>
                    <td>{$v['jintie']+$v['shebaobutie']+$v['manqin']+$v['gongling']+$v['jiaban']+$v['youxiu']+$v['tuifuzhuang']+$v['qitafa']}</td>
                    <td>{$v.yingfa}</td>
                    <td>{$v['queqin']+$v['qingjia']+$v['kuanggong']+$v['chidao']+$v['shebao']+$v['suodeshui']+$v['yajin']+$v['guoshi']+$v['canju']+$v['qitakou']}</td>
                    <td>{$v.shifa}</td>
                    <td>{$v.wages_date}</td>
                    <td>
                        {if condition="checkPath('wages/wagesEdit',['id'=>$v['id']])"}
                        <a  href="{:url('wages/wagesEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('wages/wagesDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('wages/wagesDelete',['id'=>$v['id']])}">删除</a>
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