var vmApp = new Vue({
  el: '#app',
  data: {
    num: '4',
  },
  mounted: function () {
    this.countdown();
  },
  methods: {
    countdown: function () {
      var that = this;
      this.num--;
      if (this.num == 0) {
        window.location.href = "/index";
      }
      setTimeout(function() {
        that.countdown();
      }, 1000);
    },
    goToHome: function () {
      window.location.href = "/index";
    }
  }
});