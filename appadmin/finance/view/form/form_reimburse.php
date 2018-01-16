
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>报销项目</th>
                <td>
                    <input class="form-control text" type="text" name="title" value="{$info.title??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>选择员工</th>
                <td>
                    <span class="span-primary select-user">{$info.user_name?:'选择员工'}</span>
                    <input id="user_id" class="form-control text" type="hidden" name="user_id" value="{$info.user_id??''}">
                </td>
            </tr>
            <tr>
                <th>选择部门</th>
                <td>
                    <div class="layui-form select">
                        <select name="department_id" class="form-control" lay-verify="">
                            {foreach $department as $v}
                            <option value="{$v.id}" {$info.department_id == $v.id?'selected':''}>{$v.name}</option>
                            {/foreach}
                        </select>
                        
                    </div>
                </td>
            </tr>
            <tr>
                <th>报销金额</th>
                <td>
                    <input class="form-control text" type="text" name="fee" value="{$info.fee??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>报销日期</th>
                <td>
                    <input name="reimburse_date" value="{$info.reimburse_date??''}"  readonly dom-class="end-date" class="date-time end-date form-control laydate-icon text"  type="text">
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
<script>
    $(function(){
        //选择用户
        $('.select-user').click(function(){
            var id = $("#user_id").val();
            layer.open({
                type: 2,
                title: '员工选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('reimburse/userSelect','','')}/id/"+id,
            })
        });


    })
</script>
