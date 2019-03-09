$(function() {
  var today = new Date();

  function showDate(objD) {
    var str, colorhead, colorfoot;
    var yy = objD.getYear();
    if (yy < 1900) yy = yy + 1900;
    var MM = objD.getMonth() + 1;
    var dd = objD.getDate();
    str = "本协议自" + yy + "年" + MM + "月" + dd + "日（北京时间）起生效。";
    return (str);
  }
  document.getElementById("today").innerHTML = showDate(today);
});

var vmApp = new Vue({
  el: '#app',
  data: {
    
  },
  created: function() {

  },
  mounted: function() {

  },
  methods: {
    
  }
});