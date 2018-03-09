
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>选择车牌号</th>
                <td>
                    <span class="span-primary select-bus fl">{$info.num?:'选择车牌号'}</span>
                    <input id="bus_id" class="form-control" type="hidden" name="bus_id" value="{$info.bus_id??''}">
                </td>
            </tr>
            <tr>
                <th>监测站</th>
                <td>
                    <div class="layui-form select">
                        <select name="contact_id" class="form-control text" lay-verify="">
                            <option value="0">选择监测站</option>
                            {foreach $contact as $v}
                            <option value="{$v.id}" {if !empty($info) && $info.contact_id == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                        <span class="form-required">*</span>
                </td>
            </tr>
            <tr class="hidden">
                <th>年检费用</th>
                <td>
                    <input class="form-control text" type="text" name="fee" value="{$info.fee??'0'}" placeholder="年检费用">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>年检日期</th>
                <td>
                    <input name="check_date" value="{$info.check_date??''}"  readonly dom-class="check-date" class="date-time check-date form-control laydate-icon text"  type="text" placeholder="选择年检日期">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>到期日期</th>
                <td>
                    <input name="end_date" value="{$info.end_date??''}"  readonly dom-class="end-date" class="date-time end-date form-control laydate-icon text"  type="text" placeholder="选择到期日期">
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
        //选择车牌号
        $('.select-bus').click(function(){
            var id = $("#bus_id").val();
            layer.open({
                type: 2,
                title: '车牌号选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('check/busSelect','','')}/id/"+id,
            })
        });

    })
</script>
