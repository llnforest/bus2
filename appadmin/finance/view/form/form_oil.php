
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>油卡名称</th>
                <td>
                    <input class="form-control text" type="text" name="name" value="{$info.name??''}" placeholder="油卡名称">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>油卡面值</th>
                <td>
                    <input class="form-control text" type="text" name="money" value="{$info.money??''}" placeholder="油卡面值">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>购买金额</th>
                <td>
                    <input class="form-control text" type="text" name="true_money" value="{$info.true_money??''}" placeholder="购买金额">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>购买日期</th>
                <td>
                    <input name="buy_date" value="{$info.buy_date??''}"  readonly dom-class="check-date" class="date-time check-date form-control laydate-icon text"  type="text" placeholder="选择购买日期">
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

