//variabel global
var action_url = '';

function set_url_bulan(url){
	//set url action
	this.action_url = url;
}

function get_bulan(){
	//inisialisai variabel
	var input_tahun= $("select#tahun").val();
	
	//mengirim data dengan metode post dengan fungsi ajax
	$.ajax({
		type: "POST",
		url: this.action_url,
		data : {tahun : input_tahun},
		success: function(msg){
		$("#bulan").html(msg);
		},
		dataType:"html"
	});
	return false;
}
