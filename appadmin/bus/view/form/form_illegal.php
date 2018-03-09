
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>选择车牌号</th>
                <td>
                    <span class="span-primary select-bus">{$info.num?:'选择车牌号'}</span>
                    <input id="bus_id" class="form-control text" type="hidden" name="bus_id" value="{$info.bus_id??''}">
                </td>
            </tr>
            <tr>
                <th>选择驾驶员</th>
                <td>
                    <span class="span-primary select-user">{$info.name?:'选择驾驶员'}</span>
                    <input id="user_id" class="form-control text" type="hidden" name="user_id" value="{$info.user_id??''}">
                </td>
            </tr>
            <tr>
                <th>违章日期</th>
                <td>
                    <input name="illegal_date" value="{$info.illegal_date??''}"  readonly dom-class="illegal-date" class="date-time illegal-date form-control laydate-icon text"  type="text" placeholder="选择违章日期">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr class="hidden">
                <th>罚款金额</th>
                <td>
                    <input class="form-control text" type="text" name="money" value="{$info.money??''}" placeholder="罚款金额">
                </td>
            </tr>
            <tr>
                <th>违章扣分</th>
                <td>
                    <input class="form-control text" type="text" name="score" value="{$info.score??''}" placeholder="违章扣分">
                </td>
            </tr>
            <tr>
                <th>违章备注</th>
                <td>
                    <textarea name="remark" class="form-control text" placeholder="违章备注">{$info.remark??''}</textarea>
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
        //选择驾驶员
        $('.select-user').click(function(){
            var id = $("#user_id").val();
            layer.open({
                type: 2,
                title: '驾驶员选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('illegal/userSelect','','')}/id/"+id,
            })
        });
        //选择车牌号
        $('.select-bus').click(function(){
            var id = $("#bus_id").val();
            layer.open({
                type: 2,
                title: '车牌号选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('illegal/busSelect','','')}/id/"+id,
            })
        });

    })
</script>
