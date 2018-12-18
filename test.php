<?php


?>
<h3>Enter your name</h3>
<input type="text" id="name">
<div id="hello"></div>
<script>
	var name = 'Azeez';
	var greeting = document.getElementById('hello');
	greeting.textContent = 'Welcome'+ name;
</script>

