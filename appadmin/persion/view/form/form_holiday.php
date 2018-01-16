
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>选择员工</th>
                <td>
                    <span class="span-primary select-user">{$info.name?:'选择员工'}</span>
                    <input id="user_id" class="form-control text" type="hidden" name="user_id" value="{$info.user_id??''}">
                </td>
            </tr>
            <tr>
                <th>开始日期</th>
                <td>
                    <input name="start_date" value="{$info.start_date??''}"  readonly dom-class="start-date" class="date-time start-date form-control laydate-icon text"  type="text">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>结束日期</th>
                <td>
                    <input name="end_date" value="{$info.end_date??''}"  readonly dom-class="end-date" class="date-time end-date form-control laydate-icon text"  type="text">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>请假天数</th>
                <td>
                    <input class="form-control text" type="text" name="days" value="{$info.days??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>请假类型</th>
                <td>
                    <div class="layui-form select">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="1" {$info.type == 1?'selected':''}>事假</option>
                            <option value="2" {$info.type == 2?'selected':''}>病假</option>
                            <option value="3" {$info.type == 3?'selected':''}>其他</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <th>请假备注</th>
                <td>
                    <textarea name="remark" class="form-control text">{$info.remark??''}</textarea>
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
                content: "{:url('holiday/userSelect','','')}/id/"+id,
            })
        });


    })
</script>
