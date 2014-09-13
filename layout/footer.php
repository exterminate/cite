	</div><!-- end of wrapper class -->	
</div><!-- end of ultimatewrap class -->	
<footer>
	<p>&copy; 2014 Cite.pub</p>
</footer>

<script>
	$(document).ready(function(){
		$('#loginTrigger').on('click', function(){
			$(".loginForm").css("display","block");
		});
		$('#loginTurnOff').on('click', function(){
			$(".loginForm").css("display","none");
		});
		$("#registerForm").on('click', function(){
			$(".loginForm").css("display","none");
		});
	});
	
</script>

</body>
</html>
