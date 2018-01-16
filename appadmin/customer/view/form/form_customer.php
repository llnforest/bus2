
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>客户名称</th>
                <td>
                    <input class="form-control text" type="text" name="name" value="{$info.name??''}">
                    <input class="form-control text" type="hidden" name="skip_type" value="{$skip_type??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>客户属性</th>
                <td class="layui-form">
                    <input type="radio" name="user_type" {if !isset($info.user_type) || $info.user_type == 1}checked{/if} value="1" title="公司">
                    <input type="radio" name="user_type" {$info.user_type == 2?'checked':''}  value="2" title="个人">
                </td>
            </tr>
            <tr>
                <th>客户姓名</th>
                <td>
                    <input class="form-control text" type="text" name="user_name" value="{$info.user_name??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>客户类型</th>
                <td class="layui-form">
                    <input type="radio" name="type" {if !isset($info.type) || $info.type == 1}checked{/if} value="1" title="合作客户">
                    <input type="radio" name="type" {$info.type == 2?'checked':''}  value="2" title="临时客户">
                </td>
            </tr>
            <tr>
                <th>联系电话</th>
                <td>
                    <input class="form-control text" type="text" name="phone" value="{$info.phone??''}">
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
