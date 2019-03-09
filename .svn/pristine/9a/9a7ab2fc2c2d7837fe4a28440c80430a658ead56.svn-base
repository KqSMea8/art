var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
  },
  created: function() {

  },
  mounted: function() {

  },
  methods: {
    
  },
  filters: {
    timeFormat: function(value) {
      value = value * 1000;
      var dateTime = new Date(value);
      console.log(dateTime);
      var year = dateTime.getFullYear();
      var month = dateTime.getMonth() + 1;
      var day = dateTime.getDate();
      var hour = dateTime.getHours();
      var minute = dateTime.getMinutes();
      var second = dateTime.getSeconds();
      var now = new Date();
      var now_new = now.getTime(); //js毫秒数

      var milliseconds = 0;
      var timeSpanStr;

      timeSpanStr = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;

      return timeSpanStr;
    }
  }
});