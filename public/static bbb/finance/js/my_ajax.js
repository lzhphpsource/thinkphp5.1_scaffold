/**
 * Created by 28177 on 2018/8/9.
 */
function bindSubmit(a, b, d, c) {
    $(a).ajaxSubmit({
        url: b,
        type: d,
        data: {
            data: c
        },
        success: function(a, b) {
            if( a.code == 1  ){
                parent.layer.open({
                    type: 1,
                    title: !1,
                    closeBtn: 0,
                    scrollbar: !1,
                    shade: 0,
                    time: 2E3,
                    offset: "50px",
                    shift: 5,
                    content: '<div style="width:8rem;height:4rem;line-height:4rem;text-align:center;position:fixed;left:50%;top:20%;margin-left:-4rem;background-color:#fff;color:#FF2244;border:2px solid #FF2244;border-radius:0.2rem;z-index:100001;font-size:14px;">' + a.msg + "</div>"
                });
                setTimeout(function(){
                    $("#btnSubmit").attr("disabled",false);
                },2E3);
                a.url && "" != a.url && setTimeout(function() {
                        location.href = a.url;
                    },
                    2E3);
            }else{
                parent.layer.open({
                    type: 1,
                    title: !1,
                    closeBtn: 0,
                    scrollbar: !1,
                    shade: 0,
                    time: 2E3,
                    offset: ["50px", "100%"],
                    shift: 5,
                    // content: '<div class=" " style="width:350px;height:100px;text-align:center;position:fixed;right:35px;background-color:#D84C31;color:#fff;z-index:100001;box-shadow:1px 1px 5px #333;-webkit-box-shadow:1px 1px 5px #333;font-size:14px;">' + a.msg + "</div>"
                    content: '<div style="width:8rem;height:4rem;line-height:4rem;text-align:center;position:fixed;left:50%;top:20%;margin-left:-4rem;background-color:#fff;color:#FF2244;border:2px solid #FF2244;border-radius:0.2rem;z-index:100001;font-size:14px;">' + a.msg + "</div>"

                });
                setTimeout(function(){
                    $("#btnSubmit").attr("disabled",false);
                },2E3);
            }
        }
    })
}

//返回到上一页
function goBack(){
    window.history.go(-1);
}
