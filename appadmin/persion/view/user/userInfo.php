{__NOLAYOUT__}
{include file="publics:topCss"}
<div class="container-fluid"  style="padding-top:12px;padding-bottom:50px;">
    <div id="alert"></div>
    <table class="table table-bordered">
           <tbody class="layui-form">
                <tr>
                    <td class="bg-gray">员工编号</td>
                    <td>{$info.num}</td>
                    <td class="bg-gray">员工姓名</td>
                    <td>{$info.name}</td>
                </tr>
                <tr>
                    <td class="bg-gray">员工性别</td>
                    <td>{$info.sex == 1?'男':'女'}</td>
                    <td class="bg-gray">身份证号</td>
                    <td>{$info.code}</td>
                </tr>
                <tr>
                    <td class="bg-gray">手机号码</td>
                    <td>{$info.phone}</td>
                    <td class="bg-gray">员工状态</td>
                    <td>{$info.status == 1?'在职':'离职'}</td>
                </tr>
                <tr>
                    <td class="bg-gray">所属部门</td>
                    <td>{$info.department_name}</td>
                    <td class="bg-gray">所属岗位</td>
                    <td>{$info.level_name}</td>
                </tr>
                <tr>
                    <td class="bg-gray">是否驾驶员</td>
                    <td>{$info.is_drivier == 1?'是':'否'}</td>
                    <td class="bg-gray">是否股东</td>
                    <td>{$info.is_partner == 1?'是':'否'}</td>
                </tr>
                <tr>
                    <td class="bg-gray">入职日期</td>
                    <td>{$info.join_date}</td>
                    <td class="bg-gray">离职日期</td>
                    <td>{$info.out_date}</td>
                </tr>
                <tr>
                    <td class="bg-gray">身份证正面照</td>
                    <td> <img class="mini-image {$info.code_zheng_img?'':'hidden'}"  src="{$info.code_zheng_img?'__ImagePath__'.$info.code_zheng_img:''}"></td>
                    <td class="bg-gray">身份证背面照</td>
                    <td><img class="mini-image {$info.code_fan_img?'':'hidden'}"  src="{$info.code_fan_img?'__ImagePath__'.$info.code_fan_img:''}"></td>
                </tr>
                <tr>
                    <td class="bg-gray">驾驶照</td>
                    <td><img class="mini-image {$info.drive_img?'':'hidden'}" src="{$info.drive_img?'__ImagePath__'.$info.drive_img:''}"></td>
                </tr>
            </tbody>
        </table>
</div>
{include file="publics:bottomJs"}
<style>
    table{
        border:none !important;
    }
    .bg-gray{
        background-color:#f8f8f8;
        width:80px;
    }
</style>