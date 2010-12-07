$(document).ready(function(){
	$("form").submit( function() {
		var params = {}; 
		$(this) 
			.find("input[@type='text'], input[@type='password'], select") 
			.filter(":enabled").each(function() { 
				params[ this.name || this.id || this.parentNode.name || this.parentNode.id ] = this.value; 
			}); 
		$.ajax({
			type: "POST",
			url : this.getAttribute("action"), 
			data : params,
			dataType : "json",
			success : function(json){ 
				if (json.type != 1) alert (json.text);
				else
				{
					$("#result").slideDown("slow");
					$("#c").html(json.package.c);
					$("#o").html(json.package.o);
					$("#q").html(json.package.q);
					$("#pcost").html(json.package.pcost);
					$("#ucost").html(json.package.ucost);
					if (json.package.packages != 0)
					{	
						$("#totals").fadeIn("slow");
						$("#packages").html(json.package.packages);
						$("#tc").html(json.package.tc);
						$("#to").html(json.package.to);
						$("#tq").html(json.package.tq);
						$("#tcost").html(json.package.tcost);
					}
				}
			},
			error : function (){ alert("Error contacting server."); }
		});
		$("#result").hide();
		$("#totals").hide();
		return false;				
	});
	$("#howmany, #oprice, #cprice, #grade, #type").keypress(function(){ $("#result").hide(); })
	$("#type").keypress(function(){ $("#span.ore").append($(($("#type").val() == "ss")? "Soul" : "Spirit")); })
});
