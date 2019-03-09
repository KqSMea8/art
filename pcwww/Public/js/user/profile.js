var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
    userForm: {//规则字段
      category: [], //画作类型
      color: [], //画作色调
      shape: '', //形状        
      length:'',//画作长度
      width:'',//画作宽度
      diameter: '', //直径
      subject: '', //题材
      style: '', //风格
      story: '', //画作介绍
      fileList1:[],//画作全景图
      fileList2:[]//画作局部图     
    },
    userRules: {//字段规则
      category: [{
        // required: true,
        type: 'array',
        message: '请选择作品类型',
        trigger: 'change'
      }],
      color: [{   
        type: 'array',     
        message: '请填写画作色调',
        trigger: 'change'
      }]
    }
  },
  created: function() {

  },
  mounted: function() {
    
  },
  methods: {
    
  }
});