define(function(require, exports, module){
    //引用相关模块
    var $               = require('lib/zepto/zepto'),
        $               = require('lib/zepto/touch'),
        $               = require('lib/zepto/coffee'),
        $               = require('lib/zepto/make-thumb'),
        hammer          = require('units/hammer.js'),
        megapix         = require('units/megapix.js'),
        self            = null;
    $(document).on('touchmove', function (event){
        // event.preventDefault();
    });
    //对外提供接口
    module.exports = {
        //初始化
        init : function () {
            // var self = this;
            this.events();
            this.setImg();
            this.operate();
            this.expression();  // 表情
        },
        events : function(){
            var self = this;
            //提交
            $('.j_q_submit_btn').on('click',function(){
                    var formData = {};
                    var headSrc =  $('div.file').css('background-image'),
                        title   =  $('.j_q_title').val();

                    var productid = $('#productid').val();
                    var relationid = $('#relationid').val();
                    var openid = $('#openid').val();
                    if(title == ''){
                        alert('请填写标题');return false;
                    }
                    if(headSrc=='none'){
                        alert('请上传头图');return false;
                    }else{
                        formData.headimg = headSrc.split(',')[1];
                    }
                    if($('p.j_q_article_editor').text().trim()=='' && $('p.j_q_article_editor').find('img').length==0){
                        alert('请填写正文');return false;
                    }
                    if($(this).hasClass('disable')){
                        alert('帖子已经提交，请耐心等待');return false;
                    }
                    $(this).addClass('disable');
                    formData.productid = productid;
                    formData.relationid = relationid;
                    formData.openid = openid;

                    if(title)
                    formData.comment_title = title;
                    var contP = $('p.j_q_article_editor').clone();
                    formData.images ={};
                    contP.find('img').each(function(k,v){
                        formData.images['img_'+k]=$(this).attr('src').split(',')[1];
                        $(this).attr('src','data://img_'+k);
                    });
                    formData.comment_content = contP.html();
                    var url = "/plugins/index?app=beautyplus&class=wapcomment&method=savenewtopic";
                    $.post(url,formData,function(json){
                        if(json.code==200){
                            location.href = json.locationurl;
                        }
                   },'json');
            });
            // $('.j_q_cancle_btn').on('click',function(){
            //     if($(this).hasClass('disable')){
            //         return false;
            //     }
            //     $(this).addClass('disable');

            //     var productid = $('#productid').val();
            //     var relationid = $('#relationid').val();
            //     var openid = $('#openid').val();
            //     location.href = "/plugins/index?app=beautyplus&class=wapfashion&method=productinfo&productid="+productid+"&relationid="+relationid+"&openid="+openid;
            // });
            // 选择或者更改选择图片
            // $('.J-xupload').on('change' , function (){
            //         console.log('change');

            //     self.imgTarget = $(this).attr('for');
            //     self.html5upload.call(this,self);
            //     $('.J-upload-box').addClass('on');
            // });

            // 取消上传
            $('.J-xcancel').on('tap' , function(){
                $('.J-upload-box').removeClass('on');
                // $('.J-upload-form').get(0).reset();
                $('.J-ximgbox canvas').remove();
            });

            // 提交照片
            $('.J-xsubmit').on('tap' , function(event){
                var canvas = $(".J-ximgbox canvas");
                var mTop = canvas.css('marginTop').split('p')[0];
                var mLeft = canvas.css('marginLeft').split('p')[0];
                var top = canvas.css('top');
                 var w = $('.J-ximgbox').width();
                var h = $('.J-ximgbox').height();
                if(top=="50%"){
                    top = h/2;
                }else{
                    top = top.split('p')[0];
                }
                var left = canvas.css('left');
                 if(left=="50%"){
                    left = w/2;
                }else{
                    left = left.split('p')[0];
                }
                var oh = canvas.height();
                var scale = oh/self.canvas.height;
                var y=0-(Number(top)+Number(mTop));
                var x=0-(Number(left)+Number(mLeft));
                var newCanvas = document.createElement('canvas');
                var imageData = self.context.getImageData(x/scale,y/scale,w/scale,h/scale);
                    newCanvas.width = w/scale;
                    newCanvas.height = h/scale;
                    newCanvas.getContext('2d').putImageData(imageData,0,0);
                    newCanvas.getContext('2d').scale(scale,scale);
                    var blob = newCanvas.toDataURL('image/png');
                    if(self.imgTarget == "head"){
                        $('div.file').css('background-size','100% 100%');
                        $('div.file').css('background-image','url('+blob+')');
                        $('div.file').css('background-position','top left');
                    }else{
                      $(".j_q_article_editor").append('<div class="c-addimg"><img src="'+blob+'"/></div>');
                    }
                   $('a.J-xcancel').trigger('tap');
            });
        },
        setImg : function(){
            var self = this;
            if( $('.J-xupload').length < 1){return;}
            if (/android/i.test(navigator.userAgent)){
                $('.J-xupload').on('change' , function (){
                    self.imgTarget = $(this).attr('for');
                    self.html5upload.call(this, self);
                    $('.J-upload-box').addClass('on');
                });
            }else{
                $('.J-xupload').makeThumb({
                    width: 800,
                    before: function() {
                         $('.m-xbrows').css({'z-index' : -1 , 'opacity' : 0 , 'height' : 0});
                        console.log('before');
                    },
                    done: function(dataURL, blob, tSize, file, sSize, fEvt) { //success
                        self.imgTarget = $(this).attr('for');
                        var thumb = new Image();
                        thumb.onload = function(){
                            self.html5upload.call(this, self);
                            $('.J-upload-box').addClass('on');
                            console.log('onload');
                        };
                        thumb.src = dataURL;
                    },
                    fail: function(file, fEvt) { //error
                        console.log(file, fEvt);
                    },
                    always: function() {
                        //$status.hide();
                    }
                });
            }
        },
        operate : function(){
            var h = $(window).height();
            $('.m-xposted .bequeat p').height(h-510);
        },
        //图片拖拽 放大缩小 旋转
        html5upload : function (self){
            var oImg        = new Image(),
                oFile       = this;
            if (/android/i.test(navigator.userAgent)){
                oFile       = this.files[0];
            }
            //this.files[0];
           // self.oFile= oFile;
            $('.J-ximgbox canvas').remove();
            self.mpImg = new megapix(oFile);
            self.upload(self);
        },
        upload : function (self){
            self.canvas         = document.createElement('canvas');
            self.context        = self.canvas.getContext("2d");
            $('.J-ximgbox').append(self.canvas);
            self.mpImg.render(self.canvas,{ maxWidth: 1000, maxHeight: 1000}, function (){
                $('.J-ximgbox canvas').css({'margin-top':-self.canvas.height / 2 + 'px','margin-left':-self.canvas.width / 2 + 'px'})
                var pic = new Image();
                    pic.src = self.canvas.toDataURL('image/png');
                    pic.onload = function(){
                       self.pic  = pic;
                    }
                self.drag();
                self.zoom();
        });
        },
        drag : function (){
            var aImg = $('.J-ximgbox canvas');
            $('.J-upload-cover').off('touchstart').on('touchstart', function(e){
                tx = this.parentNode.offsetLeft + parseInt(aImg.css('left'));
                ty = this.parentNode.offsetTop + parseInt(aImg.css('top'));
                x = e.touches[0].pageX;
                y = e.touches[0].pageY;
            });
            $('.J-upload-cover').off('touchmove').on('touchmove', function(e){
                e.preventDefault();
                var n = tx + e.touches[0].pageX - x;
                var h = ty + e.touches[0].pageY - y;
                aImg.css({'left':n, 'top': h});
            });
        },
        zoom : function (){
            var self    = this,
                pop     = $('.J-upload-cover'),
                ha      = new hammer(pop[0]),
                width   = self.canvas.width,
                height  = self.canvas.height,
                rotation= 0,
                rr=0;
            ha.on('transform', function(event) {
                    event.preventDefault();
                    w = width * event.gesture.scalee;
                    h = height * event.gesture.scale;
                    $(self.canvas).css({
                        'width' : Math.round(w) + 'px',
                        'height' : Math.round(h) + 'px',
                        'margin-top' :Math.round(-h / 2) + 'px',
                        'margin-left' : Math.round(- w / 2) + 'px'
                        /*'-webkit-transformendansform' : 'rotate(' + ((rotation + event.gesture.rotation) % 360) + 'deg)'*/
                        });
                    rr=(rotation + event.gesture.rotation) % 360;
                });
            ha.on('transformend', function(event) {
            event.preventDefault(); 
                // rotation = (rotation + event.gesture.rotation) % 360;
                rotation=rr;
                width   = parseInt(self.canvas.style.width);
                height  = parseInt(self.canvas.style.height);
                // alert(rotation)
            });
        },
        expression : function(){
            // $.pos(url, {}, function(res) {
            //  var vxface = typeof res != 'string' ? res : $.parseJSON(res);
                var vxface = [[{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/0.gif","value":"\u5fae\u7b11","code":"\/::)"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/1.gif","value":"\u6487\u5634","code":"\/::~"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/2.gif","value":"\u8272","code":"\/::B"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/3.gif","value":"\u53d1\u5446","code":"\/::|"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/4.gif","value":"\u5f97\u610f","code":"\/:8-)"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/5.gif","value":"\u6d41\u6cea","code":"\/::<"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/6.gif","value":"\u5bb3\u7f9e","code":"\/::$"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/7.gif","value":"\u95ed\u5634","code":"\/::X"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/8.gif","value":"\u7761","code":"\/::Z"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/9.gif","value":"\u5927\u54ed","code":"\/::'("},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/10.gif","value":"\u5c34\u5c2c","code":"\/::-|"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/11.gif","value":"\u53d1\u6012","code":"\/::@"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/12.gif","value":"\u8c03\u76ae","code":"\/::P"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/13.gif","value":"\u5472\u7259","code":"\/::D"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/14.gif","value":"\u60ca\u8bb6","code":"\/::O"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/15.gif","value":"\u96be\u8fc7","code":"\/::("},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/16.gif","value":"\u9177","code":"\/::+"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/17.gif","value":"\u51b7\u6c57","code":"\/:--b"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/18.gif","value":"\u6293\u72c2","code":"\/::Q"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/19.gif","value":"\u5410","code":"\/::T"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/20.gif","value":"\u5077\u7b11","code":"\/:,@P"}],[{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/21.gif","value":"\u53ef\u7231","code":"\/:,@-D"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/22.gif","value":"\u767d\u773c","code":"\/::d"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/23.gif","value":"\u50b2\u6162","code":"\/:,@o"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/24.gif","value":"\u9965\u997f","code":"\/::g"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/25.gif","value":"\u56f0","code":"\/:|-)"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/26.gif","value":"\u60ca\u6050","code":"\/::!"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/27.gif","value":"\u6d41\u6c57","code":"\/::L"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/28.gif","value":"\u61a8\u7b11","code":"\/::>"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/29.gif","value":"\u5927\u5175","code":"\/::,@"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/30.gif","value":"\u594b\u6597","code":"\/:,@f"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/31.gif","value":"\u5492\u9a82","code":"\/::-S"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/32.gif","value":"\u7591\u95ee","code":"\/:?"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/33.gif","value":"\u5618","code":"\/:,@x"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/34.gif","value":"\u6655","code":"\/:,@@"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/35.gif","value":"\u6298\u78e8","code":"\/::8"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/36.gif","value":"\u8870","code":"\/:,@!"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/37.gif","value":"\u9ab7\u9ac5","code":"\/:!!!"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/38.gif","value":"\u6572\u6253","code":"\/:xx"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/39.gif","value":"\u518d\u89c1","code":"\/:bye"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/40.gif","value":"\u64e6\u6c57","code":"\/:wipe"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/41.gif","value":"\u62a0\u9f3b","code":"\/:dig"}],[{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/42.gif","value":"\u9f13\u638c","code":"\/:handclap"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/43.gif","value":"\u7cd7\u5927\u4e86","code":"\/:&-("},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/44.gif","value":"\u574f\u7b11","code":"\/:B-)"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/45.gif","value":"\u5de6\u54fc\u54fc","code":"\/:<@"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/46.gif","value":"\u53f3\u54fc\u54fc","code":"\/:@>"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/47.gif","value":"\u54c8\u6b20","code":"\/::-O"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/48.gif","value":"\u9119\u89c6","code":"\/:>-|"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/49.gif","value":"\u59d4\u5c48","code":"\/:P-("},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/50.gif","value":"\u5feb\u54ed\u4e86","code":"\/::\u2019|"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/51.gif","value":"\u9634\u9669","code":"\/:X-)"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/52.gif","value":"\u4eb2\u4eb2","code":"\/::*"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/53.gif","value":"\u5413","code":"\/:@x"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/54.gif","value":"\u53ef\u601c","code":"\/:8*"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/55.gif","value":"\u83dc\u5200","code":"\/:pd"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/56.gif","value":"\u897f\u74dc","code":"\/:"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/57.gif","value":"\u5564\u9152","code":"\/:beer"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/58.gif","value":"\u7bee\u7403","code":"\/:basketb"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/59.gif","value":"\u4e52\u4e53","code":"\/:oo"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/60.gif","value":"\u5496\u5561","code":"\/:coffee"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/61.gif","value":"\u996d","code":"\/:eat"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/62.gif","value":"\u732a\u5934","code":"\/:pig"}],[{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/63.gif","value":"\u73ab\u7470","code":"\/:rose"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/64.gif","value":"\u51cb\u8c22","code":"\/:fade"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/65.gif","value":"\u793a\u7231","code":"\/:showlove"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/66.gif","value":"\u7231\u5fc3","code":"\/:heart"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/67.gif","value":"\u5fc3\u788e","code":"\/:break"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/68.gif","value":"\u86cb\u7cd5","code":"\/:cake"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/69.gif","value":"\u95ea\u7535","code":"\/:li"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/70.gif","value":"\u70b8\u5f39","code":"\/:bome"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/71.gif","value":"\u5200","code":"\/:kn"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/72.gif","value":"\u8db3\u7403","code":"\/:footb"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/73.gif","value":"\u74e2\u866b","code":"\/:ladybug"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/74.gif","value":"\u4fbf\u4fbf","code":"\/:shit"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/75.gif","value":"\u6708\u4eae","code":"\/:moon"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/76.gif","value":"\u592a\u9633","code":"\/:sun"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/77.gif","value":"\u793c\u7269","code":"\/:gift"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/78.gif","value":"\u62e5\u62b1","code":"\/:hug"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/79.gif","value":"\u5f3a","code":"\/:strong"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/80.gif","value":"\u5f31","code":"\/:weak"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/81.gif","value":"\u63e1\u624b","code":"\/:share"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/82.gif","value":"\u80dc\u5229","code":"\/:v"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/83.gif","value":"\u62b1\u62f3","code":"\/:@)"}],[{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/84.gif","value":"\u52fe\u5f15","code":"\/:jj"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/85.gif","value":"\u62f3\u5934","code":"\/:@@"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/86.gif","value":"\u5dee\u52b2","code":"\/:bad"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/87.gif","value":"\u7231\u4f60","code":"\/:lvu"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/88.gif","value":"NO","code":"\/:no"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/89.gif","value":"OK","code":"\/:ok"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/90.gif","value":"\u7231\u60c5","code":"\/:love"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/91.gif","value":"\u98de\u543b","code":"\/:"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/92.gif","value":"\u8df3\u8df3","code":"\/:jump"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/93.gif","value":"\u53d1\u6296","code":"\/:shake"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/94.gif","value":"\u6004\u706b","code":"\/:"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/95.gif","value":"\u8f6c\u5708","code":"\/:circle"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/96.gif","value":"\u78d5\u5934","code":"\/:kotow"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/97.gif","value":"\u56de\u5934","code":"\/:turn"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/98.gif","value":"\u8df3\u7ef3","code":"\/:skip"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/99.gif","value":"\u6325\u624b","code":"[\u6325\u624b]"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/100.gif","value":"\u6fc0\u52a8","code":"\/:#-0"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/101.gif","value":"\u8857\u821e","code":"[\u8857\u821e]"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/102.gif","value":"\u732e\u543b","code":"\/:kiss"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/103.gif","value":"\u5de6\u592a\u6781","code":"\/:<&"},{"url":"http:\/\/res.mail.qq.com\/zh_CN\/images\/mo\/DEFAULT2\/104.gif","value":"\u592a\u6781","code":"\/:&>"}]];
                $.each(vxface, function(i, v) {
                    var arr     = v,
                        ul      = $('.smilies ul'),
                        html    = '<li>';
                    $.each(arr, function(k, o) {
                        if(k > 20) {return;}
                        var url = o.url,
                            val = o.value;
                        html += '<a href="javascript:;" _title="[' + val + ']"><img src="' + url + '" /></a>';
                    })
                    html += '</li>';
                    ul.append(html);
                });
            // })
            $('.J-xbrows').on('touchstart touchend touchmove', function (event){
                event.preventDefault();
            });
            var $doc    = $('body');
            var aupDown = $('.J-xsmilies'),
                iNow    = 0,
                len     = aupDown.find('li'),
                liW     = len.width(),
                iAct    = 0,
                size    = aupDown.find('li').length;
            aupDown.width(liW * size);

            //向左滑动主页面
            aupDown.on('swipeLeft', function(){
                if(iNow != (len.length-1)){
                    iNow++;
                    if( iNow >= len.length ){
                        iNow = len.length - 1;
                    };
                    $(this).animate({ "-webkit-transform":"translateX(" + -iNow*liW + "px)" }, 400 , 'linear', function(){
                        $('.J-xmark i').eq(iNow).addClass('on').siblings().removeClass('on');
                    });
                };
            });

            //向右滑动主页面
            aupDown.on('swipeRight', function(){
                if(iNow != 0){
                    iNow--;
                    if( iNow < 0 ){
                        iNow = 0;
                    };
                    $(this).animate({ "-webkit-transform":"translateX(" + -iNow*liW + "px)" }, 400 , 'linear', function(){
                        $('.J-xmark i').eq(iNow).addClass('on').siblings().removeClass('on');
                    });
                };
            }); 
            $doc.on('tap' , '.J-xaddbrows' , function(){ // 添加表情
                $('.m-xbrows').css({'z-index' : 10 , 'opacity' : 1 , 'height' : 'auto'});
            }).on('tap' , '.J-xsmilies li a' , function(){ // 点击表情
                var $this   = $(this),
                    text    = $this.attr('_title');
                // alert(text) 
                $('.J-xstraight').append(text);
            }).on('tap' , '.J-xfasten' , function(){ // 收起表情
                var $this   = $(this);
                $('.m-xbrows').css({'z-index' : -1 , 'opacity' : 0 , 'height' : 0});
            }).on('focus' , '.J-xstraight' , function(){ // 收起表情
                var $this   = $(this);
                $('.m-xbrows').css({'z-index' : -1 , 'opacity' : 0 , 'height' : 0});
            });
        }
    };
});
