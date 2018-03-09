
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>单位名称</th>
                <td>
                    <input class="form-control text" type="text" name="name" value="{$info.name??''}" placeholder="单位名称">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>单位类型</th>
                <td>
                    <div class="layui-form select">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="1" {if !empty($info) && $info.type == 1}selected{/if}>4S店</option>
                            <option value="2" {if !empty($info) && $info.type == 2}selected{/if}>油气站</option>
                            <option value="3" {if !empty($info) && $info.type == 3}selected{/if}>车管所</option>
                            <option value="4" {if !empty($info) && $info.type == 4}selected{/if}>保险公司</option>
                            <option value="5" {if !empty($info) && $info.type == 5}selected{/if}>维修店</option>
                            <option value="6" {if !empty($info) && $info.type == 6}selected{/if}>检测站</option>
                        </select>
                    </div>
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
                <th>单位地址</th>
                <td>
                    <input class="form-control text" type="text" name="address" value="{$info.address??''}" placeholder="单位地址">
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
