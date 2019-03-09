Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

// 订单列表组件
Vue.component('order-list', {
  template: '\
      <div class="orderlist-wrap">\
                <ul v-if="listInfo.list.length > 0" class="orderlist" v-loading.body="isLoading">\
                  <li v-for="orderItem in listInfo.list" class="orderitem">\
                    <div class="base-wrap">\
                      <span class="date">{{orderItem.date}}</span>\
                      <span class="order-num">订单号：{{orderItem.order_sn}}</span>\
                      <span class="order-type fr">{{order_status[orderItem.order_status]}}，{{pay_status[orderItem.pay_status]}}，{{shipping_status[orderItem.shipping_status]}}</span>\
                    </div>\
                    <div class="main-wrap clearfix">\
                      <ul>\
                        <li v-for="goodsItem in orderItem.goods_list" class="order-content fl">\
                          <img class="cover" :src="goodsItem.goods_thumb" alt="goodsItem.goods_name">\
                          <div class="order-con">\
                            <h3 class="title ellipsis">{{goodsItem.goods_name}}</h3>\
                            <!-- <p class="update-time ellipsis">更新1次创作花絮</p> -->\
                          </div>\
                        </li>\
                      </ul>\
                      <div class="price-wrap fr">\
                        <!-- <p class="need"><span class="col1">还需付款：</span><span class="col2">￥4800.00</span></p> -->\
                        <p class="total"><span class="col1">总价：</span><span v-if="orderItem.pay_status != 2" class="col2">￥{{orderItem.order_amount}}</span><span v-if="orderItem.pay_status == 2" class="col2">￥{{orderItem.money_paid}}</span></p>\
                        <!-- <p class="payed"><span class="col1">已付定金：</span><span class="col2">￥200.00</span></p> -->\
                      </div>\
                    </div>\
                    <div v-if="(orderItem.order_status == 0 || orderItem.order_status == 1) && orderItem.pay_status == 0" class="pay-wrap clearfix">\
                      <!-- <p class="rest fl">24小时内未付款完成，定金将不退还，剩余<span class="time">23:34:34</span></p> -->\
                      <div class="btn-wrap fr">\
                        <a target="_blank" :href="\'/Api/mall/webllpay?order_id=\' + orderItem.order_id" class="btn-pay">立即付款</a>\
                      </div>\
                    </div>\
                  </li>\
                </ul>\
                <div class="upload-page el-pagination" v-if="listInfo.maxpage > 1">\
                  <button type="button"  :class="[ listInfo.page == 1 ? \'disabled\' : \'\',\'btn-prev\']" @click="pagePrev()" >&lt;</button>\
                  <span class="upload-num" >{{listInfo.page}}/{{listInfo.maxpage}}</span>\
                  <button type="button" :class="[ listInfo.page == listInfo.maxpage ? \'disabled\' : \'\',\'btn-next\']" @click="pageNext()" >&gt;</button>\
                  <span class="el-pagination__jump "><input type="number" min="1" number="true" v-model="inputpage" class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="gotoPage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>\
                </div>\
                <div v-if="listInfo.list.length == 0 && !isGetingData" class="order-holder">\
                  <img src="data:image/png;base64,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" class="order-holder-img">\
                  <p class="order-holder-txt">暂时木有内容呀~~</p>\
                </div>\
              </div>\
      ',
  data: function () {
    return {
      isLoading: false,
      isGetingData: true, //是否正在获取订单数据
      listInfo: {
        list: [],
        page: 1,
        pagesize:5,
        maxpage:1,
        total: -1,
        pending: 8,
        received: 8
      },
      inputpage: '',
      order_status: {
        '0': '未确认',
        '1': '已确认',
        '2': '已取消',
        '3': '无效',
        '4': '退货',
        '5': '已确认'
      },
      shipping_status: {
        '0': '未发货',
        '1': '已发货',
        '2': '已收货',
        '3': '配货中',
        '4': '部分商品已发货'
      },
      pay_status: {
        '0': '未付款',
        '1': '付款中',
        '2': '已付款',
        '3': '部分付款'
      }
    };
  },
  props: ['activeType'],
  created: function() {
    this.getData();
  },
  watch: {
    activeType: function () {
      this.getData();
    }
  },
  mounted: function() {
  },
  methods: {
    getData: function (page) {
      var that = this;
      var api = '/Api/Mall/OrderList'; //获取订单列表
      var type = '';
      if (this.activeType == 0) { //全部订单
        type = '';
      } else if (this.activeType == 1) { //待付款
        type = 'toBe_pay';
      } else if (this.activeType == 2) { //待收货
        type = 'toBe_confirmed';
      }
      var data = {
        page: page ? page : 1,
        pagesize: 5,
        type: type
      };
      that.isLoading = true;
      that.isGetingData = true;
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            resInfo.list.forEach(function (item) {
              item.date = formatDate(new Date(item.add_time*1000), 'YYYY-MM-DD');
              item.goods_list.forEach(function (goodItem) {
                if (goodItem.goods_thumb.indexOf('//') === -1) {
                  goodItem.goods_thumb = switchDomin('mall') + '/' + goodItem.goods_thumb;
                }
              });
            });
            that.listInfo = resInfo;
          }
        },
        complete: function () {
          that.isLoading = false;
          that.isGetingData = false;
        }
      });
    },
    pagePrev: function () {
      if (this.listInfo.page <= 1) return;
      this.getData(--this.listInfo.page);
    },
    pageNext: function () {
      if (this.listInfo.page >= this.listInfo.maxpage) return;
      this.getData(++this.listInfo.page);
    },
    gotoPage: function () { 
      if (this.inputpage > this.listInfo.maxpage || this.inputpage < 1) {
        this.$message({
          message: '请输入正确的页码'
        });
        return false;
      }
      this.getData(this.inputpage);
    }
  }
});

var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
    compress: compress, //图片压缩后缀
    active: 0,
    mall_orders: {
      order_all: '',
      order_toBe_confirmed: '',
      order_toBe_pay: ''
    },
    // currentView: 'order-list',
    tabs: [{
      type: '全部订单',
      num: ''
      // view: 'order-list'
    }, {
      type: '待付款',
      num: ''
      // view: 'order-list'
    }, {
      type: '待收货',
      num: ''
      // view: 'order-list'
    }]
  },
  created: function() {

  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.init(info);
    }.bind(this));
  },
  methods: {
    init: function (info) {
      this.tabs[0].num = info.mall_orders.order_all;
      this.tabs[1].num = info.mall_orders.order_toBe_pay;
      this.tabs[2].num = info.mall_orders.order_toBe_confirmed;
      this.mall_orders = info.mall_orders;
    },
    toggle: function (index, view) {
      this.active = index;
      this.currentView = view;
    }
  }
});