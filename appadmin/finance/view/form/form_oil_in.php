
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>油卡名称</th>
                <td>
                    {$info.name}
                    <input class="form-control text" type="hidden" name="oil_id" value="{$info.oil_id??''}">
                </td>
            </tr>
            <tr>
                <th>充值面值</th>
                <td>
                    <input class="form-control text" type="text" name="money" value="{$info.money??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>充值金额</th>
                <td>
                    <input class="form-control text" type="text" name="true_money" value="{$info.true_money??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>充值日期</th>
                <td>
                    <input name="in_date" value="{$info.in_date??''}"  readonly dom-class="end-date" class="date-time end-date form-control laydate-icon text"  type="text">
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
