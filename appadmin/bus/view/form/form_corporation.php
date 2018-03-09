
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>归属名称</th>
                <td>
                    <input class="form-control text" type="text" name="name" value="{$info.name??''}" placeholder="归属名称">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>联系人员</th>
                <td>
                    <input class="form-control text" type="text" name="contact" value="{$info.contact??''}" placeholder="联系人员">
                </td>
            </tr>
            <tr>
                <th>联系电话</th>
                <td>
                    <input class="form-control text" type="text" name="phone" value="{$info.phone??''}" placeholder="联系电话">
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
