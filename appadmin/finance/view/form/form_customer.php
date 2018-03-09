
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            {if empty($info.id)}
            <tr>
                <th>选择客户</th>
                <td>
                    <span class="span-primary select-customer fl">{$info.num?:'选择客户'}</span>
                    <input id="customer_id" class="form-control" type="hidden" name="customer_id" value="">
                </td>
            </tr>
            {else}
            <tr>
                <th>客户</th>
                <td>
                    {$info.name}
                    <input id="customer_id" class="form-control" type="hidden" name="customer_id" value="{$info.id}">
                </td>
            </tr>
            {/if}
            <tr>
                <th>入账类型</th>
                <td class="layui-form">
                    <input type="radio" name="type" value="2" title="还款" checked>
                    <input type="radio" name="type" value="1" title="欠款">
                </td>
            </tr>
            <tr>
                <th>入账金额</th>
                <td>
                    <input class="form-control text" type="text" name="money" value="" placeholder="入账金额">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>入账日期</th>
                <td>
                    <input name="add_date" value="{$info.add_date??''}"  readonly dom-class="check-date" class="date-time check-date form-control laydate-icon text"  type="text" placeholder="选择入账日期">
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
        $('.select-customer').click(function(){
            var id = $("#customer_id").val();
            layer.open({
                type: 2,
                title: '选择客户',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('customer/customerSelect','','')}",
            })
        });

    })
</script>
