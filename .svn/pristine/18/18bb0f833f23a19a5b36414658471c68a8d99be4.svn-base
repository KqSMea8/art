// 获取商品的www.desc.com/mobile/index.php?m=index&a=goods  post请求 传一个cat_id 如 cat_id=1483 （版画商品）page 请求的页数
// 参数   cat_id       page
//
// {"error":0,"data":[{"desc":"\u7248\u753b","sale":"0","stock":"1000","price":"\u00a5123.00","marketPrice":"\u00a5147.61","img":"http:\/\/www.desc.com\/images\/201801\/thumb_img\/0_thumb_G_1516236283109.jpg","link":"\/mobile\/index.php?m=goods&id=969&u=0"},{"desc":"\u65b0\u827a\u672f\u54c1","sale":"0","stock":"1000","price":"\u00a5888.00","marketPrice":"\u00a51065.60","img":"http:\/\/www.desc.com\/images\/201801\/thumb_img\/0_thumb_G_1516127503075.jpg","link":"\/mobile\/index.php?m=goods&id=967&u=0"}],"endtime":"2018-01-19 02:20:18"，'totalPage':1}
//
//
//
//
// 获取app端首页的分类id     post请求且为app端  url：www.desc.com/mobile/index.php
// 参数无
// {error: 0, data: [{cat_id: "1483", cat_name: "版画"}, {cat_id: "1493", cat_name: "原作"}]}

