
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>员工编号</th>
                <td>
                    <input class="form-control text" type="text" name="num" value="{$info.num??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>员工姓名</th>
                <td>
                    <input class="form-control text" type="text" name="name" value="{$info.name??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>手机号码</th>
                <td>
                    <input class="form-control text" type="text" name="phone" value="{$info.phone??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>员工状态</th>
                <td class="layui-form">
                    <input type="checkbox" data-name="status" lay-skin="switch" lay-text="正常|离职" {$info.status == 2?'':'checked'} data-value="1|2">
                </td>
            </tr>
            <tr>
                <th>员工性别</th>
                <td class="layui-form">
                    <input type="radio" name="sex" {$info.sex==2?'':'checked'} value="1" title="男">
                    <input type="radio" name="sex" {$info.sex==2?'checked':''} value="2" title="女">
                </td>
            </tr>
            <tr>
                <th>身份证号</th>
                <td>
                    <input class="form-control text" type="text" name="code" value="{$info.code??''}">
                </td>
            </tr>
            <tr>
                <th>所属部门</th>
                <td>
                    <div class="layui-form select">
                        <select name="department_id" class="form-control" lay-verify="">
                            {foreach $department as $v}
                            <option value="{$v.id}" {if !empty($info['department_id']) && $info.department_id == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <th>所属岗位</th>
                <td>
                    <div class="layui-form select">
                        <select name="level_id" class="form-control" lay-verify="">
                            {foreach $level as $v}
                            <option value="{$v.id}" {if !empty($info['level_id']) && $info.level_id == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <th>驾驶员</th>
                <td class="layui-form">
                    <input type="checkbox" data-name="is_driver" lay-skin="switch" lay-text="是|否" {$info.is_driver === 0?'':'checked'} data-value="1|0">
                </td>
            </tr>
            <tr>
                <th>是否股东</th>
                <td class="layui-form">
                    <input type="checkbox" data-name="is_partner" lay-skin="switch" lay-text="是|否" {$info.is_partner == 1?'checked':''} data-value="1|0">
                </td>
            </tr>
            <tr>
                <th>入职日期</th>
                <td>
                    <input name="join_date" value="{$info.join_date??''}"  readonly dom-class="date-join" class="date-time date-join form-control laydate-icon text"  type="text">
                </td>
            </tr>
            <tr>
                <th>离职日期</th>
                <td>
                    <input name="out_date" value="{$info.out_date??''}"  readonly dom-class="date-out" class="date-time date-out form-control laydate-icon text"  type="text">
                </td>
            </tr>
            <tr>
                <th>身份证正面照</th>
                <td>
                    <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('index/upload/image',['type'=>'code'])}'}">
                        <i class="layui-icon">&#xe67c;</i>上传正面照
                        <input class="image" type="hidden" name="code_zheng_img" value="{$info.code_zheng_img??''}">
                        <img class="mini-image {$info.code_zheng_img?'':'hidden'}" data-path="__ImagePath__" src="{$info.code_zheng_img?'__ImagePath__'.$info.code_zheng_img:''}">
                    </button>
                </td>
            </tr>
            <tr>
                <th>身份证背面照</th>
                <td>
                    <button type="button" class="layui-btn upload" lay-data="{'url': '{:url('index/upload/image',['type'=>'code'])}',accept:'images'}">
                        <i class="layui-icon">&#xe67c;</i>上传背面照
                        <input class="image" type="hidden" name="code_fan_img" value="{$info.code_fan_img??''}">
                        <img class="mini-image {$info.code_fan_img?'':'hidden'}" data-path="__ImagePath__" src="{$info.code_fan_img?'__ImagePath__'.$info.code_fan_img:''}">
                    </button>
                </td>
            </tr>
            <tr>
                <th>驾驶照</th>
                <td>
                    <button type="button" class="layui-btn upload" lay-data="{'url': '{:url('index/upload/image',['type'=>'code'])}',accept:'images'}">
                        <i class="layui-icon">&#xe67c;</i>上传驾驶照
                        <input class="image" type="hidden" name="drive_img" value="{$info.drive_img??''}">
                        <img class="mini-image {$info.drive_img?'':'hidden'}" data-path="__ImagePath__" src="{$info.drive_img?'__ImagePath__'.$info.drive_img:''}">
                    </button>
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
