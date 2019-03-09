var checkagree = new Vue({
  el: '#check_agree',
  data: {
    iscur: false
  },
  methods: {
    agreeToggle: function () {
      this.iscur = !this.iscur;
    }
  }
});