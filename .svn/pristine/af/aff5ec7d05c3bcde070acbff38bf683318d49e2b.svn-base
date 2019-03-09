var vmApp = new Vue({
  el: '#app',
  data: {
    msgData: {  //传递到弹窗的数据
      title: '艺术者提示',
      content: '版画信息查询，即将开放~',
      isShowBtns: false
    }
  },
  methods: {
    submit: function () {
      eventBus.$emit('showRemarkBox', this.msgData);
    }
  }
});