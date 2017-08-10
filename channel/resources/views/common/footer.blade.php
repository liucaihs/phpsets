</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var navType=$(".col-md-10").attr("data-nav");
        if (navType != "" && navType != undefined) {
            $("#"+ navType ).addClass("in");
        }
        gooleraccont();
    });

    function gooleraccont(){
    	$.ajax({
	        url:"{{url('/login/account')}}",
	        type:'get',
	        dataType: "json",
	        success: function(data){
	            // console.log(data);
	            $("#gooleraccont").val(data[0].name);
	        },
	        beforeSend: function(){

	        },
	        complete: function(xhr, st){

	        },
	        error : function(xhr){
	            alert('ajax error');
	        }
	    });
    }
</script>

</body>
</html>