function search(){
	var name = $("#search-bar").val(); 
	var id = $('#users').find('option[value="' + name + '"]').attr('data-id');
	//console.log(id);
	window.location.href = "../files/profile.php?UserID=" + id;
}