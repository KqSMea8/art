function User() {
	this.id = 1;
	this.fields = '';
	this.set= function(data){
		this.fields.id=data.id;
		this.fields.name=data.name;
		this.fields.nickname=data.nickname;
		this.fields.mobile=data.mobile;
		this.fields.motto=data.motto;
		this.fields.age=data.age;
		this.fields.gender=data.gender;
		localforage.setItem('user_'+data.id, this.fields).then(function (value) {
			console.log(value);
		}).catch(function(err) {
			console.log(err);
		});
	},
	this.get=function(id){
		alert(id);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "/user/getInfo",	//修改昵称
			type: 'POST',
			dataType: "json",
			data: {id:id},
			async: false,
			success: function(res) {
				console.log("修改昵称.res", res);
				if (res.state == 2000) {
					localforage.setItem('user_'+id, res.data).then(function (value) {
						console.log(value);
					}).catch(function(err) {
						console.log(err);
					});
					this.set(res.data);
				} else {
					console.log(res);
				}
			}
		});
		return this.fields;
	},
	this.modify=function (param){
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "/user/getInfo",	//修改昵称
			type: 'POST',
			dataType: "json",
			data: param,
			success: function(res) {
				if (res.state == 2000) {
					localforage.setItem('user_'+id, res.data).then(function (value) {
						console.log(value);
					}).catch(function(err) {
						console.log(err);
					});
					this.set(res.data);
				} else {
					console.log(res);
				}
			}
		})
	}

}