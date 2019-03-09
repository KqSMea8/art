new Vue({
  el: '#user-fans',

  // components: {
  //   VueScroller
  // },

  data: {
    page: 0,
    isLoading: true,
    hasFans: false,
    hasMore: true,
    list: []
  },

  mounted: function() {
    // this.page = 1;
    // this.getData(this.page);

    // setTimeout(() => {
    // 	this.$refs.my_scroller.resize();
    // })
  },

  methods: {
    refresh: function() {
      this.page = 1;
      this.hasMore = true;
      this.getData(this.page);
    },

    infinite: function() {
      this.page = this.page + 1;
      this.getData(this.page);
    },
    getData: function(page) {
      var self = this;
      if (self.hasMore) {
        artzheAgent.call('UserCenter/getMyFollowList', {
            page: page,
            perPageCount: 10
          }, //获取粉丝列表
          function(res) {
            // console.log('获取粉丝列表.res', res);
            self.isLoading = false;
            if (res.code == 30000) {
              if (res.data.info.length > 0) {
                if (page == 1) {
                  self.list = res.data.info;
                  self.$refs.my_scroller.finishPullToRefresh();
                } else {
                  self.list = self.list.concat(res.data.info);
                }
                self.hasFans = true;
                self.$refs.my_scroller.finishInfinite();
              } else {
                if (page == 1) {
                  self.hasFans = false;
                }
                self.hasMore = false;
                self.$refs.my_scroller.finishInfinite(true);
              }
              self.$nextTick(function() {
                self.$refs.my_scroller.resize();
              });
            } else {
              TipsShow.showtips({
                info: res.message
              });
            }
          }
        );


        // $.ajax({
        // 	headers: {
        // 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // 	},
        // 	url: "/api/UserCenter/getMyFollowList",
        // 	type: 'POST',
        // 	dataType: "json",
        // 	data: {page: page,perPageCount:10},
        // 	success: function (res) {
        // 		console.log("粉丝列表.res", res);
        // 		self.isLoading=false;
        // 		if (res.code == 30000) {
        // 			if(res.data.info.length>0){
        // 				if(page==1){
        // 					self.list = res.data.info;
        //               self.$refs.my_scroller.finishPullToRefresh();
        // 				}else{
        // 					self.list = self.list.concat(res.data.info);
        // 				}
        // 				self.hasFans = true;
        // 				self.$refs.my_scroller.finishInfinite();
        // 			}else{
        // 				if (page == 1) {
        // 					self.hasFans = false;
        // 				}
        // 				self.hasMore = false;
        // 				self.$refs.my_scroller.finishInfinite(true);
        // 			}
        // 			self.$nextTick(function () {
        //           self.$refs.my_scroller.resize();
        //         });
        // 		} else {
        // 			TipsShow.showtips({
        // 				info: res.message
        // 			});
        // 		}
        // 	}
        // });
      } else {
        this.$refs.my_scroller.finishInfinite(true);
      }

    }
  }
});