{__NOLAYOUT__}
{include file="publics:topCss"}
<div class="container-fluid"  style="padding-top:12px;padding-bottom:50px;">
    <div id="alert"></div>
    <table class="table table-bordered">
           <tbody class="layui-form">
                <?php $num = count($userList)%3;?>
                {volist name="$userList" id="v" key="k"}
                    {if $k % 3 == 1}<tr>{/if}
                    <td >
                        <input type="radio" name="user" value="{$v.id}" title="{$v.name}" {$v.id == $id?'checked':''}>
                    </td>
                    {if $k%3 == 0}
                    </tr>
                    {/if}
                {/volist}
                {if $num != 0}
                {for start="0" end="3-$num"}
                <td></td>
                {/for}
                </tr>
                {/if}
            </tbody>
        </table>
        <div class="layer-box-bottom" style="padding-top:0;">
            <span class="btn btn-success layui-off">确定</span>
        </div>
</div>
{include file="publics:bottomJs"}
<style>
    td{
        border:none !important;
    }
    table{
        border:none !important;
    }
</style>
<script>
    $(function(){
        $("table").on("click",".layui-form-radio",function(){
            var id = $(this).prev().val();
            var title = $(this).prev().attr("title");
            {if $fir == 1}
            $(parent.document).find(".now-active .select-fir").text(title).attr("data-id",id);
            $(parent.document).find(".now-active .select-bus").attr("data-fir",id);
            {else}
            $(parent.document).find(".now-active .select-sec").text(title).attr("data-id",id);
            $(parent.document).find(".now-active .select-bus").attr("data-sec",id);
            {/if}
        })
    })
</script>