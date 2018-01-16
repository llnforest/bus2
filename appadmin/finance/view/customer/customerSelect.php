{__NOLAYOUT__}
{include file="publics:topCss"}
<div class="container-fluid"  style="padding-top:12px;padding-bottom:50px;">
    <div id="alert"></div>
    <table class="table table-bordered">
           <tbody class="layui-form">
                <?php $num = count($customerList)%3;?>
                {volist name="$customerList" id="v" key="k"}
                    {if $k % 3 == 1}<tr>{/if}
                    <td >
                        <input type="radio" name="bus" value="{$v.id}" title="{$v.name}">
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
            $(parent.document).find("#customer_id").val(id);
            $(parent.document).find(".select-customer").text(title);
        })
    })
</script>