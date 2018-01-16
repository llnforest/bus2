
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>部门名称</th>
                <td>
                    <input class="form-control text" type="text" name="name" value="{$info.name??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>与车关系</th>
                <td class="layui-form">
                    <input type="checkbox" data-name="is_bus" lay-skin="switch" lay-text="有关|无关" {$info.is_bus == 1?'checked':''} data-value="1|0">
                </td>
            </tr>
            <tr>
                <th>排序</th>
                <td>
                    <input class="form-control text" type="text" name="sort" value="{$info.sort??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="button" class="btn btn-success form-post " >保存</button>
                    <a class="btn btn-default active" href="JavaScript:history.go(-1)">返回</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