$(function(){
	//辨识版画，，原画

	var isbanhua='';
	var isyuanzuo='';
	$.ajax({
		url:'https://test-mall.artzhe.com/mobile/index.php',
		type:'POST',
		dataType:'json',
		success:function(data){
			// console.log(data)
			$.each(data.data,function(index,val){

				if(val.cat_name=='版画'){
					isbanhua=val.cat_id;
				}else if(val.cat_name=='原作') {
					isyuanzuo=val.cat_id;
				}
			});
		},
		error:function(err){
			console.log(err)
		}
	})
	// getIdentificationSign();
	// function getIdentificationSign(){ // 获取辨识版画，，原画的id
  //
	// }
	var mescroll = new MeScroll("refBox", {
		//上拉加载的配置项
		up: {
			callback: function(){

				if($('.yuanzuo').hasClass('appActive')){

					getMore(isyuanzuo,nowpage)

				}else if($('.banhua').hasClass('appActive')){
					getMore(isbanhua,nowpage)
				}
				// nowPage++;
			}, //上拉回调,此处可简写; 相当于 callback: function (page) { getListData(page); }
			isBounce: false, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
			auto: false,
			noMoreSize: 4, //如果列表已无数据,可设置列表的总数量要大于半页才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看; 默认5
			empty: {
				icon: "../res/img/mescroll-empty.png", //图标,默认null
				tip: "暂无相关数据~", //提示

			},
			clearEmptyId: "HUI_Waterfall", //相当于同时设置了clearId和empty.warpId; 简化写法;默认null
			toTop:{ //配置回到顶部按钮
				src : './public/img/mescroll-totop.png', //默认滚动到1000px显示,可配置offset修改
				offset : 300
			}
		},
		down: {
			callback: function(page){
				// nowpage=1;
				if(nowpage>2){
					nowpage=2;
				}
				refreshBanner();

				if($('.yuanzuo').hasClass('appActive')){
					refreshList(isyuanzuo,1);

				}else if($('.banhua').hasClass('appActive')){
					refreshList(isbanhua,1);
				}

			},
			use: true,
			isBounce: false, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
			noMoreSize: 4, //如果列表已无数据,可设置列表的总数量要大于半页才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看; 默认5
			empty: {
				tip: "暂无相关数据~", //提示
			},
			clearEmptyId: "HUI_Waterfall", //相当于同时设置了clearId和empty.warpId; 简化写法;默认null
		}
	});

	//tab切换
	$('.yuanzuo').on('click',function(){
		nowpage=2;
		$(this).addClass('appActive'); // 点击的当前项加上类
		$('.banhua').removeClass('appActive'); // 另一项移除类

		$('#hui-water-fall-left').html('');
		$('#hui-water-fall-right').html('');
		mescroll.resetUpScroll(true);
		refreshList(isyuanzuo,1);

	});

	$('.banhua').on('click',function(){
		nowpage=2;
		$(this).addClass('appActive'); // 点击的当前项加上类
		$('.yuanzuo').removeClass('appActive'); // 另一项移除类

		$('#hui-water-fall-left').html('');
	$('#hui-water-fall-right').html('');

		mescroll.resetUpScroll(true);
		refreshList(isbanhua,1);

	})

	// banner1
	var mySwiper1 = new Swiper('#swiper1', {
		autoplay: 2000, //可选选项，自动滑动
		loop: true,
		autoplayDisableOnInteraction: false,
		// 如果需要分页器
		pagination: '.pagination1',
		observer:true,//修改swiper自己或子元素时，自动初始化swiper
		observeParents:true,//修改swiper的父元素时，自动初始化swiper
	});
	function bannerGet(){
		$.ajax({
			url:'https://test-mall.artzhe.com/mobile/index.php?m=console&c=view&a=view',
			type:'post',
			data:{
				id:1
			},
			dataType:'json',
			beforeSend:function(){
				hui.loading('加载中...')
			},
			success:function(data){
				mySwiper1.update()
				hui.loading('加载中...',true)
				var strbanner='';
				$.each(data.data.data.list,function(index,val){
					$('.swiper-slide').remove();
					// console.log(val)
					strbanner+='<div class="swiper-slide">'+
						'<a href="'+val.url+'" title="'+val.urlName+'">'+
						'<img src="'+val.img+'"/>'+
						// '<img src="http://test-mall.artzhe.com/data/gallery_album/2/original_img/1515372575956477734.jpg"/>'+
						 // '<div class="bgdiv" style="background-image:url('+val.img+');background-size:contain;background-repeat:no-repeat"></div>'+
						'</a>'+
					'</div>';
				})

				mySwiper1.appendSlide(strbanner); //加到Swiper的最后
				strbanner='';
				// console.log(data.data.data.list)
			},
			error:function(err){
				console.log(err)
			}
		})
	}


var Waterfall = new huiWaterfall('#HUI_Waterfall');


var	nowpage=2;



function refreshBanner(){
	$.ajax({
		url:'https://test-mall.artzhe.com/mobile/index.php?m=console&c=view&a=view',
		type:'post',
		data:{
			id:1
		},
		dataType:'json',
		success:function(data){
			mescroll.endSuccess(); //无参
			mySwiper1.update();
			var strbanner='';
			$.each(data.data.data.list,function(index,val){
				$('.swiper-slide').remove();
				// console.log(val)
				strbanner+='<div class="swiper-slide">'+
					'<a href="'+val.url+'" title="'+val.urlName+'">'+
					'<img src="'+val.img+'"/>'+
					'</a>'+
				'</div>';
			})
			mySwiper1.appendSlide(strbanner); //加到Swiper的最后
			strbanner='';
			// console.log(data.data.data.list)
		},
		error:function(err){
			console.log(err)
			mescroll.endErr();
		}
	});
}

function refreshList(id,page){
	// $('#hui-water-fall-left').html('');
	// $('#hui-water-fall-right').html('');
	$.ajax({
		url:'https://test-mall.artzhe.com/mobile/index.php?m=index&a=goods',
		data:{
			cat_id:id, // 版画商品1483  原作 1488
			page:page,
			number:10
		},
		type:'post',
		dataType:'json',
		success:function(data){
			$('#hui-water-fall-left').html('');
			$('#hui-water-fall-right').html('');
			var str = '';
			// Waterfall.addItems(str);
			$.each(data.data,function(index,val){
				str+='<div class="hui-water-items">'+
					'<div class="grid-item item">'+
							'<a href="'+val.link+'">'+
								'<img src="'+val.img+'" class="item-img" />'+
								'<section class="section-p">'+
									'<div class="clearfix">'+
										'<h5 class="title-p overflow2line">'+val.desc+'</h5>'+
										// '<span class="zhekou" style="display:none;">4.5折</span>'+
									'</div>'+
									'<p class="price-p">'+
										// '<span class="moneyfuhao">¥</span>'+
										'<span class="moneynum">'+val.price+'</span>'+
									'</p>'+
									'<p class="oldpricebox">'+
										'<del class="oldprice">'+val.marketPrice+'</del>'+
										// '<span class="xiaoliang">'+
										// 	'<span>销量</span>'+
										// 	'<span>'+val.sale+'</span>'+
										// '</span>'+
									'</p>'+
								'</section>'+
							'</a>'+
						'</div>'+
						'</div>';
			});
			mescroll.endSuccess(); //有数据就结束
			Waterfall.addItems(str);
			str='';

		},
		error:function(err){
			mescroll.endErr();
			console.log(err)
		}
	})
}


// mescroll 上拉加载
	function getMore(id,page){

		var str = '';
		var allpage;
		$.ajax({
			url:'https://test-mall.artzhe.com/mobile/index.php?m=index&a=goods',
			data:{
				cat_id:id, // 版画商品1483  原作 1488
				page:page,
				number:10
			},
			type:'post',
			dataType:'json',
			success:function(data){
				// console.log('s')
				if(data.data.length<=0){
					// $('.mescroll-upwarp').hide();

					mescroll.hideUpScroll();
					mescroll.endSuccess(); //没有数据也结束
				}
				if( nowpage> data.totalPage){
					return false
				}
				nowpage++;
				allpage = data.totalPage;
				$.each(data.data,function(index,val){
					str+='<div class="hui-water-items">'+
						'<div class="grid-item item">'+
								'<a href="'+val.link+'">'+
									'<img src="'+val.img+'" class="item-img" />'+
									'<section class="section-p">'+
										'<div class="clearfix">'+
											'<h5 class="title-p overflow2line">'+val.desc+'</h5>'+
											// '<span class="zhekou" style="display:none;">4.5折</span>'+
										'</div>'+
										'<p class="price-p">'+
											// '<span class="moneyfuhao">¥</span>'+
											'<span class="moneynum">'+val.price+'</span>'+
										'</p>'+
										'<p class="oldpricebox">'+
											'<del class="oldprice">'+val.marketPrice+'</del>'+
											// '<span class="xiaoliang">'+
											// 	'<span>销量</span>'+
											// 	'<span>'+val.sale+'</span>'+
											// '</span>'+
										'</p>'+
									'</section>'+
								'</a>'+
							'</div>'+
							'</div>';
				});

				Waterfall.addItems(str);
				console.log('end')
				mescroll.endSuccess(); //有数据就结束

			},
			error:function(err){
				console.log(err)
				mescroll.endErr();
			}
		})
	}
})
