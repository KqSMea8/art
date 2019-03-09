new Vue({
  el: '#user-like',

	// components: {
	// 	VueScroller
	// },

	data: {
		page : 0,
		isLoading: true,
		isActive: false,
		hasList:false,
		hasMore:true,
		boxIsShow: false,
		msgBoxIsShow: false,
		list:[]
	},

	mounted: function () {
		this.page = 1;
		this.getData(this.page);

		setTimeout(() => {
			this.$refs.my_scroller.resize();
		})
	},

	methods: {
		refresh: function () {
			setTimeout(() => {
				this.page = 1;
				this.getData(this.page);
				this.$refs.my_scroller.finishPullToRefresh();
			}, 1500)
		},

		infinite: function () {
			setTimeout(() => {
				this.page = this.page + 1;
				this.getData(this.page);
				setTimeout(() => {
					this.$refs.my_scroller.finishInfinite();
				})
			}, 1500)
		},
		hideBox: function() {
			alert('hidbow');
			this.boxIsShow = false;
			this.msgBoxIsShow = false;
		},
		showMsgBox: function(id) {
			this.tempId = id;
			this.boxIsShow = true;
			this.msgBoxIsShow = true;
		},
		cancelLike: function(id) {
			var that = this;
			var data = {
				id: id
			};
			console.log('cancelLike.data', data);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "POST",
				url: "/api/Artwork/unlike",
				data: data,
				success: function(res) {
					
					console.log('cancelLike.res', res);
					if (res.code == 30000) {
						this.msg = 'updated'
						that.list.forEach(function(item) {
							if (item.artworkId == id) {
								Vue.set(item, "unlike", true);
							}
						});
						that.$nextTick(function () {
							console.log('data unlike update ok');
						})
					}else{

					}
				}
			});
		},
		likeArt: function(id) {
			var that = this;
			var data = {
				id: id
			};
			console.log('likeArt.data', data);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "POST",
        url: "/api/Artwork/like",     //喜欢
        data: data,
        success: function(res) {
        	
        	console.log('likeArt.res', res);
        	if (res.code == 30000) {
        		that.list.forEach(function(item) {
        			if (item.artworkId == id) {
        				Vue.set(item, "unlike", false);
        			}
        		});
        		that.$nextTick(function () {
        			console.log('data like update ok');
        		})
        	}
        }
    });
		},
		getData: function (page) {
			var self = this;
			if(self.hasMore){
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "/api/UserCenter/getMyLikeArtworkList",
					type: 'POST',
					dataType: "json",
					data: {page: page,perPageCount:2},
					success: function (res) {
						console.log("消息列表.res", res);
						self.isLoading=false;
						if (res.code == 30000) {
							if(res.data.info.length>0){
								if(page==1){
									self.list = res.data.info;
								}else{
									self.list = self.list.concat(res.data.info);
								}
								self.list.forEach(function(item) {
									Vue.set(item, "unfollow", false);
								});
								self.hasList = true;
							}else{
								self.hasMore = false;
								self.$refs.my_scroller.finishInfinite();
							}
						} else {
							TipsShow.showtips({
								info: res.message
							});
						}
					}
				});
			}

		}
	}
});